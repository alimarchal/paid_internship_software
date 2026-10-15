<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Result</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($batches as $batch)
                    @php
                        $s = $stats[$batch->name] ?? null;
                        $url = match ($batch->name) {
                            'Batch-01' => route('report.result'),
                            'Batch-02' => route('report.result_batch_two'),
                            default => route('report.result_batch', $batch->name),
                        };
                    @endphp
                    <a href="{{ $url }}" class="block bg-white rounded-xl shadow-lg p-6 hover:shadow-xl hover:bg-gray-50 transition">
                        <div class="text-lg font-bold text-gray-800">{{ $batch->name }}</div>
                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                            <div><div class="text-2xl font-extrabold">{{ $s->registered ?? 0 }}</div><div class="text-gray-500">Registered</div></div>
                            <div><div class="text-2xl font-extrabold">{{ $s->submitted ?? 0 }}</div><div class="text-gray-500">Submitted</div></div>
                            <div><div class="text-2xl font-extrabold">{{ $s->shortlisted ?? 0 }}</div><div class="text-gray-500">Shortlisted</div></div>
                            <div><div class="text-2xl font-extrabold">{{ $s->finished ?? 0 }}</div><div class="text-gray-500">Exam finished</div></div>
                        </div>
                        <div class="mt-4 text-sm text-indigo-600 font-semibold">View result &rarr;</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
