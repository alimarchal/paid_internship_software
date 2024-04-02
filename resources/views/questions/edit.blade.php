<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <x-status-message class="mb-4"/>


                <div class="px-6 mb-4 lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                    <!-- resources/views/users/create.blade.php -->
                    <x-validation-errors class="mb-4 mt-4"/>

                    <form action="{{ route('candidate-user.password-change-update', $user->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                            <div>
                                <x-label for="start_test" value="Start Candidate Test" :required="true"/>
                                <select id="start_test" name="start_test" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Start Test Session</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>

                            <div>
                                <x-label for="cpr" value="Change Password" :required="true"/>
                                <select id="cpr" name="cpr" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Do you also want to change the password for user?</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No" selected>No</option>
                                </select>
                            </div>
                            <div>
                                <x-label for="password" value="Password" :required="false"/>
                                <x-input id="password" name="password" class="block mt-1 w-full" type="password"/>
                            </div>



                            <div>
                                <x-label for="start_test_time" value="Start Test Time" :required="false"/>
                                <x-input id="start_test_time" name="start_test_time" class="block mt-1 w-full" type="datetime-local" value="{{ $user->start_test_time}}" />
                            </div>

                            <div>
                                <x-label for="end_test_time" value="End Test Time" :required="false"/>
                                <x-input id="end_test_time" name="end_test_time" class="block mt-1 w-full" type="datetime-local" value="{{ $user->end_test_time}}"  />
                            </div>


                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4" id="submit-btn" onclick="return confirm('Are you sure you want to add your education?')">
                                Submit
                            </x-button>
                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>
</x-app-layout>
