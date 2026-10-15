@php
    $sel = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full';
    $districts = ['Muzaffarabad', 'Jhelum Valley', 'Neelum', 'Mirpur', 'Bhimber', 'Kotli', 'Poonch', 'Bagh', 'Haveli', 'Sudhanoti', 'Refugee'];
    $subjects = ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT', 'Biology/Physics/Commerce (In Case of Metric/FSC)'];
    $f = request('filter', []);
    $f = is_array($f) ? $f : [];
    $opt = fn ($key, $value) => ($f[$key] ?? '') === (string) $value ? 'selected' : '';
    $labels = ['id' => 'ID', 'name' => 'Name', 'fathers_name' => 'Father', 'email' => 'Email', 'cnic_number' => 'CNIC', 'contact_number' => 'Mobile',
        'batch_no' => 'Batch', 'gender' => 'Gender', 'religion' => 'Religion', 'marital_status' => 'Marital', 'district' => 'District',
        'district_of_domicile' => 'Domicile', 'degree_level' => 'Degree', 'education_degrees_search.major_subject' => 'Subject', 'test_center' => 'Test centre',
        'test_date' => 'Test date', 'profile_status' => 'Profile', 'exam_state' => 'Exam', 'paper' => 'Paper', 'applied_from' => 'Applied from',
        'applied_to' => 'Applied to', 'search' => 'Search', 'latestStatus.status' => 'Status'];
    $chips = collect($labels)->filter(fn ($l, $k) => isset($f[$k]) && $f[$k] !== '');
    $hasFilters = $chips->isNotEmpty();
    $status = $f['status'] ?? '';
    $total = array_sum($statusCounts->all());
    $tabs = ['' => ['All', $total], 'Pending' => ['Pending', $statusCounts['Pending'] ?? 0], 'Shortlisted' => ['Shortlisted', $statusCounts['Shortlisted'] ?? 0], 'Rejected' => ['Rejected', $statusCounts['Rejected'] ?? 0]];
    $tabUrl = fn ($key) => request()->fullUrlWithQuery(['filter' => array_merge($f, ['status' => $key ?: null]), 'page' => null]);
    $sort = request('sort', 'id');
    $sortUrl = fn ($field) => request()->fullUrlWithQuery(['sort' => $sort === $field ? '-'.$field : $field, 'page' => null]);
    $mark = fn ($field) => $sort === $field ? ' ▲' : ($sort === '-'.$field ? ' ▼' : '');
    $showEmail = Auth::user()->email == 'hrd@bankajk.com';
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Internee Candidates List" :showSearch="$isAdmin" backRoute="dashboard"/>
    </x-slot>

    @if($isAdmin)
        <x-filter-section :action="route('candidate.index')" :open="$hasFilters && ! ($chips->count() === 1 && $status)">
            <input type="hidden" name="per_page" value="{{ $perPage }}">
            @if($status) <input type="hidden" name="filter[status]" value="{{ $status }}"> @endif
            @include('settings.partials.candidate-filters')
        </x-filter-section>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-16">
        <div class="mt-4"><x-status-message/></div>

        @if($isAdmin)
            <div class="mt-4 flex flex-wrap items-center gap-2">
                @foreach($tabs as $key => [$label, $count])
                    <a href="{{ $tabUrl($key) }}" class="px-3 py-1.5 rounded-full text-sm border {{ $status === $key ? 'bg-blue-950 text-white border-blue-950' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
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

            <div class="mt-2 flex flex-wrap items-center gap-2 text-sm">
                <span class="font-semibold text-gray-800">{{ $paginated ? $candidates->total() : $candidates->count() }} candidates</span>
                @foreach($chips as $k => $label)
                    @continue($k === 'status')
                    <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-xs">{{ $label }}: {{ $f[$k] }}</span>
                @endforeach
                @if($hasFilters)
                    <a href="{{ route('candidate.index') }}" class="text-xs text-red-600 hover:underline">clear filters</a>
                @endif
            </div>
        @endif

        <div class="mt-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="relative overflow-x-auto rounded-lg">
                <table class="min-w-max w-full table-auto text-sm">
                    <thead>
                    <tr class="bg-green-800 text-white uppercase text-sm">
                        <th class="py-2 px-3 text-left"><a href="{{ $sortUrl('id') }}">ID{{ $mark('id') }}</a></th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('name') }}">Name{{ $mark('name') }}</a></th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('district_of_domicile') }}">District{{ $mark('district_of_domicile') }}</a></th>
                        <th class="py-2 px-2 text-left">Mobile / CNIC</th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('batch_no') }}">Batch{{ $mark('batch_no') }}</a></th>
                        <th class="py-2 px-2 text-left"><a href="{{ $sortUrl('created_at') }}">Applied{{ $mark('created_at') }}</a></th>
                        <th class="py-2 px-2 text-left">Education</th>
                        <th class="py-2 px-2 text-center">Profile</th>
                        <th class="py-2 px-2 text-center">Status</th>
                        <th class="py-2 px-2 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-black leading-normal">
                    @forelse($candidates as $candidate)
                        @php
                            $csDegree = $candidate->education_degrees->whereIn('major_subject', ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT'])->first();
                        @endphp
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-1.5 px-3">{{ $candidate->id }}</td>
                            <td class="py-1.5 px-2">
                                {{ ucwords(strtolower($candidate->name)) }}
                                <div class="text-xs text-gray-500">
                                    {{ $candidate->date_of_birth ? \Carbon\Carbon::parse($candidate->date_of_birth)->age.'y' : '' }}@if($candidate->gender == 'Male') / M @elseif($candidate->gender == 'Female') / F @endif
                                    @if($showEmail) &middot; {{ $candidate->email }} @endif
                                </div>
                            </td>
                            <td class="py-1.5 px-2">
                                {{ $candidate->district_of_domicile }}
                                @if($candidate->district && $candidate->district !== $candidate->district_of_domicile)<div class="text-xs text-gray-500">{{ $candidate->district }}</div>@endif
                            </td>
                            <td class="py-1.5 px-2 whitespace-nowrap">
                                {{ $candidate->contact_number }}
                                <div class="text-xs text-gray-500">{{ $candidate->cnic_number }}</div>
                            </td>
                            <td class="py-1.5 px-2">{{ $candidate->batch_no }}</td>
                            <td class="py-1.5 px-2 text-xs whitespace-nowrap">{{ $candidate->created_at ? \Carbon\Carbon::parse($candidate->created_at)->format('d-M-Y') : '' }}</td>
                            <td class="py-1.5 px-2">{{ $csDegree ? $csDegree->major_subject : 'N/A' }}</td>
                            <td class="py-1.5 px-2 text-center">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $candidate->profile_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $candidate->profile_status == 1 ? 'Submitted' : 'In-Complete' }}</span>
                            </td>
                            <td class="py-1.5 px-2 text-center">
                                <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $candidate->status === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($candidate->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">{{ $candidate->status }}</span>
                            </td>
                            <td class="py-1.5 px-2 text-center">
                                <a href="{{ route('candidate.print', $candidate->id) }}" class="inline-flex text-gray-700 hover:text-indigo-600" title="View / Print">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="10" class="py-6 text-center text-gray-500">No candidates found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($paginated)
            <div class="mt-3">{{ $candidates->links() }}</div>
        @endif
    </div>

    @push('modals')
        <script>
            const pp = document.getElementById('per-page');
            if (pp) pp.addEventListener('change', function () {
                const u = new URL(window.location.href);
                u.searchParams.set('per_page', this.value);
                u.searchParams.delete('page');
                window.location = u.toString();
            });
        </script>
    @endpush
</x-app-layout>
