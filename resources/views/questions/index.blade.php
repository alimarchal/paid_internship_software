<x-app-layout>
    <x-slot name="header" >
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200  leading-tight inline-block" >
            Developed By Information Technology Division (IT Division)
        </h2>

    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl overflow-hidden rounded-lg">
                <div class="rounded-lg bg-white overflow-x-auto dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">



                    <div class="w-full bg-white rounded-lg  overflow-hidden">

                        <img src="{{ Storage::url($user->profile_photo_path) }}" class="float-right" alt="Internee Picture" style="width: 2in; height: 2in; border: 2px solid lightgray;">
                        <div class="bg-gray-800 text-white px-6 py-4 flex justify-between items-center" style="background-color: #377c2b!important;">
                            <h2 class="text-xl font-bold">BAJK - Paid Internship Program Online Examination System</h2>
                            <div class="text-sm">
                                <span class="font-semibold">Name: {{ Auth::user()->name }} :: Internee Application No: {{ $user->id }}</span>
                            </div>
                        </div>
                        <div class="flex float-right mt-8 mb-4">
                            <div class="text-white font-extrabold p-4 m-4 rounded-md text-center" style="background-color: #f78f1e;">
                                <span>Start Time: {{ \Carbon\Carbon::parse($user->start_test_time)->format('H:ia') }}</span><br>
                                Time Left
                                <span id="timer"></span>

                            </div>
                        </div>
                        @foreach($user_aloted_questions  as $item)
                            <x-status-message class="ml-4 mt-4"/>
                            <x-validation-errors class="ml-4 mt-4"/>

                            <div class="p-6">
                                <div class="mb-4">
                                    <div class="text-gray-700 mb-2 font-semibold">
                                        <span class="">Question No: {{ $currentQuestionNumber }} of {{ $totalQuestions }}</span>
                                        <br><span class="text-2xl">
                                            {!! $item->question->text !!}
                                        </span>
                                        <br>
                                        <span class="text-red-700 font-extrabold "> Answer: ( Please select your correct option )</span>
                                    </div>
                                </div>

                                <div class="mb-6">
                                    <form action="{{ route('save-answer') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="question_id" value="{{ $item->question_id }}">
                                        @foreach($item->question->answers as $ans)
                                            <div class="mb-4">
                                                <label class="inline-flex items-center pl-8">
                                                    <input type="radio" class="form-radio h-5 w-5 text-blue-600" name="answer_id" value="{{ $ans->id }}" @if($item->is_answered) @if($item->answer_id == $ans->id) checked @endif @endif>
                                                    <span class="ml-2 text-gray-700">{{ $ans->text }}</span>
                                                </label>
                                            </div>
                                        @endforeach

                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded float-right">
                                            Save
{{--                                            @if($item->index == 1)--}}
{{--                                                Yes--}}
{{--                                            @endif--}}
                                        </button>
                                    </form>
                                </div>




                            </div>
                            <br>

                        @endforeach
                        <div class=" p-4">{{ $user_aloted_questions->links() }}</div>



                    </div>




                </div>
                <div class="text-center p-4 m-4">
                    <form action="{{ route('finish-exam') }}" method="post">
                        <input type="hidden" name="finish_exam" value="1">
                        <input type="hidden" name="exam_taken" value="1">
                        @csrf
                        <button type="submit" class="text-blue-700 font-bold hover:underline text-2xl"  onclick="return confirm('Are you sure you want to finish your exam?')">Click Here To Finish Your Exam</button>
                    </form>
                </div>

            </div>
            <br>



        </div>

    </div>
    @push('modals')
        <script>
            let startTime = "{{ $user->start_test_time }}";
            let endTime = "{{ $user->end_test_time }}";

            function updateTimer() {
                // Convert the start and end times to JavaScript Date objects
                // Note: If the server returns the time in UTC, append 'Z' to the string to ensure correct parsing
                let start = new Date(startTime.replace(' ', 'T')); // 'Z' indicates UTC time
                let end = new Date(endTime.replace(' ', 'T'));
                let now = new Date();

                 let remainingTime = end.getTime() - now.getTime();

                    // Ensure remaining time doesn't go negative
                    if (remainingTime < 0) {
                        remainingTime = 0;
                    }

                    // Convert remaining time to hours, minutes, and seconds
                    let hours = Math.floor(remainingTime / (1000 * 60 * 60));
                    let minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
                    let seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

                    // Adding hours to minutes if hours is greater than 0
                    if (hours > 0) {
                        minutes = minutes + (hours * 60);
                    }

                    // Format the time as "mm:ss"
                    let formattedTime = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;


{{--                console.log(`Start Time: ${start}`);--}}
{{--                console.log(`End Time: ${end}`);--}}
{{--                console.log(`Current Time: ${now}`);--}}
{{--                console.log(`Remaining Time (ms): ${remainingTime}`);--}}
{{--                console.log(`Minutes: ${minutes}, Seconds: ${seconds}`);--}}

                // Display the remaining time in the timer element
                document.getElementById('timer').textContent = formattedTime;
            }

            // Call the updateTimer function every second
            setInterval(updateTimer, 1000);
        </script>



        <script>
            // Function to play a sound
            function playSound() {
                var audio = new Audio('alert.mp3'); // Path to your sound file
                audio.play();
            }

            // Function to show an alert message
            function showAlert() {
                alert("Your input has been captured. Copying content is not allowed or Using developer tools is not allowed. You will fail if you do it again.");
            }

            // Function to handle the protection logic
            function protectContent() {
                document.addEventListener('copy', function(e) {
                    e.preventDefault(); // Prevent the default copy action
                    playSound();
                    showAlert();
                });

                document.addEventListener('contextmenu', function(e) {
                    e.preventDefault(); // Prevent the default context menu (right-click menu)
                    playSound();
                    showAlert();
                });

                // Handle Ctrl+C and F11 for all browsers
                document.addEventListener('keydown', function(e) {
                    if ((e.key === 'c' && (e.ctrlKey || e.metaKey)) || e.key === 'F12') {
                        e.preventDefault(); // Attempt to prevent default copy action and full-screen mode
                        playSound();
                        showAlert();
                    }

                    // Additional check for Ctrl + F11, even though it's less common
                    if (e.key === 'F12' && e.ctrlKey) {
                        e.preventDefault(); // Attempt to prevent default action
                        playSound();
                        showAlert();
                    }
                });
            }

            // Initialize the protection when the document is fully loaded
            document.addEventListener('DOMContentLoaded', protectContent);
        </script>

    @endpush
</x-app-layout>