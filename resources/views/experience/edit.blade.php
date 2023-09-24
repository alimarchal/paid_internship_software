<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <x-internee-tabs :user="$user"/>
                <x-status-message class="mb-4"/>


                <div class="px-6 mb-4 lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                    <!-- resources/views/users/create.blade.php -->
                    <x-validation-errors class="mb-4 mt-4"/>

                    <form action="{{ route('experience.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                            <!-- Organization -->
                            <div>
                                <x-label for="organization" value="Organization" :required="true"/>
                                <x-input id="organization" name="organization" class="block mt-1 w-full" type="text" value="{{ old('organization') }}"/>
                            </div>
                            <!-- Designation -->
                            <div>
                                <x-label for="designation" value="Designation" :required="true"/>
                                <x-input id="designation" name="designation" class="block mt-1 w-full" type="text" value="{{ old('designation') }}"/>
                            </div>
                            <!-- Government/Private -->
                            <div>
                                <x-label for="government_private" value="Government/Private" :required="true"/>
                                <select id="government_private" name="government_private" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="1" {{ old('government_private') == '1' ? 'selected' : '' }}>Government</option>
                                    <option value="0" {{ old('government_private') == '0' ? 'selected' : '' }}>Private</option>
                                </select>
                            </div>
                            <!-- Monthly Salary -->
                            <div>
                                <x-label for="monthly_salary" value="Monthly Salary" :required="true"/>
                                <x-input id="monthly_salary" name="monthly_salary" class="block mt-1 w-full" type="text" value="{{ old('monthly_salary') }}"/>
                            </div>
                            <!-- Starting Date -->
                            <div>
                                <x-label for="starting_date" value="Starting Date" :required="true"/>
                                <x-input id="starting_date" name="starting_date" class="block mt-1 w-full" type="date" value="{{ old('starting_date') }}"/>
                            </div>
                            <!-- Ending Date -->
                            <div>
                                <x-label for="ending_date" value="Ending Date" :required="true"/>
                                <x-input id="ending_date" name="ending_date" class="block mt-1 w-full" type="date" value="{{ old('ending_date') }}"/>
                            </div>
                            <!-- Reason of Leaving -->
                            <div>
                                <x-label for="reason_of_leaving" value="Reason of Leaving" :required="true"/>
                                <x-input id="reason_of_leaving" name="reason_of_leaving" class="block mt-1 w-full" type="text" value="{{ old('reason_of_leaving') }}"/>
                            </div>
                            <!-- Experience Certificate -->
                            <div>
                                <x-label for="experience_photo" value="Experience Certificate" :required="true"/>
                                <x-input id="experience_photo" name="experience_photo" class="block mt-1 w-full" type="file"/>
                            </div>
                            <!-- Relieving Letter -->
                            <div>
                                <x-label for="relieving_letter" value="Relieving Letter" :required="true"/>
                                <x-input id="relieving_letter" name="relieving_letter" class="block mt-1 w-full" type="file"/>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4" id="submit-btn" onclick="return confirm('Are you sure you want to add experience?')"> {{ __('Add') }} </x-button>
                            <a href="{{  route('education.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4"
                               id="submit-btn"> {{ __('Back') }}
                            </a>
                            <a href="{{ route('submit.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4"
                               id="submit-btn"> {{ __('Next') }}
                            </a>
                        </div>

                    </form>

                </div>

                @if($user->experience->isNotEmpty())
                    <div class="relative overflow-x-auto shadow-md mt-4">
                        <table class="w-full text-sm text-left text-white dark:text-gray-400">
                            <thead class="text-xs text-white uppercase font-bold bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Organization
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Designation
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Type
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Monthly Salary
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Starting / Ending Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Reason of Leaving
                                </th>


                                <th scope="col" class="px-6 py-3">
                                    Certificate
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    <abb title="Relieving Letter">RL</abb>
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->experience->sortBy('passing_year') as $degree)
                                <tr class="bg-white border-b text-black font-bold dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $degree->organization }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $degree->designation }}
                                    </td>
                                    <td class="px-6 py-4">

                                        @if($degree->government_private)
                                            Government
                                        @else
                                            Private
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ number_format($degree->monthly_salary,2) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $degree->starting_date }} / {{ $degree->ending_date }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $degree->reason_of_leaving }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        @if(!empty($degree->experience_photo_path))
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($degree->experience_photo_path) }}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 text-center">
                                        @if(!empty($degree->relieving_letter_path))
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($degree->relieving_letter_path) }}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('experience.destroy',[$degree->id, $user->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif


            </div>
        </div>
    </div>


    @push('modals')
        <script>
            // Add a script to format the CNIC input as 00000-0000000-0
            document.getElementById('cnic_number').addEventListener('input', function (e) {
                const cnicInput = e.target;
                let cnic = cnicInput.value.replace(/[^0-9]/g, '');
                if (cnic.length > 13) {
                    cnic = cnic.slice(0, 13);
                }
                const parts = cnic.match(/(\d{5})(\d{7})(\d{1})?/);
                if (parts) {
                    let formattedCnic = parts[1] + '-' + parts[2];
                    if (parts[3]) {
                        formattedCnic += '-' + parts[3];
                    }
                    cnicInput.value = formattedCnic;
                } else {
                    cnicInput.value = cnic;
                }
            });
        </script>
    @endpush
</x-app-layout>
