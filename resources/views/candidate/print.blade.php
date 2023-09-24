<x-app-layout>
    @push('custom_headers')
        <style>
            table, td, th {
                /*border: 1px solid;*/
                padding-left: 5px;
            }

            table {
                width: 100%;
                font-size: 12px;
                border-collapse: collapse;
            }
        </style>


        <style>

            @media screen {
                .table_header_print {
                    display: none;
                }
            }

            @media print {
                body {
                    margin: 0;
                    padding: 0;
                }

                .header-print {
                    width: 100%;
                    height: 100px; /* Adjust the height as needed */
                    margin: 0;
                    padding: 0;
                    position: fixed;
                    top: 0;
                    left: 0;
                    background-color: white; /* Set the background color you want */
                }

                .table_header_print {
                    width: 100%;
                }

                .table_header_print td {
                    width: 33.33%;
                    text-align: center; /* Center the content horizontally */
                }

                .table_header_print img {
                    height: 100px;
                }

                table, td, th {
                    /*border: 1px solid;*/
                }

                .qrcode {
                    float: right;
                }
            }

            /* Hide the header on the screen */
            .header-print {
                display: none;
            }
        </style>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block"> {{ __('Student Admission') }} </h2>
        <div class="flex justify-center items-center float-right">
            <a href="{{ url()->previous() }}"
               class="text-center px-4 py-1.5 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-black dark:border-gray-200 dark:hover:bg-white dark:bg-gray-700"
               title="Back">
                Back
            </a>            <button onclick="window.print()" class=" text-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-black dark:border-gray-200 dark:hover:bg-white dark:bg-gray-700 ml-2" title="Members List">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
            </button>
        </div>
    </x-slot>
    <div class="py-1">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 ">
                <div class=" mb-4 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                    <!-- resources/views/users/create.blade.php -->
                    <x-validation-errors class="mb-4 mt-4"/>
                    <x-status-message class="mb-4"/>

                    <div class="bg-white">

                        <table class="table_header_print" style="margin: 0px;">
                            <tr>
                                <td style="width: 33.33%">
                                    <div style="float: left; margin-left: 40%">
                                        @php $test_report_data = "https://pip.bankajk.com/" . $user->id; @endphp
                                        {!! DNS2D::getBarcodeSVG($test_report_data, 'QRCODE',3,3) !!}
                                    </div>
                                </td>
                                <td style="width: 33.33%"><img src="{{ url('images/logo.png') }}" alt="Logo" style="margin:auto; height: 100px;"></td>
                                <td style="width: 33.33%; text-align: center;">
                                    <div style="margin: auto; margin-left: 30%">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Internee Picture" style="width: 150px; height: 150px; border: 1px solid #000;">
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>


                        <table style="margin-top: 5px; font-size:20px; line-height: 1; text-align: center; font-weight: bold;">
                            <tr>
                                <td>
                                    Paid Internship<br>
                                    Internee Information
                                </td>
                            </tr>
                        </table>

                        <table style="margin-top: 2px;">
                            <tr>
                                <td style="font-weight: bold;">Application No</td>
                                <td>{{ $user->id }}</td>
                                <td style="font-weight: bold;">Application Date</td>
                                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d-M-Y') }}</td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Name</td>
                                <td>{{ $user->name }}</td>
                                <td style="font-weight: bold;">Father Name</td>
                                <td>{{ $user->fathers_name }}</td>
                            </tr>


                            <tr>
                                <td style="font-weight: bold;">Gender</td>
                                <td>{{ $user->gender }}</td>
                                <td style="font-weight: bold;">Date of Birth</td>
                                <td>{{ \Carbon\Carbon::parse($user->date_of_birth)->format('d-M-Y') }} -
                                    ({{ \Carbon\Carbon::parse($user->date_of_birth)->diff(now())->format('%y years') }})
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Nationality</td>
                                <td>{{ $user->nationality }}</td>
                                <td style="font-weight: bold;">CNIC</td>
                                <td>
                                    {{ $user->cnic_number }}
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">District</td>
                                <td>{{ $user->district }}</td>
                                <td style="font-weight: bold;">Domicile</td>
                                <td>
                                    {{ $user->district_of_domicile }}
                                </td>
                            </tr>

                            <tr>
                                <td style="font-weight: bold;">Religion</td>
                                <td>{{ $user->religion }}</td>
                                <td style="font-weight: bold;">Marital Status</td>
                                <td>{{ $user->marital_status }}</td>
                            </tr>


                            <tr>
                                <td style="font-weight: bold;">Mobile Number</td>
                                <td>{{ $user->contact_number }}</td>
                                <td style="font-weight: bold;">Phone No</td>
                                <td>{{ $user->phone_no }}</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold;">Mailing Address</td>
                                <td colspan="2">{{ $user->mailing_address }}</td>
                            </tr>

                        </table>


                        <h1 class="text-center font-extrabold">Education</h1>


                        @if($user->education_degrees->isNotEmpty())

                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                                <thead>
                                <tr class="border-black">
                                    <th class="border-black border px-4 py-2 text-left">No</th>
                                    <th class="border-black border px-4 py-2 text-left">Degree</th>
                                    <th class="border-black border px-4 py-2 text-left">University</th>
                                    <th class="border-black border px-4 py-2 text-left"> Year / CGPA</th>
                                    <th class="border-black border px-4 py-2 text-left">Div / % / Marks</th>
                                    <th class="border-black border px-4 py-2 text-left">Major Subject</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($user->education_degrees->sortBy('passing_year') as $degree)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->education_level }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->board_university_name }}</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $degree->passing_year }} / {{ $degree->cgpa_cpa_grade }}</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $degree->division }} - {{ $degree->percentage_marks }}</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $degree->major_subject }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif


                        <h1 class="text-center font-extrabold">Experience</h1>
                        @if($user->experience->isNotEmpty())

                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                                <thead>
                                <tr class="border-black">
                                    <th class="border-black border px-4 py-2 text-left">No</th>
                                    <th class="border-black border px-4 py-2 text-left">Organization</th>
                                    <th class="border-black border px-4 py-2 text-left">Designation</th>
                                    <th class="border-black border px-4 py-2 text-left">Type</th>
                                    <th class="border-black border px-4 py-2 text-left">Monthly Salary</th>
                                    <th class="border-black border px-4 py-2 text-left">Starting / Ending Date</th>
                                    <th class="border-black border px-4 py-2 text-left">Reason of Leaving</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($user->experience->sortBy('passing_year') as $degree)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->organization }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->designation }}</td>
                                        <td class="border-black border px-4 py-2">
                                            @if($degree->government_private)
                                                    Government
                                                @else
                                                    Private
                                                @endif</td>
                                        <td class="border-black border px-4 py-2"> {{ number_format($degree->monthly_salary,2) }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->starting_date }} / {{ $degree->ending_date }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $degree->reason_of_leaving }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif





                        <br>



                        @if($user->education_degrees->isNotEmpty())

                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">

                                <tbody>
                                @foreach($user->education_degrees->sortBy('passing_year') as $degree)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2" style="margin: auto;">
                                            @if(!empty($degree->degree_photo_path))
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($degree->degree_photo_path) }}" style="width: 8in;" alt="Education Degree">
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif




                        @if($user->experience->isNotEmpty())

                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">

                                <tbody>
                                @foreach($user->experience->sortBy('passing_year') as $degree)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2" style="margin: auto;">
                                            @if(!empty($degree->experience_photo_path))
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($degree->experience_photo_path) }}" style="width: 8in;" alt="Education Degree">
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif

                    </div>


                </div>
            </div>
        </div>
    </div> @push('modals')
        <script>
            // Add a script to format the CNIC input as 00000-0000000-0
            document.getElementById('cnic').addEventListener('input', function (e) {
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
            // // Disable the submit button after it's clicked
            // document.getElementById('submit-btn').addEventListener('click', function (e) {
            //     // Disable the button to prevent multiple submissions
            //     this.disabled = true;
            // });
        </script>
    @endpush
</x-app-layout>