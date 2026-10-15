@php
    $sel = 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full';
    $old = old('rows', array_fill(0, 5, ['name' => '', 'email' => '', 'contact_number' => '', 'cnic_number' => '']));
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Add Candidates" backRoute="settings.index" :showRefresh="false"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-status-message/>
            <x-validation-errors/>

            <form method="POST" action="{{ route('settings.candidates.store') }}" class="space-y-4" id="add-form">
                @csrf

                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <h3 class="font-bold text-gray-800 mb-3">1. Batch &amp; password</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <x-label for="batch_no" value="Batch" :required="true"/>
                            <select id="batch_no" name="batch_no" required class="{{ $sel }}">
                                <option value="">Select a batch</option>
                                @foreach($batches as $b)
                                    <option value="{{ $b }}" @selected(old('batch_no', request('batch_no')) === $b)>{{ $b }}</option>
                                @endforeach
                            </select>
                            <a href="{{ route('settings.batches.index') }}" class="text-xs text-indigo-600 hover:underline">Need a new batch? Add one here</a>
                        </div>
                        <div>
                            <x-label for="password_mode" value="Password" :required="true"/>
                            <select id="password_mode" name="password_mode" class="{{ $sel }}" onchange="togglePw()">
                                <option value="auto" @selected(old('password_mode', 'auto') === 'auto')>Different for each (auto)</option>
                                <option value="common" @selected(old('password_mode') === 'common')>Same for all</option>
                            </select>
                        </div>
                        <div id="pw-box" class="hidden">
                            <x-label for="password" value="Common password (min 8)"/>
                            <x-input id="password" name="password" type="text" autocomplete="off" class="block mt-1 w-full" value="{{ old('password') }}"/>
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center text-sm text-gray-700 pb-2">
                                <input type="checkbox" name="shortlist" value="1" class="rounded border-gray-300 text-indigo-600" @checked(old('shortlist'))>
                                <span class="ml-2">Mark as <b>Shortlisted</b> right away</span>
                            </label>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500">Only basic details are needed. Candidates are created as <b>Submitted</b> interns with a verified email, so they can sign in at once. Start the test, timings and paper afterwards in <b>Batch Exam Setup</b>.</p>
                </div>

                <div class="bg-white shadow-xl sm:rounded-lg p-6">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-3">
                        <h3 class="font-bold text-gray-800">2. Candidates <span class="text-xs font-normal text-gray-500">(up to {{ $maxRows }} at a time)</span></h3>
                        <div class="flex gap-2">
                            <button type="button" onclick="document.getElementById('paste-box').classList.toggle('hidden')" class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Paste a list</button>
                            <button type="button" id="add-row" class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">+ Add row</button>
                        </div>
                    </div>

                    <div id="paste-box" class="hidden mb-4 p-3 border rounded-md bg-gray-50">
                        <p class="text-xs text-gray-600 mb-1">One candidate per line: <b>Name, Email, Mobile, CNIC</b> (mobile and CNIC optional). Commas or tabs both work &mdash; you can paste straight from Excel.</p>
                        <textarea id="paste-text" rows="5" class="border-gray-300 rounded-md shadow-sm block w-full text-sm" placeholder="Ali Khan, ali@example.com, 03001234567"></textarea>
                        <button type="button" id="paste-fill" class="mt-2 px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">Fill rows</button>
                    </div>

                    <div class="overflow-x-auto rounded-lg">
                        <table class="min-w-max w-full table-auto text-sm">
                            <thead>
                            <tr class="bg-green-800 text-white uppercase text-sm">
                                <th class="py-2 px-3 text-left w-12">#</th>
                                <th class="py-2 px-2 text-left">Name *</th>
                                <th class="py-2 px-2 text-left">Email *</th>
                                <th class="py-2 px-2 text-left">Mobile</th>
                                <th class="py-2 px-2 text-left">CNIC</th>
                                <th class="py-2 px-2 w-10"></th>
                            </tr>
                            </thead>
                            <tbody id="rows"></tbody>
                        </table>
                    </div>
                    <p class="mt-2 text-sm text-gray-600"><b id="row-count">0</b> candidates filled</p>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('settings.index') }}" class="px-4 py-2 text-gray-600 bg-white border rounded-md hover:bg-gray-100 text-sm">Cancel</a>
                    <x-button class="bg-blue-950 text-white hover:bg-green-800" onclick="return confirmAdd()">Add candidates</x-button>
                </div>
            </form>
        </div>
    </div>

    @push('modals')
        <script>
            const MAX = {{ $maxRows }};
            const initial = @json(array_values($old));
            const tbody = document.getElementById('rows');
            const cell = 'border-gray-300 rounded-md shadow-sm w-full text-sm py-1';

            function addRow(v) {
                v = v || {};
                if (tbody.children.length >= MAX) { alert('Maximum ' + MAX + ' candidates at a time.'); return; }
                const i = tbody.children.length;
                const tr = document.createElement('tr');
                tr.className = 'border-b border-gray-200';
                tr.innerHTML =
                    '<td class="py-1 px-3 text-gray-500 rn"></td>' +
                    '<td class="py-1 px-2"><input type="text" name="rows[' + i + '][name]" class="' + cell + '"></td>' +
                    '<td class="py-1 px-2"><input type="text" name="rows[' + i + '][email]" class="' + cell + '"></td>' +
                    '<td class="py-1 px-2"><input type="text" name="rows[' + i + '][contact_number]" class="' + cell + '"></td>' +
                    '<td class="py-1 px-2"><input type="text" name="rows[' + i + '][cnic_number]" class="' + cell + '"></td>' +
                    '<td class="py-1 px-2 text-center"><button type="button" class="text-red-600 text-lg leading-none" title="Clear row">&times;</button></td>';
                const ins = tr.querySelectorAll('input');
                ins[0].value = v.name || ''; ins[1].value = v.email || ''; ins[2].value = v.contact_number || ''; ins[3].value = v.cnic_number || '';
                ins.forEach(x => x.addEventListener('input', refresh));
                tr.querySelector('button').addEventListener('click', () => { ins.forEach(x => x.value = ''); refresh(); });
                tbody.appendChild(tr);
                refresh();
            }
            function refresh() {
                let filled = 0;
                Array.from(tbody.children).forEach((tr, i) => {
                    tr.querySelector('.rn').textContent = i + 1;
                    const ins = tr.querySelectorAll('input');
                    if (ins[0].value.trim() || ins[1].value.trim()) filled++;
                });
                document.getElementById('row-count').textContent = filled;
            }
            function togglePw() {
                document.getElementById('pw-box').classList.toggle('hidden', document.getElementById('password_mode').value !== 'common');
            }
            function confirmAdd() {
                const n = parseInt(document.getElementById('row-count').textContent);
                if (!n) { alert('Fill in at least one candidate.'); return false; }
                return confirm('Add ' + n + ' candidate(s) to ' + (document.getElementById('batch_no').value || 'the selected batch') + '?');
            }

            initial.forEach(addRow);
            document.getElementById('add-row').addEventListener('click', () => addRow());
            document.getElementById('paste-fill').addEventListener('click', () => {
                const lines = document.getElementById('paste-text').value.split(/\r?\n/).map(l => l.trim()).filter(Boolean);
                if (!lines.length) return;
                // replace empty rows first, then append
                let free = Array.from(tbody.children).filter(tr => !Array.from(tr.querySelectorAll('input')).some(x => x.value.trim()));
                lines.forEach(line => {
                    const p = line.split(/\t|,/).map(x => x.trim());
                    const v = {name: p[0], email: p[1], contact_number: p[2], cnic_number: p[3]};
                    const tr = free.shift();
                    if (tr) { const ins = tr.querySelectorAll('input'); ins[0].value = v.name || ''; ins[1].value = v.email || ''; ins[2].value = v.contact_number || ''; ins[3].value = v.cnic_number || ''; }
                    else addRow(v);
                });
                refresh();
            });
            togglePw();
        </script>
    @endpush
</x-app-layout>
