<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Questions" backRoute="settings.index" :createRoute="route('settings.questions.create')" createLabel="Add Question"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-status-message class="mb-4"/>

            <form method="GET" class="bg-white shadow rounded-lg p-4 mb-4 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4 items-end">
                <div>
                    <x-label for="category_id" value="Category"/>
                    <select id="category_id" name="filter[category_id]" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                        <option value="">All categories</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}" @selected(request('filter.category_id') == $c->id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-2">
                    <x-label for="search" value="Question text"/>
                    <x-input id="search" name="filter[text]" type="text" class="block mt-1 w-full" value="{{ request('filter.text') }}"/>
                </div>
                <div>
                    <x-label for="f_answer" value="Answer text"/>
                    <x-input id="f_answer" name="filter[answer]" type="text" class="block mt-1 w-full" value="{{ request('filter.answer') }}"/>
                </div>
                <div>
                    <x-label for="f_id" value="Question ID"/>
                    <x-input id="f_id" name="filter[id]" type="text" class="block mt-1 w-full" value="{{ request('filter.id') }}"/>
                </div>
                <div>
                    <x-label for="per_page" value="Show"/>
                    <select id="per_page" name="per_page" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                        @foreach([10, 50, 100, 'all'] as $n)
                            <option value="{{ $n }}" @selected((string) $perPage === (string) $n)>{{ $n === 'all' ? 'All' : $n.' per page' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="lg:col-span-6 flex gap-3">
                    <x-button class="bg-blue-950 text-white hover:bg-green-800">Apply Filters</x-button>
                    <a href="{{ route('settings.questions.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50">Reset</a>
                    <span class="ml-auto self-center text-sm text-gray-600">{{ $questions instanceof \Illuminate\Pagination\AbstractPaginator ? $questions->total() : $questions->count() }} questions</span>
                </div>
            </form>

            <div class="bg-white shadow-xl rounded-lg overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                    <tr class="bg-green-800 text-white uppercase">
                        <th class="py-2 px-3 text-left">ID</th>
                        <th class="py-2 px-3 text-left">Category</th>
                        <th class="py-2 px-3 text-left">Question</th>
                        <th class="py-2 px-3 text-left">Correct answer</th>
                        <th class="py-2 px-3 text-center">Answers</th>
                        <th class="py-2 px-3 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($questions as $q)
                        <tr class="border-b hover:bg-gray-50 align-top">
                            <td class="py-2 px-3">{{ $q->id }}</td>
                            <td class="py-2 px-3">{{ $q->category?->name }}</td>
                            <td class="py-2 px-3">{{ \Illuminate\Support\Str::limit(strip_tags($q->text), 120) }}</td>
                            <td class="py-2 px-3 text-green-700">{{ \Illuminate\Support\Str::limit($q->answers->firstWhere('is_correct', 1)?->text, 60) }}</td>
                            <td class="py-2 px-3 text-center">{{ $q->answers->count() }}</td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <a href="{{ route('settings.questions.show', $q) }}" class="text-gray-700 hover:underline">View</a>
                                <a href="{{ route('settings.questions.edit', $q) }}" class="ml-3 text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('settings.questions.destroy', $q) }}" method="POST" class="inline" onsubmit="return confirm('Delete this question?');">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="py-6 text-center text-gray-500">No questions found.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            @if($questions instanceof \Illuminate\Pagination\AbstractPaginator)
                <div class="mt-4">{{ $questions->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
