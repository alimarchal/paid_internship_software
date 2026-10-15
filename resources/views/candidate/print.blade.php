<x-app-layout>
    @push('custom_headers')


        <!--<script src="https://cdn.tiny.cloud/1/izbyerk8x92uls8z2ulnezm5uaudhf41lw0lebop5ba724o5/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>-->
        <!--<script>
        //     tinymce.init({
        //       selector: 'textarea',
        //       plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
        //       toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
        //     });
        </script> -->
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
        <x-page-header title="Candidate #{{ $user->id }}" :backRoute="url()->previous()" :showRefresh="false">
            <button type="button" onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-blue-950 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 focus:outline-none" title="Print">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span class="hidden md:inline-block ml-1">Print</span>
            </button>
        </x-page-header>
    </x-slot>
    <div class="py-1">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 ">
                <div class=" mb-4 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                    <!-- resources/views/users/create.blade.php -->
                    <x-validation-errors class="mb-4 mt-4"/>
                    <x-status-message class="mb-4"/>

                    @php
                        $viewerIsAdmin = Auth::user()->hasRole(['admin', 'Super-Admin']);
                        $badge = fn ($v) => $v === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($v === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                        $paperCount = \App\Models\RandomUserQuestion::where('user_id', $user->id)->count();
                        $history = $user->comments()->limit(3)->get();
                    @endphp
                    <div class="print:hidden mb-4 rounded-lg border border-gray-200 bg-gray-50 p-4">
                        <div class="flex flex-wrap items-center gap-x-6 gap-y-2">
                            <div>
                                <div class="text-lg font-bold text-gray-900">{{ ucwords(strtolower($user->name)) }}</div>
                                <div class="text-xs text-gray-500">Application No {{ $user->id }} &middot; {{ $user->email }}</div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 text-xs">
                                <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-800 font-semibold">{{ $user->batch_no }}</span>
                                <span class="px-2 py-1 rounded font-semibold {{ $user->profile_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->profile_status == 1 ? 'Profile submitted' : 'Profile incomplete' }}</span>
                                <span class="px-2 py-1 rounded font-semibold {{ $badge($user->status) }}">{{ $user->status }}</span>
                                <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 font-semibold">
                                    @if($user->exam_taken) Exam finished @elseif($user->start_test) Exam allowed @else Exam not allowed @endif
                                    @if($paperCount) &middot; {{ $paperCount }} q. @endif
                                </span>
                            </div>
                            @if($viewerIsAdmin)
                                <div class="ml-auto flex gap-2">
                                    <a href="{{ route('candidate-user.password-change', $user->id) }}" class="px-3 py-1.5 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">Exam setup</a>
                                </div>
                            @endif
                        </div>

                        @if($viewerIsAdmin)
                            <form action="{{ route('candidate.shortlisted', $user->id) }}" method="POST" class="mt-4 grid grid-cols-1 md:grid-cols-6 gap-3 items-end border-t border-gray-200 pt-4">
                                @csrf
                                <div class="md:col-span-2">
                                    <label for="status" class="block text-sm font-medium text-gray-800">Decision <span class="text-red-500">*</span></label>
                                    <select id="status" required name="status" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a decision</option>
                                        @foreach(['Shortlisted', 'Pending', 'Rejected'] as $st)
                                            <option value="{{ $st }}">{{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-3">
                                    <label for="comment" class="block text-sm font-medium text-gray-800">Remarks</label>
                                    <input id="comment" name="comment" type="text" class="border-gray-300 rounded-md shadow-sm block mt-1 w-full" placeholder="Optional remarks saved with the decision">
                                </div>
                                <div>
                                    <button type="submit" id="submit-btn" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-950 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800">Save Decision</button>
                                </div>
                            </form>

                            @if($history->isNotEmpty())
                                <div class="mt-3 text-xs text-gray-600">
                                    <span class="font-semibold">Recent decisions:</span>
                                    @foreach($history as $h)
                                        <span class="inline-block mr-3"><span class="px-1.5 py-0.5 rounded {{ $badge($h->status) }}">{{ $h->status }}</span> {{ $h->created_at->format('d-M-Y H:i') }}@if($h->comments) &mdash; {{ \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode($h->comments))), 120) }}@endif</span>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>

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







                        
                        
                          @if($get_user_questions->isNotEmpty())
                           
                        @if(Auth::user()->email == "dh_hrd@bankajk.com")
                                 <h1 class="text-center font-extrabold">User Paper Questions</h1>
                                <div style="margin: 50px;">
                                <table class="table-auto w-full border-collapse border border-black" style="font-size: 16px;">
                                    {{--                                <thead>--}}
                                    {{--                                <tr class="border-black">--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left">No</th>--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left">Degree</th>--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left">University</th>--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left"> Year / Division</th>--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left"> OBTAIN / TOTAL = PERCENTAGE</th>--}}
                                    {{--                                    <th class="border-black border px-4 py-2 text-left">Major Subject</th>--}}
                                    {{--                                </tr>--}}
                                    {{--                                </thead>--}}
                                    <tbody>

                                    @foreach($get_user_questions as $question)
                                        <tr class="border-black">
                                            <td class="border-black border px-4 py-2" >{{ $loop->iteration }}</td>
                                            <td class="border-black border px-4 py-2" >{!! \App\Models\Question::find($question->question_id)->text !!} </td>
                                        </tr>
                                        <tr class="border-black">
                                            <td class="border-black border px-4 py-2" colspan="2">
                                                <ul class="list-none">
                                                    @foreach(\App\Models\Question::find($question->question_id)->answers as $ans)
                                                        <li style="padding-left: 100px" class="font-extrabold">{{ $ans->text }}
                                                            @if(!empty($question->answer_id)) @if($question->answer_id == $ans->id) ✔ @endif  @endif
                                                            @if($ans->is_correct == 1) (Correct Answer) @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach


                                    <tr class="border-black">
                                        <td class="border-black border px-4 py-2"></td>
                                        <td class="border-black border px-4 py-2">
                                            Total Question Assigned By System: {{ $get_user_questions->count('id') }}<br>
                                            Attempt Question: {{ $get_user_questions->sum('is_answered') }}<br>
                                            Correct Answers: {{ $get_user_questions->sum('is_correct') }}<br>
                                            In-Correct Answers: {{ $get_user_questions->where('is_correct',0)->count() }}<br>
                                            Total Marks: {{ $get_user_questions->count('id') }}<br>
                                            Obtain Marks: {{ $get_user_questions->sum('is_correct') }}
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>
                        @endif
                        @else($get_user_questions->isEmpty())
                            @if($user->exam_taken == 1) <h1 class="text-center font-extrabold">User Was Absent - No Record Exist</h1> @endif
                        @endif


                        <br>
                        <br>

                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('modals')
        <script>
            document.getElementById('submit-btn')?.addEventListener('click', function(event) {
                const confirmed = confirm('Are you sure you have read all the profile of this candidate?');
                if (!confirmed) {
                    event.preventDefault(); // Prevent form submission
                }
            });

        </script>
    @endpush
</x-app-layout>