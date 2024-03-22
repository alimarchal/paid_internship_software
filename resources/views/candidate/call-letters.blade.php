<x-app-layout>

    @push('custom_headers')

        <style>
            table, td, th {
                /*border: 1px solid;*/
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg  print:shadow-none">

                <x-status-message class="mb-4"/>
                <div class="pb-4 lg:pb-4 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700 print:border-none">
                    <div class="bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:via-transparent print:border-none print:text-black ">



                        @foreach($cdt as $candidates)
                        <table>
                            <tr>
                                <td style="width: 20%">
                                    <div style="margin: auto;">
                                        <img src="{{ Storage::url('logo.png') }}" alt="Bank Logo Picture" style="margin: auto">
                                    </div>
                                </td>
                                <td style="width: 60%">
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
                                         (Admit Card)
{{--Date: {{ date('d-m-Y') }} <br>--}}
                                    </p>
                                </td>
                                <td style="width: 20%; text-align: center;">

                                    <div style="float: right; margin-right: 10%;">
                                        @php
                                            $test_report_data = "Name: " . $candidates->name . " \nRoll No: 1" .  $candidates->id . "\n" . "The Bank of Azad Jammu & Kashmir";
                                        @endphp
                                        {!! DNS2D::getBarcodeSVG($test_report_data, 'QRCODE',3,3) !!}
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <hr>
                        <table class="mt-4">
                            <tr>
                                <td style="width: 80%" >
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
                                <td style="width: 20%; text-align: center;">
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
                                <span class="underline">One Paper Test (MCQs) for the Paid Internship Program</span>
                            </span>
                        </div>
                        <div class="p-2 mx-auto">
                            <div class="mb-2">
{{--                                <h1 class="text-sm font-semibold text-gray-900">Examination Entry Instructions</h1>--}}
                                <p class="text-sm text-black"  style="font-size: 12px!important;">
                                    <span>Dear Candidate,</span><br>
                                    Reference your application for Paid Internship Program 2024 with BAJK, you are required to appear for test as per schedule given below
                                    <br>
                                    <strong>Test Date & Day: {{ \Carbon\Carbon::parse($candidates->test_date)->format('d F, Y, l') }}</strong><br>
                                    <strong>Test Start Time: {{ $candidates->reporting_time }} (PST)</strong><br>
                                    <strong>Duration: 90 Minutes</strong><br>
                                    <strong>Test Centre: {{ $candidates->test_center }}</strong><br>
                                </p>
                            </div>
                            <div class="mb-2 text-black">
                                <h1 class="text-sm font-extrabold underline text-black">General Instructions for Test:</h1>
                                <p class="text-sm text-black">
                                    You must report at the Test Centre <strong>45 minutes</strong> before (above given time). You are required to bring the following items with you:
                                </p>

                                <ul class="list-disc pl-5  mb-2" style="font-size: 10px;">
                                    <li>This Call Letter. Original CNIC or B-Form. </li>
                                    <li>Incase loss of CNIC please bring original NADRA token with any other original document containing your photograph. Otherwise, you will not be allowed to appear in the Test.</li>
                                    <li>Please bring your original degrees / testimonials along-with one set of attested photocopies of all documents and a passport size photograph.</li>
                                </ul>
                                <p class="text-sm text-black">You are required NOT to bring the following items with you. You will not be allowed to take the following items in Test Centre</p>
                                <ul class="list-disc pl-5  mb-2" style="font-size: 10px;">
                                    <li>Mobile Phone.</li>
                                    <li>Any type of Calculator </li>
                                    <li>I Pod, Camera, Memory Devices</li>
                                    <li>Any other Electronic / Communication Devices</li>
                                    <li>Clipboard, Ballpoint or pen</li>
                                </ul>

                                <p class="text-sm text-black text-extrabold">
                                    It may be noted that:
                                </p>


                                <ul class="list-disc pl-5  mb-2" style="font-size: 10px;">
                                    <li>No candidate will be allowed to enter in the examination hall after 30 minutes from the start of the test.</li>
                                    <li>Mobile phone collection facility will not be provided at Test Centre.</li>
                                    <li>Candidates may be searched for mobile phones / electronic devices, and if found their paper will be cancelled. </li>
                                    <li>Exchange / borrowing of any item(s) during the test is strictly prohibited. </li>
                                </ul>

                                <p class="text-sm text-black text-center">
                                    <strong>Please note that this is a computer-generated document and does not require any signature.</strong>
                                </p>

                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="text-left text-sm">
                            <span class="capitalize">
                                To:
                                <span class="font-extrabold">
                                    {{ $candidates->gender == 'Male' ? 'Mr.' : 'Ms.' }} {{ $candidates->name }},<br>
                                    Father/Husband Name: {{ $candidates->fathers_name }} <br>
                                    {{ $candidates->mailing_address }},<br>
                                    Mobile:
                                    {{ $candidates->contact_number }}, Telephone: {{ $candidates->phone_no }}
                                </span>
                            </span>

                            <br>
                            <br>
                            <span class="uppercase">
                                From:
                                <span class="uppercase font-extrabold">
                                    The Bank of Azad Jammu & Kashmir<br>
                                    Human Resource Management Division, Gojra, Head Office, Muzaffarabad<br>
                                </span>
                            </span>
                        </div>
                        <div class="break-before-page mb-2">
                            <!-- Content -->
                        </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
