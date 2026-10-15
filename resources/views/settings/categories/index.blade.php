<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Categories" backRoute="settings.index" :createRoute="route('settings.categories.create')" createLabel="Add Category"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg overflow-hidden">
                <x-status-message/>
                <table class="w-full text-sm">
                    <thead>
                    <tr class="bg-green-800 text-white uppercase">
                        <th class="py-2 px-3 text-left">ID</th>
                        <th class="py-2 px-3 text-left">Name</th>
                        <th class="py-2 px-3 text-left">Description</th>
                        <th class="py-2 px-3 text-center">Questions</th>
                        <th class="py-2 px-3 text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2 px-3">{{ $category->id }}</td>
                            <td class="py-2 px-3 font-semibold">{{ $category->name }}</td>
                            <td class="py-2 px-3 text-gray-600">{{ $category->description }}</td>
                            <td class="py-2 px-3 text-center">
                                <a class="text-indigo-600 hover:underline" href="{{ route('settings.questions.index', ['category_id' => $category->id]) }}">{{ $category->questions_count }}</a>
                            </td>
                            <td class="py-2 px-3 text-center whitespace-nowrap">
                                <a href="{{ route('settings.categories.edit', $category) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('settings.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf @method('DELETE')
                                    <button class="ml-3 text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
