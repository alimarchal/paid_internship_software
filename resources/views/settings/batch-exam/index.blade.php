@php
    $sel = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full';
    $districts = ['Muzaffarabad', 'Jhelum Valley', 'Neelum', 'Mirpur', 'Bhimber', 'Kotli', 'Poonch', 'Bagh', 'Haveli', 'Sudhanoti', 'Refugee'];
    $paper = old('paper', '');
    $labels = ['batch_no' => 'Batch', 'status' => 'Status', 'profile_status' => 'Profile', 'district_of_domicile' => 'Domicile', 'exam_state' => 'Exam', 'search' => 'Search', 'per_page' => 'Rows'];
    $active = collect($labels)->filter(fn ($l, $k) => request()->filled($k));
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Batch Exam Setup" :showSearch="true" backRoute="settings.index"/>
    </x-slot>

    {{-- Filters --}}
    <x-filter-section :action="route('settings.batch-exam.index')" :open="$hasFilters">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <x-label for="batch_no" value="Batch"/>
                <select id="batch_no" name="batch_no" class="{{ $sel }}">
                    <option value="">All batches</option>
                    @foreach(\App\Models\Batch::names() as $b)
                        <option value="{{ $b }}" @selected(request('batch_no') === $b)>{{ $b }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-label for="status" value="Shortlisted / Pending / Rejected"/>
                <select id="status" name="status" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach(['Shortlisted', 'Pending', 'Rejected'] as $st)
                        <option value="{{ $st }}" @selected(request('status') === $st)>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-label for="profile_status" value="Profile"/>
                <select id="profile_status" name="profile_status" class="{{ $sel }}">
                    <option value="">All</option>
                    <option value="1" @selected(request('profile_status') === '1')>Submitted</option>
                    <option value="0" @selected(request('profile_status') === '0')>In-Complete</option>
                </select>
            </div>
            <div>
                <x-label for="district_of_domicile" value="District of Domicile"/>
                <select id="district_of_domicile" name="district_of_domicile" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($districts as $d)
                        <option value="{{ $d }}" @selected(request('district_of_domicile') === $d)>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-label for="exam_state" value="Exam"/>
                <select id="exam_state" name="exam_state" class="{{ $sel }}">
                    <option value="">All</option>
                    <option value="not_allowed" @selected(request('exam_state') === 'not_allowed')>Not allowed yet</option>
                    <option value="allowed" @selected(request('exam_state') === 'allowed')>Allowed, not finished</option>
                    <option value="finished" @selected(request('exam_state') === 'finished')>Exam finished</option>
                </select>
            </div>
            <div class="lg:col-span-2">
                <x-label for="search" value="Name / Email / CNIC / ID"/>
                <x-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Search"/>
            </div>
            <div>
                <x-label for="per_page" value="Rows"/>
                <select id="per_page" name="per_page" class="{{ $sel }}">
                    <option value="">Auto (all when filtered)</option>
                    @foreach([50, 100, 200, 500] as $n)
                        <option value="{{ $n }}" @selected(request('per_page') == $n)>{{ $n }} per page</option>
                    @endforeach
                    <option value="all" @selected(request('per_page') === 'all')>Show all</option>
                </select>
            </div>
        </div>
    </x-filter-section>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-32" x-data="{ panel: {{ $errors->any() ? 'true' : 'false' }} }">
        <div class="mt-4"><x-status-message/></div>
        <x-validation-errors class="mt-4"/>

        {{-- Summary --}}
        <div class="mt-4 flex flex-wrap items-center gap-2 text-sm">
            <span class="font-semibold text-gray-800">{{ $matching }} candidates</span>
            @foreach($active as $k => $label)
                <span class="px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800 text-xs">{{ $label }}: {{ request($k) }}</span>
            @endforeach
            @if($hasFilters)
                <a href="{{ route('settings.batch-exam.index') }}" class="text-xs text-red-600 hover:underline">clear filters</a>
            @endif
            @if(!$paginated)
                <span class="text-xs text-gray-500">&middot; showing all</span>
            @endif
        </div>

        <form method="POST" action="{{ route('settings.batch-exam.apply', request()->query()) }}" id="apply-form" onsubmit="return confirmApply()">
            @csrf
            <input type="hidden" name="select_all_matching" id="select_all_matching" value="0">

            {{-- Candidates --}}
            <div class="mt-3 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($paginated && $matching > $candidates->count())
                    <div class="px-4 py-2 bg-yellow-50 border-b text-sm">
                        This page has {{ $candidates->count() }} of {{ $matching }} candidates.
                        <button type="button" id="select-matching" class="text-indigo-600 font-semibold hover:underline">Select all {{ $matching }}</button>
                        <span id="matching-note" class="hidden text-green-700 font-semibold">All {{ $matching }} selected.</span>
                    </div>
                @endif
                <div class="relative overflow-x-auto rounded-lg">
                    <table class="min-w-max w-full table-auto text-sm">
                        <thead>
                        <tr class="bg-green-800 text-white uppercase text-sm">
                            <th class="py-2 px-3"><input type="checkbox" id="select-page" title="Select all shown" class="rounded border-gray-300"></th>
                            <th class="py-2 px-2 text-left">ID</th>
                            <th class="py-2 px-2 text-left">Name</th>
                            <th class="py-2 px-2 text-left">Batch</th>
                            <th class="py-2 px-2 text-left">Status</th>
                            <th class="py-2 px-2 text-left">Domicile</th>
                            <th class="py-2 px-2 text-left">Exam</th>
                            <th class="py-2 px-2 text-left">Paper</th>
                            <th class="py-2 px-2 text-left">Test window</th>
                            <th class="py-2 px-2 text-center">Single</th>
                        </tr>
                        </thead>
                        <tbody class="text-black leading-normal">
                        @forelse($candidates as $c)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-1 px-3 text-center"><input type="checkbox" name="ids[]" value="{{ $c->id }}" class="row-check rounded border-gray-300"></td>
                                <td class="py-1 px-2">{{ $c->id }}</td>
                                <td class="py-1 px-2">{{ ucwords(strtolower($c->name)) }}<div class="text-xs text-gray-500">{{ $c->email }}</div></td>
                                <td class="py-1 px-2">{{ $c->batch_no }}</td>
                                <td class="py-1 px-2">
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $c->status === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($c->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">{{ $c->status }}</span>
                                </td>
                                <td class="py-1 px-2">{{ $c->district_of_domicile }}</td>
                                <td class="py-1 px-2">
                                    @if($c->exam_taken) <span class="text-green-700 font-semibold">Finished</span>
                                    @elseif($c->start_test) <span class="text-blue-700 font-semibold">Allowed</span>
                                    @else <span class="text-gray-500">Not allowed</span> @endif
                                </td>
                                <td class="py-1 px-2 text-xs">
                                    @if(!empty($allocated[$c->id])) {{ $allocated[$c->id] }} q. allocated
                                    @elseif($c->exam_config) {{ $c->exam_config['total'] ?? '?' }} q. set
                                    @else <span class="text-gray-400">default</span> @endif
                                </td>
                                <td class="py-1 px-2 text-xs whitespace-nowrap">{{ $c->start_test_time ? \Carbon\Carbon::parse($c->start_test_time)->format('d-M H:i') : '-' }} &rarr; {{ $c->end_test_time ? \Carbon\Carbon::parse($c->end_test_time)->format('d-M H:i') : '-' }}</td>
                                <td class="py-1 px-2 text-center"><a class="text-blue-600 hover:underline" href="{{ route('candidate-user.password-change', $c->id) }}">Open</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="10" class="py-6 text-center text-gray-500">No candidates match.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($paginated)
                <div class="mt-3">{{ $candidates->links() }}</div>
            @endif

            {{-- Options panel (opens from the bottom bar) --}}
            <div x-show="panel" x-cloak class="fixed inset-x-0 bottom-14 z-40 px-2 sm:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto bg-white rounded-t-2xl shadow-[0_-10px_40px_rgba(0,0,0,0.2)] border border-gray-200 max-h-[70vh] overflow-y-auto p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-800">Exam options for <span id="panel-count">0</span> selected</h3>
                            <p class="text-xs text-gray-500">Only what you fill in is changed. Everything else stays as it is.</p>
                        </div>
                        <button type="button" @click="panel = false" class="text-gray-400 hover:text-gray-700 text-2xl leading-none">&times;</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                        <div>
                            <x-label for="start_test" value="Start candidate test"/>
                            <select id="start_test" name="start_test" class="{{ $sel }}">
                                <option value="">Don't change</option>
                                <option value="1" @selected(old('start_test') === '1')>Yes (allow exam)</option>
                                <option value="0" @selected(old('start_test') === '0')>No (block exam)</option>
                            </select>
                        </div>
                        <div>
                            <x-label for="start_test_time" value="Start time"/>
                            <x-input id="start_test_time" name="start_test_time" type="datetime-local" class="block mt-1 w-full" value="{{ old('start_test_time') }}"/>
                        </div>
                        <div>
                            <x-label for="end_test_time" value="End time"/>
                            <x-input id="end_test_time" name="end_test_time" type="datetime-local" class="block mt-1 w-full" value="{{ old('end_test_time') }}"/>
                        </div>
                        <div>
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <input type="checkbox" name="change_password" value="1" class="rounded border-gray-300 text-indigo-600" @checked(old('change_password'))>
                                <span class="ml-2">Change password (same for all)</span>
                            </label>
                            <x-input id="password" name="password" type="text" autocomplete="off" placeholder="New password (min 8)" class="block mt-1 w-full" value="{{ old('password') }}"/>
                        </div>
                    </div>

                    <div class="mt-4 border-t pt-3">
                        <x-label value="Question paper"/>
                        <div class="flex flex-wrap gap-6 mt-1 text-sm">
                            <label><input type="radio" name="paper" value="" @checked($paper === '') onchange="togglePaper()"> Don't change</label>
                            <label><input type="radio" name="paper" value="set" @checked($paper === 'set') onchange="togglePaper()"> Set total &amp; category-wise</label>
                            <label><input type="radio" name="paper" value="default" @checked($paper === 'default') onchange="togglePaper()"> Default (10 English, 10 GK, 80 others)</label>
                        </div>

                        <div id="paper-box" class="mt-3 hidden">
                            <div class="max-w-xs">
                                <x-label for="total_questions" value="Total questions per candidate" :required="true"/>
                                <x-input id="total_questions" name="total_questions" type="number" min="1" max="500" class="block mt-1 w-full" value="{{ old('total_questions') }}" oninput="sumCounts()"/>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3 mt-3">
                                @foreach($categories as $c)
                                    <div class="border rounded-md p-2">
                                        <label class="block text-xs font-semibold text-gray-700" for="cat_{{ $c->id }}">{{ $c->name }}</label>
                                        <div class="text-[11px] text-gray-500">available: {{ $available[$c->id] ?? 0 }}</div>
                                        <input id="cat_{{ $c->id }}" type="number" min="0" max="{{ $available[$c->id] ?? 0 }}" name="category_counts[{{ $c->id }}]"
                                               value="{{ old('category_counts.'.$c->id) }}" oninput="sumCounts()" class="cat-count border-gray-300 rounded-md shadow-sm mt-1 w-full text-sm">
                                    </div>
                                @endforeach
                            </div>
                            <p class="mt-2 text-sm">Category total: <b id="cat-sum">0</b> / <b id="cat-total">0</b> <span id="cat-ok" class="ml-2"></span></p>
                            <p class="text-xs text-gray-500">The paper is created when the candidate opens the exam the first time; candidates who already have a paper keep it.</p>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-button class="bg-blue-950 text-white hover:bg-green-800">Apply to selected</x-button>
                    </div>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="fixed inset-x-0 bottom-0 z-50 bg-blue-950 text-white shadow-[0_-4px_20px_rgba(0,0,0,0.25)]">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between">
                    <div class="text-sm"><b id="sel-count" class="text-lg">0</b> selected</div>
                    <button type="button" @click="panel = !panel" class="px-4 py-2 rounded-md bg-green-600 hover:bg-green-500 text-xs font-semibold uppercase tracking-widest">
                        <span x-text="panel ? 'Hide options' : 'Set up exam'"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('modals')
        <style>[x-cloak]{display:none!important}</style>
        <script>
            const matching = {{ (int) $matching }};
            const pageBoxes = () => Array.from(document.querySelectorAll('.row-check'));
            const allMatching = () => document.getElementById('select_all_matching').value === '1';

            function refreshCount() {
                const n = allMatching() ? matching : pageBoxes().filter(b => b.checked).length;
                document.getElementById('sel-count').textContent = n;
                document.getElementById('panel-count').textContent = n;
                const note = document.getElementById('matching-note');
                if (note) note.classList.toggle('hidden', !allMatching());
            }
            function clearMatching() { document.getElementById('select_all_matching').value = '0'; }

            document.getElementById('select-page').addEventListener('change', function () {
                pageBoxes().forEach(b => b.checked = this.checked);
                clearMatching(); refreshCount();
            });
            pageBoxes().forEach(b => b.addEventListener('change', () => { clearMatching(); refreshCount(); }));
            const sm = document.getElementById('select-matching');
            if (sm) sm.addEventListener('click', () => {
                document.getElementById('select_all_matching').value = '1';
                pageBoxes().forEach(b => b.checked = true);
                document.getElementById('select-page').checked = true;
                refreshCount();
            });

            function togglePaper() {
                const set = document.querySelector('input[name=paper]:checked').value === 'set';
                document.getElementById('paper-box').classList.toggle('hidden', !set);
                sumCounts();
            }
            function sumCounts() {
                const sum = Array.from(document.querySelectorAll('.cat-count')).reduce((a, i) => a + (parseInt(i.value) || 0), 0);
                const total = parseInt(document.getElementById('total_questions').value) || 0;
                document.getElementById('cat-sum').textContent = sum;
                document.getElementById('cat-total').textContent = total;
                const ok = document.getElementById('cat-ok');
                const good = sum === total && total > 0;
                ok.textContent = good ? 'OK' : 'Counts must add up to the total';
                ok.className = 'ml-2 font-semibold ' + (good ? 'text-green-700' : 'text-red-600');
            }
            function confirmApply() {
                const n = allMatching() ? matching : pageBoxes().filter(b => b.checked).length;
                if (n === 0) { alert('Select at least one candidate.'); return false; }
                return confirm('Apply these changes to ' + n + ' candidate(s)?');
            }
            togglePaper(); refreshCount();
        </script>
    @endpush
</x-app-layout>
