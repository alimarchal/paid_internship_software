<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Batches &amp; Registration" backRoute="settings.index"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-4">
            <x-status-message/>
            <x-validation-errors/>

            <div class="bg-white shadow-xl rounded-lg p-6">
                <h3 class="font-bold text-gray-800 mb-1">Registration</h3>
                <p class="text-sm mb-4">
                    Status:
                    @if($open) <span class="px-2 py-0.5 rounded bg-green-100 text-green-800 font-semibold">Open until {{ $deadline->format('d-M-Y H:i') }}</span>
                    @else <span class="px-2 py-0.5 rounded bg-red-100 text-red-800 font-semibold">Closed (ended {{ $deadline->format('d-M-Y H:i') }})</span> @endif
                </p>
                <form method="POST" action="{{ route('settings.batches.registration') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    @csrf @method('PUT')
                    <div>
                        <x-label for="batch_id" value="New registrations go to"/>
                        <select id="batch_id" name="batch_id" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                            @foreach($batches as $b)
                                <option value="{{ $b->id }}" @selected($b->is_registration)>{{ $b->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <x-label for="deadline" value="Registration last date &amp; time"/>
                        <x-input id="deadline" name="deadline" type="datetime-local" class="block mt-1 w-full" value="{{ old('deadline', $deadline->format('Y-m-d\TH:i')) }}"/>
                    </div>
                    <div><x-button>Save</x-button></div>
                </form>
            </div>

            <div class="bg-white shadow-xl rounded-lg p-6">
                <h3 class="font-bold text-gray-800 mb-3">Batches</h3>
                <table class="w-full text-sm mb-4">
                    <thead><tr class="bg-green-800 text-white uppercase">
                        <th class="py-2 px-3 text-left">Batch</th>
                        <th class="py-2 px-3 text-center">Candidates</th>
                        <th class="py-2 px-3 text-left">Registration</th>
                        <th class="py-2 px-3 text-center">Action</th>
                    </tr></thead>
                    <tbody>
                    @foreach($batches as $b)
                        <tr class="border-b">
                            <td class="py-2 px-3 font-semibold">{{ $b->name }}</td>
                            <td class="py-2 px-3 text-center">{{ $counts[$b->name] ?? 0 }}</td>
                            <td class="py-2 px-3">@if($b->is_registration) <span class="text-green-700 font-semibold">Current</span> @endif</td>
                            <td class="py-2 px-3 text-center">
                                <form action="{{ route('settings.batches.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Delete this batch?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <form method="POST" action="{{ route('settings.batches.store') }}" class="flex items-end gap-3">
                    @csrf
                    <div class="w-64">
                        <x-label for="name" value="Add a batch (e.g. Batch-04)"/>
                        <x-input id="name" name="name" type="text" class="block mt-1 w-full" required value="{{ old('name') }}"/>
                    </div>
                    <x-button>Add Batch</x-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
