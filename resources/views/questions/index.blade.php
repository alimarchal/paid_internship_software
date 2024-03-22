<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
            {{ __('The Bank of Azad Jammu & Kashmir - Online Examination') }}
        </h2>

    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg">
                <div class="rounded-lg bg-white overflow-x-auto dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">



                    <div class="w-full bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center">
                            <h2 class="text-xl font-bold">BAJK - Paid Internship Program Online Examination System</h2>
                            <div class="text-sm">
                                <span class="font-semibold">USER: {{ Auth::user()->name }}</span>
                            </div>
                        </div>
                        @foreach($user_aloted_questions as $item)
                            <x-status-message class="ml-4 mt-4"/>
                            <x-validation-errors class="ml-4 mt-4"/>
                            <div class="p-6">
                                <div class="mb-4">
                                    <p class="text-gray-700 mb-2 font-semibold">{{ $item->question->text }}</p>
                                </div>
                                <div class="mb-6">
                                    <form action="{{ route('save-answer') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="question_id" value="{{ $item->question_id }}">
                                        @foreach($item->question->answers as $ans)
                                            <div class="mb-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" class="form-radio h-5 w-5 text-blue-600" name="answer_id" value="{{ $ans->id }}" @if($item->is_answered) @if($item->answer_id == $ans->id) checked @endif @endif>
                                                    <span class="ml-2 text-gray-700">{{ $ans->text }}</span>
                                                </label>
                                            </div>
                                        @endforeach

                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded float-right">
                                            Save
                                            @if($item->index == 1)
                                                Yes
                                            @endif
                                        </button>
                                    </form>
                                </div>
                                <div class="flex justify-between items-center">

                                </div>
                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>

            </div>
            <br>
            {{ $user_aloted_questions->links() }}

        </div>

    </div>
</x-app-layout>