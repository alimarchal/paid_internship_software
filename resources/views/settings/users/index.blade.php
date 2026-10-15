@php
    $sel = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full';
    $f = request('filter', []);
    $f = is_array($f) ? $f : [];
    $role = $f['role'] ?? 'staff';
    $tabs = ['staff' => ['Staff (admin)', $counts['staff']], 'Intern' => ['Candidates', $counts['Intern']], 'all' => ['All users', $counts['all']]];
    $tabUrl = fn ($key) => request()->fullUrlWithQuery(['filter' => array_merge($f, ['role' => $key]), 'page' => null]);
    $hasFilters = collect($f)->except('role')->contains(fn ($v) => $v !== null && $v !== '');
    $sort = request('sort', 'name');
    $sortUrl = fn ($field) => request()->fullUrlWithQuery(['sort' => $sort === $field ? '-'.$field : $field, 'page' => null]);
    $mark = fn ($field) => $sort === $field ? ' ▲' : ($sort === '-'.$field ? ' ▼' : '');
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Users" :createRoute="route('settings.users.create')" createLabel="Add User" :showSearch="true" backRoute="settings.index"/>
    </x-slot>

    <x-filter-section :action="route('settings.users.index')" :open="$hasFilters">
        <input type="hidden" name="filter[role]" value="{{ $role }}">
        <input type="hidden" name="per_page" value="{{ $perPage }}">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <x-label for="f_search" value="Search (name / email / ID)"/>
                <x-input id="f_search" name="filter[search]" type="text" class="mt-1 block w-full" value="{{ $f['search'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_name" value="Name"/>
                <x-input id="f_name" name="filter[name]" type="text" class="mt-1 block w-full" value="{{ $f['name'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_email" value="Email"/>
                <x-input id="f_email" name="filter[email]" type="text" class="mt-1 block w-full" value="{{ $f['email'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_batch" value="Batch (candidates)"/>
                <select id="f_batch" name="filter[batch_no]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($batches as $b) <option value="{{ $b }}" @selected(($f['batch_no'] ?? '') === $b)>{{ $b }}</option> @endforeach
                </select>
            </div>
        </div>
    </x-filter-section>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-16">
        <div class="mt-4"><x-status-message/></div>

        <div class="mt-4 flex flex-wrap items-center gap-2">
            @foreach($tabs as $key => [$label, $count])
                <a href="{{ $tabUrl($key) }}" class="px-3 py-1.5 rounded-full text-sm border {{ $role === $key ? 'bg-blue-950 text-white border-blue-950' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                    {{ $label }} <span class="ml-1 text-xs opacity-75">{{ number_format($count) }}</span>
                </a>
            @endforeach
            <span class="ml-auto flex items-center gap-2 text-xs text-gray-600">
                Show
                <select id="per-page" class="border-gray-300 rounded-md shadow-sm text-xs py-1 pr-8">
                    @foreach([10, 50, 100, 'all'] as $n)
                        <option value="{{ $n }}" @selected((string) $perPage === (string) $n)>{{ $n === 'all' ? 'All' : $n }}</option>
                    @endforeach
                </select>
                per page
            </span>
        </div>

        <div class="mt-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="relative overflow-x-auto rounded-lg">
                <table class="min-w-max w-full table-auto text-sm">
                    <thead>
                    <tr class="bg-green-800 text-white uppercase text-sm">
                        <th class="py-2 px-3 text-left"><a href="{{ $sortUrl('id') }}">ID{{ $mark('id') }}</a></th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('name') }}">Name{{ $mark('name') }}</a></th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('email') }}">Email{{ $mark('email') }}</a></th>
                        <th class="py-2 px-2 text-left">Role</th>
                        <th class="py-2 px-2 text-left">Batch</th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('created_at') }}">Added{{ $mark('created_at') }}</a></th>
                        <th class="py-2 px-2 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-black leading-normal">
                    @forelse($users as $u)
                        @php $r = $u->roles->first()?->name; @endphp
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-1.5 px-3">{{ $u->id }}</td>
                            <td class="py-1.5 px-2 font-semibold">{{ $u->name }}</td>
                            <td class="py-1.5 px-2">{{ $u->email }}</td>
                            <td class="py-1.5 px-2">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $r === 'Super-Admin' ? 'bg-purple-100 text-purple-800' : ($r === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700') }}">{{ $r ?? 'No role' }}</span>
                            </td>
                            <td class="py-1.5 px-2">{{ $r === 'Intern' ? $u->batch_no : '' }}</td>
                            <td class="py-1.5 px-2 text-xs">{{ $u->created_at?->format('d-M-Y') }}</td>
                            <td class="py-1.5 px-2 text-center"><a href="{{ route('settings.users.edit', $u) }}" class="text-blue-600 hover:underline">Edit</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="py-6 text-center text-gray-500">No users found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($paginated)
            <div class="mt-3">{{ $users->links() }}</div>
        @endif
    </div>

    @push('modals')
        <script>
            document.getElementById('per-page').addEventListener('change', function () {
                const u = new URL(window.location.href);
                u.searchParams.set('per_page', this.value);
                u.searchParams.delete('page');
                window.location = u.toString();
            });
        </script>
    @endpush
</x-app-layout>
