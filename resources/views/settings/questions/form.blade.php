@php
    // Existing answers, or old input after a failed validation, padded to at least 4 rows.
    $rows = old('answers') ?? $answers->map(fn ($a) => ['id' => $a->id, 'text' => $a->text])->all();
    $correct = old('correct', $answers->search(fn ($a) => $a->is_correct));
    $rows = array_pad(array_values($rows), 4, ['id' => null, 'text' => '']);
@endphp
<x-app-layout>
    <x-slot name="header">
        <x-page-header title="{{ $question->exists ? 'Edit Question #'.$question->id : 'Add Question' }}" backRoute="settings.questions.index" :showRefresh="false"/>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-lg p-6">
                <x-validation-errors class="mb-4"/>
                <form method="POST" action="{{ $question->exists ? route('settings.questions.update', $question) : route('settings.questions.store') }}" class="space-y-4">
                    @csrf
                    @if($question->exists) @method('PUT') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-label for="category_id" value="Category" :required="true"/>
                            <select id="category_id" name="category_id" required class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                                <option value="">Select a category</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category_id', $question->category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-label for="difficulty" value="Difficulty (optional)"/>
                            <x-input id="difficulty" name="difficulty" type="text" class="block mt-1 w-full" value="{{ old('difficulty', $question->difficulty) }}"/>
                        </div>
                    </div>

                    <div>
                        <x-label for="text" value="Question" :required="true"/>
                        <textarea id="text" name="text" rows="4" required class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">{{ old('text', $question->text) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">HTML (e.g. &lt;br&gt;, &lt;b&gt;) is shown as-is to candidates.</p>
                    </div>

                    <div>
                        <x-label value="Answers (select the correct one)" :required="true"/>
                        <div id="answers" class="space-y-2 mt-1">
                            @foreach($rows as $i => $row)
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="correct" value="{{ $i }}" @checked((string) $correct === (string) $i) class="h-5 w-5 text-green-600" title="Correct answer">
                                    <input type="hidden" name="answers[{{ $i }}][id]" value="{{ $row['id'] ?? '' }}">
                                    <x-input type="text" name="answers[{{ $i }}][text]" class="block w-full" placeholder="Answer {{ $i + 1 }}" value="{{ $row['text'] ?? '' }}"/>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-answer" class="mt-2 text-sm text-indigo-600 hover:underline">+ Add another answer</button>
                        <p class="text-xs text-gray-500 mt-1">Leave an answer blank to ignore it (on edit, a blank existing answer is removed).</p>
                    </div>

                    <div class="flex justify-end gap-2">
                        <a href="{{ route('settings.questions.index') }}" class="px-4 py-2 text-gray-600 bg-white border rounded-md hover:bg-gray-100 text-sm">Cancel</a>
                        <x-button>Save</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('modals')
        <script>
            document.getElementById('add-answer').addEventListener('click', function () {
                const box = document.getElementById('answers');
                const i = box.children.length;
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3';
                row.innerHTML = '<input type="radio" name="correct" value="' + i + '" class="h-5 w-5 text-green-600" title="Correct answer">' +
                    '<input type="hidden" name="answers[' + i + '][id]" value="">' +
                    '<input type="text" name="answers[' + i + '][text]" placeholder="Answer ' + (i + 1) + '" class="border-gray-300 rounded-md shadow-sm block w-full">';
                box.appendChild(row);
            });
        </script>
    @endpush
</x-app-layout>
