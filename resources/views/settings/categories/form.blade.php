<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $category->exists ? 'Edit Category' : 'Add Category' }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-6">
                <x-validation-errors class="mb-4"/>
                <form method="POST" action="{{ $category->exists ? route('settings.categories.update', $category) : route('settings.categories.store') }}" class="space-y-4">
                    @csrf
                    @if($category->exists) @method('PUT') @endif

                    <div>
                        <x-label for="name" value="Name" :required="true"/>
                        <x-input id="name" name="name" type="text" class="block mt-1 w-full" required value="{{ old('name', $category->name) }}"/>
                    </div>
                    <div>
                        <x-label for="description" value="Description"/>
                        <textarea id="description" name="description" rows="3" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">{{ old('description', $category->description) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('settings.categories.index') }}" class="px-4 py-2 text-gray-600 bg-white border rounded-md hover:bg-gray-100 text-sm">Cancel</a>
                        <x-button>Save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
