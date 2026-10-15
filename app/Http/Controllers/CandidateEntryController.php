<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

/** Admin adds candidates directly (basic details only), e.g. for an assessment test. */
class CandidateEntryController extends Controller
{
    private const MAX_ROWS = 100;

    public function create()
    {
        return view('settings.candidates.create', [
            'batches' => Batch::orderBy('name')->pluck('name'),
            'maxRows' => self::MAX_ROWS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'batch_no' => ['required', Rule::exists('batches', 'name')],
            'password_mode' => ['required', Rule::in(['common', 'auto'])],
            'password' => ['nullable', 'required_if:password_mode,common', 'string', 'min:8', 'max:100'],
            'shortlist' => ['nullable', 'boolean'],
            'rows' => ['required', 'array', 'max:'.self::MAX_ROWS],
            'rows.*.name' => ['nullable', 'string', 'max:255'],
            'rows.*.email' => ['nullable', 'string', 'max:255'],
            'rows.*.contact_number' => ['nullable', 'string', 'max:30'],
            'rows.*.cnic_number' => ['nullable', 'string', 'max:30'],
        ]);

        // Keep only filled rows; report problems with the visible row number.
        $rows = [];
        $errors = [];
        $seen = [];
        foreach ($data['rows'] as $i => $row) {
            $name = trim($row['name'] ?? '');
            $email = Str::lower(trim($row['email'] ?? ''));
            if ($name === '' && $email === '') {
                continue;
            }

            $n = $i + 1;
            if ($name === '' || $email === '') {
                $errors[] = "Row {$n}: both name and email are required.";
            } elseif (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Row {$n}: '{$email}' is not a valid email.";
            } elseif (isset($seen[$email])) {
                $errors[] = "Row {$n}: '{$email}' is repeated in this list.";
            } else {
                $seen[$email] = true;
                $rows[] = [
                    'name' => $name,
                    'email' => $email,
                    'contact_number' => trim($row['contact_number'] ?? '') ?: null,
                    'cnic_number' => trim($row['cnic_number'] ?? '') ?: null,
                ];
            }
        }

        if ($seen) {
            $taken = User::whereIn('email', array_keys($seen))->pluck('email')->all();
            foreach ($taken as $email) {
                $errors[] = "'{$email}' already has an account.";
            }
        }
        if (! $rows && ! $errors) {
            $errors[] = 'Add at least one candidate.';
        }
        if ($errors) {
            throw ValidationException::withMessages(['rows' => $errors]);
        }

        $shortlist = $request->boolean('shortlist');
        $common = $data['password_mode'] === 'common' ? Hash::make($data['password']) : null;
        $created = [];

        DB::transaction(function () use ($rows, $data, $shortlist, $common, &$created) {
            foreach ($rows as $row) {
                $plain = $common ? $data['password'] : Str::password(10, true, true, false, false);

                $user = new User($row + [
                    'password' => $common ?? Hash::make($plain),
                    'batch_no' => $data['batch_no'],
                    'profile_status' => 1,
                    'status' => $shortlist ? 'Shortlisted' : 'Pending',
                ]);
                $user->forceFill(['email_verified_at' => now()])->save();
                $user->assignRole('Intern');

                if ($shortlist) {
                    Comment::create([
                        'user_id' => $user->id,
                        'user_id_comment_by' => auth()->id(),
                        'comments' => 'Shortlisted when added from Settings',
                        'status' => 'Shortlisted',
                    ]);
                }

                $created[] = ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'password' => $plain];
            }
        });

        // Passwords are only shown once, on the next page.
        session()->put('created_candidates', ['batch' => $data['batch_no'], 'shortlisted' => $shortlist, 'rows' => $created]);

        return to_route('settings.candidates.created');
    }

    public function created()
    {
        $result = session()->pull('created_candidates');
        if (! $result) {
            return to_route('settings.candidates.create')->with('error', 'Nothing to show. Passwords are displayed only once, right after adding.');
        }

        return view('settings.candidates.created', $result);
    }
}
