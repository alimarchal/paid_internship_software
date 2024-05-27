<x-app-layout>

    @push('custom_headers')

        <style>
            table, td, th {
                border: 1px solid;
                /*padding-left: 5px;*/
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }
        </style>


        <style>


            @media print {
                body {
                    /*margin: -20px!important;*/
                }
            }

            /*@media screen {*/
            /*    .table_header_print {*/
            /*        display: none;*/
            /*    }*/
            /*}*/

            /*@media print {*/
            /*    body {*/
            /*        margin: 0;*/
            /*        padding: 0;*/
            /*    }*/

            /*    .header-print {*/
            /*        width: 100%;*/
            /*        height: 100px; !* Adjust the height as needed *!*/
            /*        margin: 0;*/
            /*        padding: 0;*/
            /*        position: fixed;*/
            /*        top: 0;*/
            /*        left: 0;*/
            /*        background-color: white; !* Set the background color you want *!*/
            /*    }*/

            /*    .table_header_print {*/
            /*        width: 100%;*/
            /*    }*/

            /*    .table_header_print td {*/
            /*        width: 33.33%;*/
            /*        text-align: center; !* Center the content horizontally *!*/
            /*    }*/

            /*    .table_header_print img {*/
            /*        height: 100px;*/
            /*    }*/

            /*    table, td, th {*/
            /*        !*border: 1px solid;*!*/
            /*    }*/

            /*    .qrcode {*/
            /*        float: right;*/
            /*    }*/
            /*}*/

            /* Hide the header on the screen */
            /*.header-print {*/
            /*    display: none;*/
            /*}*/
        </style>

    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl uppercase text-gray-800 dark:text-gray-200 leading-tight inline-block">
            Print Profile
        </h2>


        <div class="flex justify-center items-center float-right">
            <a href="javascript:;" onclick="window.print()"
               class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z"/>
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg  print:shadow-none">

                <x-status-message class="mb-4"/>
                <div class="pb-4 lg:pb-4 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700 print:border-none">
                    <div class="bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:via-transparent print:border-none print:text-black ">


                        @if(Auth::user()->email == "dh_hrd@bankajk.com")
                            <table style="border: none;">
                                <tr style="border: none;">
                                    <td style=" width: 20%; border:none;">
                                        <div style="margin: auto;">
                                            <img src="{{ Storage::url('logo.png') }}" alt="Bank Logo Picture" style="margin: auto">
                                        </div>
                                    </td>
                                    <td style="width: 60%; border: none;">
                                        <p class="text-center font-bold uppercase " style=" font-size: 13px;">
                                            The Bank of Azad Jammu & Kashmir
                                        </p>
                                        <p class="text-center capitalize font-extrabold text-black" style="font-size: 12px;">
                                            Human Resource Management Division, Head Office, Muzaffarabad
                                        <p class="text-center capitalize font-extrabold text-black" style="font-size: 12px;">Phone Office:
                                            +92-5822-920532
                                        </p>
                                        <p class="text-center font-extrabold text-black" style="font-size: 12px;">
                                            E-Mail: hrd@bankajk.com
                                        </p>
                                        <p class="text-center font-extrabold capitalize underline " style="font-size: 14px;">
                                            Paid Internship Portal Result
                                        </p>
                                    </td>
                                    <td style="width: 20%; text-align: center;border: none;">

                                        <div style="float: right; margin-right: 10%;">
                                            {{--                                        @php--}}
                                            {{--                                            $test_report_data = "Name: " . $candidates->name . " \nRoll No: " .  $candidates->id . "\nCNIC:" . $candidates->cnic_number;--}}
                                            {{--                                        @endphp--}}
                                            {{--                                        {!! DNS2D::getBarcodeSVG($test_report_data, 'QRCODE',3,3) !!}--}}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <hr>
                            <table class="mt-2">
                                <thead>
                                <tr style="font-weight: bold; text-align: center;">
                                    <td>ID</td>
                                    <td>IAN</td>
                                    <td>Name</td>
                                    <td>Father / Husband</td>
                                    <td>District</td>
                                    <td>Domicile</td>
                                    <td>Attendance</td>
                                    <td>SAQ</td>
                                    <td>Attempt Question</td>
                                    <td>Correct</td>
                                    <td>In-Correct</td>
                                    <td>%</td>
                                </tr>
                                </thead>
                                @foreach($users as $user)
                                    @php
                                        $check = \App\Models\RandomUserQuestion::where('user_id', $user->id)->first();
                                        $result_att = null;
                                        if (!empty($check)) {
                                            $result_att = "P";

                                        } else {
                                            $result_att = "A";
                                        }


                                    @endphp

                                    <tr style="text-align: center; font-size: 12px;">
                                        <td class="px-2">{{ $loop->iteration }}</td>
                                        <td class="px-2">{{ $user->id }}</td>
                                        <td class="px-2" style="text-align: left;"> {{ $user->gender == 'Male' ? 'Mr.' : 'Ms.' }} {{ $user->name }}</td>
                                        <td class="px-2" style="text-align: left;"> {{ $user->fathers_name }}</td>
                                        <td class="px-2"> {{ $user->district }}</td>
                                        <td class="px-2"> {{ $user->district_of_domicile }}</td>
                                        <td class="px-2">
                                            {{ $result_att }}
                                        </td>
                                        <td class="px-2">
                                            @if($result_att == "P")
                                                {{ \App\Models\RandomUserQuestion::where('user_id', $user->id)->count() }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-2">
                                            @if($result_att == "P")
                                                {{ \App\Models\RandomUserQuestion::where('user_id', $user->id)->sum('is_answered') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-2">
                                            @if($result_att == "P")
                                                {{ \App\Models\RandomUserQuestion::where('user_id', $user->id)->sum('is_correct') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-2">
                                            @if($result_att == "P")
                                                {{ \App\Models\RandomUserQuestion::where('user_id', $user->id)->where('is_correct',0)->count() }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-2">
                                            @if($result_att == "P")
                                                {{ round( (\App\Models\RandomUserQuestion::where('user_id', $user->id)->sum('is_correct') / \App\Models\RandomUserQuestion::where('user_id', $user->id)->count('id')) * 100, 2 ) }}%
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach
                            </table>

                            <div class="break-before-page mb-2">
                                <!-- Content -->
                            </div>


                            <br>


                            <h1 class="text-2xl text-center">Merit List</h1>
                            <table class="mt-2">
                                <thead>
                                <tr style="font-weight: bold; text-align: center;">
                                    <td>ID</td>
                                    <td>IAN</td>
                                    <td>Name</td>
                                    <td>Father / Husband</td>
                                    <td>District</td>
                                    <td>Domicile</td>
                                    <td>System Assigned Questions</td>
                                    <td>Attempt Question</td>
                                    <td>Correct Answers</td>
                                </tr>
                                </thead>

                                @foreach($results as $result)
                                    <tr style="text-align: center; font-size: 12px;">
                                        <td class="px-2">{{ $loop->iteration }}</td>
                                        <td class="px-2">{{ $result->user->id }}</td>
                                        <td class="px-2" style="text-align: left;"> {{ $result->user->gender == 'Male' ? 'Mr.' : 'Ms.' }} {{ $result->user->name }}</td>
                                        <td class="px-2" style="text-align: left;"> {{ $result->user->fathers_name }}</td>
                                        <td class="px-2"> {{ $result->user->district }}</td>
                                        <td class="px-2"> {{ $result->user->district_of_domicile }}</td>
                                        <td class="px-2">{{ $result->system_assigned_questions }}</td>
                                        <td class="px-2">{{ $result->attemp_questions }}</td>
                                        <td class="px-2">{{ $result->correct_answer }}</td>
                                    </tr>
                                @endforeach
                            </table>

                            <div class="break-before-page mb-2">
                                <!-- Content -->
                            </div>
                        @endif




                        @role('Intern')

                                @foreach($cdt as $candidates)
                                    <table style="border: none;">
                                        <tr>
                                            <td style="width: 20%;border: none;">
                                                <div style="margin: auto;">
                                                    <img src="{{ Storage::url('logo.png') }}" alt="Bank Logo Picture" style="margin: auto">
                                                </div>
                                            </td>
                                            <td style="width: 60%;border: none;">
                                                <p class="text-center font-bold uppercase " style=" font-size: 13px;">
                                                    The Bank of Azad Jammu & Kashmir
                                                </p>
                                                <p class="text-center capitalize font-extrabold text-black" style="font-size: 12px;">
                                                    Human Resource Management Division, Head Office, Muzaffarabad
                                                <p class="text-center capitalize font-extrabold text-black" style="font-size: 12px;">Phone Office:
                                                    +92-5822-920532
                                                </p>
                                                <p class="text-center font-extrabold text-black" style="font-size: 12px;">
                                                    E-Mail: hrd@bankajk.com
                                                </p>
                                                <p class="text-center font-extrabold capitalize " style="font-size: 14px;">
                                                    (Result Card)
                                                </p>
                                            </td>
                                            <td style="width: 20%; text-align: center;;border: none;">

                                                <div style="float: right; margin-right: 10%;;border: none;">
                                                    @php
                                                        $test_report_data = "Name: " . $candidates->name . " \nRoll No: " .  $candidates->id . "\nCNIC:" . $candidates->cnic_number;
                                                    @endphp
                                                    {!! DNS2D::getBarcodeSVG($test_report_data, 'QRCODE',3,3) !!}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>

                                    <hr>
                                    <table class="mt-4" style="border: none;">
                                        <tr>
                                            <td style="width: 80%;border: none;" >
                                                <p class="text-left font-bold px-2 capitalize" style="font-size: 14px!important;">
                                                    <span class="font-extrabold">Internee Application No: {{ $candidates->id }}</span><br>
                                                    <span class="font-extrabold uppercase">CNIC: {{ $candidates->cnic_number }}</span>
                                                </p>
                                                <p class="text-left font-bold px-2 capitalize" style="font-size: 14px!important;">
                                                    Name:
                                                    {{ $candidates->gender == 'Male' ? 'Mr.' : 'Ms.' }} {{ $candidates->name }}
                                                    <br>
                                                    Father / Husband Name: {{ $candidates->fathers_name }}
                                                </p>

                                                <p class="text-left font-bold px-2 capitalize" style="font-size: 14px!important;">
                                        <span class="capitalize">Gender / Age:
                                            {{ $candidates->gender }}</span> - {{ \Carbon\Carbon::parse($candidates->date_of_birth)->format('d-M-Y')  }} ({{ \Carbon\Carbon::parse($candidates->date_of_birth)->diff(\Carbon\Carbon::now())->format('%yy') }})
                                                    <br>


                                                </p>


                                                <p class="text-left font-bold px-2  capitalize">
                                                    {{--                                            Test Center: {{ $candidates->test_center }}<br>--}}
                                                    {{--                                            Reporting Time: {{ $candidates->reporting_time }} (PST)<br>--}}
                                                    {{--                                            Test Date: {{ \Carbon\Carbon::parse($candidates->test_date)->format('l, d F, Y') }} <br>--}}
                                                    {{--                                            Duration: 90 Minutes--}}
                                                    {{--                                        Address:--}}
                                                    {{--                                        {{ $candidates->mailing_address }}--}}
                                                    {{--                                        <br> District: {{ $candidates->district }}--}}
                                                </p>

                                            </td>
                                            <td style="width: 20%; text-align: center;;border: none;">
                                                <div style="margin: auto;">

                                                    @if ($candidates->profile_photo_path)
                                                        <img src="{{ Storage::url($candidates->profile_photo_path) }}" alt="Internee Picture" class="rounded-lg" style="width: 1in; height: 1in; border: 1px solid #000; margin: auto">
                                                    @else
                                                        N/A
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </table>



                                    <div class="text-center" style="font-size: 12px!important;">
                            <span class="uppercase" style="font-weight: bold;">
                                Subject:
                                <span class="underline">One Paper Test (MCQs) Result</span>
                            </span>
                                    </div>
                                    <div class="p-2 mx-auto">
                                        <div class="mb-2">
                                            <p class="text-sm text-black"  style="font-size: 12px!important;">

                                                @if($results->isNotEmpty())
                                                <h1 class="text-2xl text-center"></h1>
                                                <table class="mt-2">
                                                    <thead>
                                                    <tr style="font-weight: bold; text-align: center;">
                                                        <td>Automatic System Assigned Questions</td>
                                                        <td>Attempt Question</td>
                                                        <td>Correct Answers</td>
                                                        <td>Result Percentage</td>
                                                    </tr>
                                                    </thead>

                                                    @foreach($results as $result)
                                                        <tr style="text-align: center; font-size: 16px;">
                                                            <td class="px-2">{{ $result->system_assigned_questions }}</td>
                                                            <td class="px-2">{{ $result->attemp_questions }}</td>
                                                            <td class="px-2">{{ $result->correct_answer }}</td>
                                                            <td class="px-2">{{ round(($result->correct_answer/$result->system_assigned_questions*100),2) }}%</td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                @else
                                                <span class="text-2xl text-red-500 font-extrabold">Dear Candidate,</span><br>
                                                    <p class=" text-center"><span class="text-2xl text-red-500  font-extrabold">You were not present for the test; you were marked as absent.</span></p>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-2 text-black">

                                            <p class="text-sm text-black text-center">
                                                <strong>Please note that this is a computer-generated document and does not require any signature.</strong>
                                            </p>

                                        </div>
                                    </div>
                                    <br>
                                    <div class="break-before-page mb-2">
                                        <!-- Content -->
                                    </div>

                                @endforeach


                            @endrole



                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
