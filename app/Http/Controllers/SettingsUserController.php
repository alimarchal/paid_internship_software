<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/** Settings > Users: list, add and edit accounts. Accounts are never deleted from here. */
class SettingsUserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array($request->query('per_page'), ['10', '50', '100', 'all'], true) ? $request->query('per_page') : '50';

        $query = QueryBuilder::for(User::with('roles'), $request)
            ->allowedFilters(
                AllowedFilter::exact('id'),
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::exact('batch_no'),
                // staff = admin + Super-Admin (the default view); all; or one role name
                AllowedFilter::callback('role', function ($q, $v) {
                    $v = is_array($v) ? implode(',', $v) : $v;
                    match ($v) {
                        'all' => null,
                        'staff' => $q->role(['admin', 'Super-Admin']),
                        default => $q->role($v),
                    };
                })->default('staff'),
                AllowedFilter::callback('search', function ($q, $v) {
                    $v = is_array($v) ? implode(',', $v) : $v;
                    $q->where(fn ($w) => $w->where('name', 'like', "%{$v}%")->orWhere('email', 'like', "%{$v}%")->orWhere('id', $v));
                }),
            )
            ->allowedSorts('id', 'name', 'email', 'created_at')
            ->defaultSort('name');

        $users = $perPage === 'all' ? $query->get() : $query->paginate((int) $perPage)->withQueryString();

        return view('settings.users.index', [
            'users' => $users,
            'paginated' => $perPage !== 'all',
            'perPage' => $perPage,
            'roles' => Role::orderBy('name')->pluck('name'),
            'batches' => Batch::names(),
            'counts' => [
                'staff' => User::role(['admin', 'Super-Admin'])->count(),
                'Intern' => User::role('Intern')->count(),
                'all' => User::count(),
            ],
        ]);
    }

    public function create()
    {
        return view('settings.users.form', ['user' => new User(), 'roles' => Role::orderBy('name')->pluck('name'), 'batches' => Batch::names()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $user = new User(collect($data)->except(['role', 'password'])->filter(fn ($v, $k) => $k !== 'batch_no' || $v)->all() + ['password' => \Hash::make($data['password']), 'profile_status' => 1]);
        $user->forceFill(['email_verified_at' => now()])->save();
        $user->syncRoles([$data['role']]);

        return to_route('settings.users.edit', $user)->with('success', 'User added.');
    }

    public function edit(User $user)
    {
        return view('settings.users.form', ['user' => $user->load('roles'), 'roles' => Role::orderBy('name')->pluck('name'), 'batches' => Batch::names()]);
    }

    public function update(Request $request, User $user)
    {
        $data = $this->validated($request, $user);

        $currentRole = $user->roles->first()?->name;
        if ($currentRole !== $data['role']) {
            if ($user->id === auth()->id()) {
                throw ValidationException::withMessages(['role' => 'You cannot change your own role.']);
            }
            if ($currentRole === 'Super-Admin' && User::role('Super-Admin')->count() <= 1) {
                throw ValidationException::withMessages(['role' => 'This is the only Super-Admin, so the role cannot be changed.']);
            }
        }

        $update = collect($data)->except(['role', 'password'])->filter(fn ($v, $k) => $k !== 'batch_no' || $v)->all();
        if (! empty($data['password'])) {
            $update['password'] = \Hash::make($data['password']);
        }

        $user->update($update);
        $user->syncRoles([$data['role']]);

        return back()->with('success', 'User updated.');
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'max:100'],
            'role' => ['required', Rule::exists('roles', 'name')],
            'contact_number' => ['nullable', 'string', 'max:30'],
            'cnic_number' => ['nullable', 'string', 'max:30'],
            'batch_no' => ['nullable', Rule::exists('batches', 'name')],
        ]);
    }
}
