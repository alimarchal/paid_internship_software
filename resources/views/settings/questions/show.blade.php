<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Question #{{ $question->id }}" backRoute="settings.questions.index" :showRefresh="false"><a href="{{ route('settings.questions.edit', $question) }}" class="inline-flex items-center px-4 py-2 bg-blue-950 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800">Edit</a></x-page-header>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-status-message class="mb-4"/>
            <div class="bg-white shadow-xl rounded-lg p-6">
                <div class="text-sm text-gray-500 mb-2">
                    Category: <b>{{ $question->category?->name }}</b>
                    @if($question->difficulty) &middot; Difficulty: <b>{{ $question->difficulty }}</b> @endif
                    &middot; Used in {{ $used }} candidate paper(s)
                </div>
                <div class="text-xl font-semibold text-gray-800 mb-4">{!! $question->text !!}</div>
                <ul class="space-y-2">
                    @foreach($question->answers as $a)
                        <li class="px-3 py-2 rounded border {{ $a->is_correct ? 'bg-green-100 border-green-400 font-semibold' : 'border-gray-200' }}">
                            {{ $a->text }} @if($a->is_correct) <span class="text-green-700">&#10003; correct</span> @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
