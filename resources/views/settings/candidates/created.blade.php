<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Candidates Added" backRoute="settings.candidates.create" :showRefresh="false"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <div class="bg-green-50 border border-green-300 text-green-900 rounded-lg px-4 py-3 text-sm">
                <b>{{ count($rows) }} candidate(s) added to {{ $batch }}</b>{{ $shortlisted ? ' and marked Shortlisted' : '' }}.
                Passwords are shown <b>only once</b>. Copy or print this sheet now.
            </div>

            <div class="flex flex-wrap gap-2 no-print">
                <button type="button" id="copy-all" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">Copy all</button>
                <button type="button" onclick="window.print()" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">Print</button>
                <a href="{{ route('settings.batch-exam.index', ['filter' => ['batch_no' => $batch]]) }}" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white bg-green-700 rounded-md hover:bg-green-600">Set up exam for {{ $batch }}</a>
                <a href="{{ route('settings.candidates.create', ['batch_no' => $batch]) }}" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Add more</a>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="relative overflow-x-auto rounded-lg">
                    <table class="min-w-max w-full table-auto text-sm" id="sheet">
                        <thead>
                        <tr class="bg-green-800 text-white uppercase text-sm">
                            <th class="py-2 px-3 text-left">#</th>
                            <th class="py-2 px-2 text-left">ID</th>
                            <th class="py-2 px-2 text-left">Name</th>
                            <th class="py-2 px-2 text-left">Email (login)</th>
                            <th class="py-2 px-2 text-left">Password</th>
                            <th class="py-2 px-2 text-left">Batch</th>
                        </tr>
                        </thead>
                        <tbody class="text-black">
                        @foreach($rows as $i => $r)
                            <tr class="border-b border-gray-200">
                                <td class="py-1 px-3 text-gray-500">{{ $i + 1 }}</td>
                                <td class="py-1 px-2">{{ $r['id'] }}</td>
                                <td class="py-1 px-2">{{ $r['name'] }}</td>
                                <td class="py-1 px-2">{{ $r['email'] }}</td>
                                <td class="py-1 px-2 font-mono font-semibold">{{ $r['password'] }}</td>
                                <td class="py-1 px-2">{{ $batch }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('modals')
        <style>@media print { nav, .no-print { display: none !important; } }</style>
        <script>
            document.getElementById('copy-all').addEventListener('click', function () {
                const lines = ['Name\tEmail\tPassword\tBatch'];
                document.querySelectorAll('#sheet tbody tr').forEach(tr => {
                    const c = tr.querySelectorAll('td');
                    lines.push([c[2].textContent, c[3].textContent, c[4].textContent, c[5].textContent].map(x => x.trim()).join('\t'));
                });
                navigator.clipboard.writeText(lines.join('\n')).then(() => { this.textContent = 'Copied'; });
            });
        </script>
    @endpush
</x-app-layout>
