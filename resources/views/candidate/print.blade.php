<x-app-layout>
    @push('custom_headers')


        <script src="https://cdn.tiny.cloud/1/izbyerk8x92uls8z2ulnezm5uaudhf41lw0lebop5ba724o5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
              selector: 'textarea',
              plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
              toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            });
        </script>
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
            </a>
            <button onclick="window.print()" class=" text-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-black dark:border-gray-200 dark:hover:bg-white dark:bg-gray-700 ml-2" title="Members List">
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

                        <table style="margin: 0px;">
                            <tr>
                                <td style="width: 33.33%">
                                    <div style="float: left; margin-left: 40%">
                                        @php $test_report_data = "https://pip.bankajk.com/candidate/show/" . $user->id; @endphp
                                        {!! DNS2D::getBarcodeSVG($test_report_data, 'QRCODE',3,3) !!}
                                    </div>
                                </td>
                                <td style="width: 33.33%"><img src="{{ url('images/logo.png') }}" alt="Logo" style="margin:auto; height: 100px;"></td>
                                <td style="width: 33.33%; text-align: center;">
                                    <div style="margin: auto; margin-left: 30%">
                                        @if ($user->profile_photo_path)
                                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Internee Picture" style="width: 2in; height: 2in; border: 1px solid #000;">
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
                                    ({{ \Carbon\Carbon::parse($user->date_of_birth)->diff(now())->format('%y Y') }})
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

                            <tr>
                                <td style="font-weight: bold;">Profile</td>
                                <td>@if($user->profile_status == 1) Submitted @else In-Complete @endif</td>
                                <td style="font-weight: bold;">Status</td>
                                <td>{{ $user->status }}</td>
                            </tr>

                        </table>





                        @if($user->education_degrees->isNotEmpty())

                            <h1 class="text-center font-extrabold">Education</h1>
                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                                <thead>
                                <tr class="border-black">
                                    <th class="border-black border px-4 py-2 text-left">No</th>
                                    <th class="border-black border px-4 py-2 text-left">Degree</th>
                                    <th class="border-black border px-4 py-2 text-left">University</th>
                                    <th class="border-black border px-4 py-2 text-left"> Year / Division</th>
                                    <th class="border-black border px-4 py-2 text-left"> OBTAIN / TOTAL = PERCENTAGE</th>
                                    <th class="border-black border px-4 py-2 text-left">Major Subject</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($user->education_degrees->sortBy('passing_year') as $deg)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->education_level }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->board_university_name }}</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $deg->passing_year }} / {{ $deg->division }}</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $deg->obtain_marks_cgpa }} / {{ $deg->total_marks_cgpa }} = {{ $deg->percentage_marks }}%</td>
                                        <td class="border-black border px-4 py-2 text-left">{{ $deg->major_subject }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif



                        @if($user->experience->isNotEmpty())
                            <h1 class="text-center font-extrabold">Experience</h1>
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

                                @foreach($user->experience->sortBy('passing_year') as $deg)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2">{{ $loop->iteration }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->organization }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->designation }}</td>
                                        <td class="border-black border px-4 py-2">
                                            @if($deg->government_private)
                                                Government
                                            @else
                                                Private
                                            @endif</td>
                                        <td class="border-black border px-4 py-2"> {{ number_format($deg->monthly_salary,2) }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->starting_date }} / {{ $deg->ending_date }}</td>
                                        <td class="border-black border px-4 py-2"> {{ $deg->reason_of_leaving }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>

                        @endif


                        <br>

                        <div class="break-before-page mb-2">
                            <!-- Content -->
                            <div class="text-center mt-2 text-xl">
                                <span class="uppercase underline" style="font-weight: bold;"></span>
                            </div>
                        </div>
                        <h1 class="text-center font-extrabold">CNIC Font</h1>
                        <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                            <tbody>
                            <tr class="border-black">
                                <td class="border-black border px-4 py-2" style="margin: auto;">
                                    @if(!empty($user->cnic_front_path))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($user->cnic_front_path) }}" style="width: 3.5in; height: 2.0in; margin: auto;" alt="CNIC Front">
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <h1 class="text-center font-extrabold">CNIC Back</h1>
                        <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                            <tbody>
                            <tr class="border-black">
                                <td class="border-black border px-4 py-2" style="margin: auto;">
                                    @if(!empty($user->cnic_back_path))
                                        <img src="{{ \Illuminate\Support\Facades\Storage::url($user->cnic_back_path) }}" style="width: 3.5in; height: 2.0in; margin: auto;" alt="CNIC Back">
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>


                        @if($user->education_degrees->isNotEmpty())
                            <div class="break-before-page mb-2">
                                <!-- Content -->
                                <div class="text-center mt-2 text-xl">
                                    <span class="uppercase underline" style="font-weight: bold;"></span>
                                </div>
                            </div>
                            <h1 class="text-center font-extrabold">Education Degrees</h1>
                            <table class="table-auto w-full border-collapse border border-black" style="font-size: 12px;">
                                <tbody>
                                @foreach($user->education_degrees->sortBy('passing_year') as $deg)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2" style="margin: auto;">
                                            @if(!empty($deg->degree_photo_path))
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($deg->degree_photo_path) }}" style="width: 8in; height: 8in; margin: auto;">
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
                                @foreach($user->experience->sortBy('passing_year') as $deg)
                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2" style="margin: auto;">
                                            @if(!empty($deg->experience_photo_path))
                                                <img src="{{ \Illuminate\Support\Facades\Storage::url($deg->experience_photo_path) }}" style="width: 8in; height: 8in; margin: auto;" alt="Education Degree">
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        @endif


                        <br>
                        <br>
                        <h1 class="text-3xl p-4 m-4 text-center font-extrabold bg-yellow-500 rounded-md">Human Resource Management Division</h1>

                        @if($user->comments->isNotEmpty())
                            <ol class="relative border-s border-gray-200 dark:border-gray-700  ml-12 mt-4 mb-4 ">
                                @foreach($user->comments as $cmt)
                                    <li class="mb-10 ms-6">
                                    <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -start-3 ring-8 ring-white dark:ring-black dark:bg-blue-900">
                                        <svg class="w-2.5 h-2.5 text-blue-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </span>
                                        <h3 class="mb-1 text-lg font-semibold text-black dark:text-white"> {{ \App\Models\User::find($cmt->user_id_comment_by)->name }} Decided <span class="bg-red-500 text-white text-lg font-extrabold me-2 px-2.5 py-0.5 rounded ms-3">{{ $cmt->status }}</span>    @if($cmt->index) <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 ms-3">Latest</span> @endif</h3>
                                        <time class="block mb-2 text-lg  leading-none font-extrabold text-red-400 dark:text-red-500 mt-3">Decision on {{ \Carbon\Carbon::parse($cmt->created_at)->format('F j, Y G:i:s') }}</time>
                                        <p class="text-lg font-extrabold text-black dark:text-black mt-2">{!! $cmt->comments !!}</p>
                                    </li>
                                @endforeach
                            </ol>

                        @endif






                        <form action="{{ route('candidate.shortlisted', $user->id) }}" method="POST" class="print:hidden">
                            @csrf
                            <div class="grid grid-cols-1 mb-8 pb-8 md:grid-cols-1 lg:grid-cols-1 gap-4 mt-4" style="padding-left: 50px!important; padding-right: 50px!important;">
                                <div>


                                    <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail Decision Remarks</label>
                                    <textarea id="comment" name="comment"  rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                                </div>
                                <div>
                                    <label class="block font-extrabold font-medium text-sm text-black" for="status">
                                        Detail Decision Remarks
                                        <span class="text-red-500">*</span>
                                    </label>
                                    <select id="status" required name="status" class="border-gray-300 dark:border-gray-700 dark:bg-black dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">None</option>
                                        <option value="Pending">Pending</option>
                                        <option value="Shortlisted">Shortlisted</option>
                                        <option value="Rejected">Rejected</option>
                                    </select>
                                </div>

                                <div class="flex items-center justify-end mt-1">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" id="submit-btn">
                                        Save Final Decision
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('modals')
        <script>
            document.getElementById('submit-btn').addEventListener('click', function(event) {
                const confirmed = confirm('Are you sure you have read all the profile of this candidate?');
                if (!confirmed) {
                    event.preventDefault(); // Prevent form submission
                }
            });

        </script>
    @endpush
</x-app-layout>