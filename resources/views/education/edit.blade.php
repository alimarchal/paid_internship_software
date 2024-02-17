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

                    <form action="{{ route('education.store') }}" method="POST" class="space-y-4" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                            <div>
                                <x-label for="education_level" value="Education Level" :required="true" />
                                <select id="education_level" name="education_level" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Please select a degree</option>
                                    <option value="Secondary School Certificate / Matriculation / O - level">Secondary School Certificate / Matriculation / O - level</option>
                                    <option value="Higher Secondary School Certificate / Intermediate/ A - level">Higher Secondary School Certificate / Intermediate/ A - level</option>
                                    <option value="Bachelor (14 Years) Degree">Bachelor (14 Years) Degree</option>
                                    <option value="Bachelor (16 Years) Degree">Bachelor (16 Years) Degree</option>
                                    <option value="Master (16 Years) Degree">Master (16 Years) Degree</option>
                                    <option value="Master/ MS (18 Years) Degree">Master/ MS (18 Years) Degree</option>
                                    <option value="M-Phil (18 Years) Degree">M-Phil (18 Years) Degree</option>
                                    <option value="Doctorate Degree">Doctorate Degree</option>
                                    <option value="MS leading to PhD">MS leading to PhD</option>
                                    <option value="Post Doctorate">Post Doctorate</option>
                                    <option value="PGD">PGD</option>
                                </select>
                            </div>
                            <div>
                                <x-label for="board_university_name" value="Board/University Name" :required="true" />
                                <x-input id="board_university_name" name="board_university_name" class="block mt-1 w-full" type="text"/>
                            </div>


                            <div>
                                <x-label for="passing_year" value="Passing Year" :required="true" />
                                <select id="passing_year" name="passing_year" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select a passing year</option>
                                    @for($year = 1990; $year <= 2024; $year++  )
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <x-label for="division" value="Division" :required="true" />
                                <select id="division" name="division" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                    <option value="">Select a division</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="3rd">3rd</option>
                                </select>
                            </div>
                            <div>
                                <x-label for="total_marks_cgpa" value="Total Marks / CGPA" :required="true" />
                                <x-input id="total_marks_cgpa" name="total_marks_cgpa" class="block mt-1 w-full" type="number" step="0.01"/>
                            </div>

                            <div>
                                <x-label for="obtain_marks_cgpa" value="Obtain Marks / CGPA" :required="true" />
                                <x-input id="obtain_marks_cgpa" name="obtain_marks_cgpa" class="block mt-1 w-full" type="number" step="0.01"/>
                            </div>

                            <div>
                                <x-label for="major_subject" value="Major Subject" :required="true" />
                                <select id="major_subject" name="major_subject" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                </select>
                            </div>
                            <div>
                                <x-label for="degree_photo" value="Degree Photo Certificate" :required="true" />
                                <x-input id="degree_photo" name="degree_photo" class="block mt-1 w-full" type="file"/>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4" id="submit-btn" onclick="return confirm('Are you sure you want to add your education?')"> {{ __('Add') }}
                            </x-button>

                            <a href="{{ route('dashboard', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4" id="submit-btn"> {{ __('Back') }}
                            </a>

                            @if($user->education_degrees->isNotEmpty())
                                <a href="{{ route('experience.edit', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4" id="submit-btn"> {{ __('Next') }}
                                </a>
                            @endif


                        </div>
                    </form>

                </div>


                @if($user->education_degrees->isNotEmpty())
                    {{--                    <h2 class="text-lg font-bold text-center mt-2">Education Details</h2>--}}
                    <div class="relative overflow-x-auto shadow-md">
                        <table class="w-full text-sm text-left text-white dark:text-gray-400">
                            <thead class="text-xs text-white uppercase font-bold bg-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Degree
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Board/University
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Passing Year / Division
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Total / Obtain / Percentage
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Major Subject
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Degree
                                </th>

                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->education_degrees->sortBy('passing_year') as $degree)
                                <tr class="bg-white border-b text-black font-bold dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap dark:text-white">
                                        {{ $degree->education_level }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $degree->board_university_name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $degree->passing_year }} /  {{ $degree->division }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $degree->total_marks_cgpa }} / {{ $degree->obtain_marks_cgpa }}  = {{ $degree->percentage_marks }}%
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $degree->major_subject }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(!empty($degree->degree_photo_path))
                                            <a href="{{ \Illuminate\Support\Facades\Storage::url($degree->degree_photo_path) }}" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-auto">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </a>
                                        @endif
                                    </td>


                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('education.destroy', [$degree->id, $user->id]) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" >
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
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


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const educationLevelSelect = document.getElementById('education_level');
                const majorSubjectSelect = document.getElementById('major_subject');

                function updateMajorSubjects() {
                    const educationLevel = educationLevelSelect.value;
                    let options = '';

                    if (educationLevel === "Secondary School Certificate / Matriculation / O - level") {
                        options += `<option value="Biology (Matric/SSC 9th-10th Class)">Biology (Matric/SSC 9th-10th Class)</option>
                                    <option value="Computer (Matric/SSC 9th-10th Class)">Computer (Matric/SSC 9th-10th Class)</option>
                                    <option value="Others / Arts (Matric/SSC 9th-10th Class)">Others / Arts (Matric/SSC 9th-10th Class)</option>`;
                    } else if (educationLevel === "Higher Secondary School Certificate / Intermediate/ A - level") {
                        options += `<option value="Pre Engineering (Intermediate HSSC 11th-12th Class)">Pre Engineering (Intermediate HSSC 11th-12th Class)</option>
                                    <option value="Pre Medical (Intermediate HSSC 11th-12th Class)">Pre Medical (Intermediate HSSC 11th-12th Class)</option>
                                    <option value="ICS (Intermediate HSSC 11th-12th Class)">ICS (Intermediate HSSC 11th-12th Class)</option>
                                    <option value="ICOM (Intermediate HSSC 11th-12th Class)">ICOM (Intermediate HSSC 11th-12th Class)</option>
                                    <option value="Others / Arts (Intermediate HSSC 11th-12th Class)">Others / Arts (Intermediate HSSC 11th-12th Class)</option>`;
                    } else if (educationLevel === "Bachelor (14 Years) Degree" || educationLevel === "Bachelor (16 Years) Degree" || educationLevel === "Master (16 Years) Degree" || educationLevel === "Master/ MS (18 Years) Degree" || educationLevel === "M-Phil (18 Years) Degree" || educationLevel === "Doctorate Degree" || educationLevel === "MS leading to PhD" || educationLevel === "Post Doctorate" || educationLevel === "PGD") {
                        options += `<option value="Economics">Economics</option>
                                    <option value="Business Administration">Business Administration</option>
                                    <option value="Accounting">Accounting</option>
                                    <option value="Finance">Finance</option>
                                    <option value="Commerce">Commerce</option>
                                    <option value="CS/MCS/MIT">Computer Science & IT / MCS / IT</option>`;
                    } else {
                        // If none of the above conditions match, or if "Please select a degree" is selected
                        options = '<option value="">Please select a major subject</option>'; // Show none or a prompt
                    }

                    majorSubjectSelect.innerHTML = options;
                }

                // Initially update major subjects based on the default selected education level
                updateMajorSubjects();

                // Update major subjects whenever the selected education level changes
                educationLevelSelect.addEventListener('change', updateMajorSubjects);
            });
        </script>


    @endpush
</x-app-layout>
