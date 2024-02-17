<x-app-layout>
    @push('custom_headers')
        <link rel="stylesheet" href="{{ url('jsandcss/daterangepicker.min.css') }}">
        <script src="{{ url('jsandcss/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ url('jsandcss/moment.min.js') }}"></script>
        <script src="{{ url('jsandcss/knockout-3.5.1.js') }}" defer></script>
        <script src="{{ url('jsandcss/daterangepicker.min.js') }}" defer></script>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight inline-block">
            {{ __('Internee Candidates List') }}
        </h2>

        <div class="flex justify-center items-center float-right">

            <a href="#"
               class="flex items-center px-4 py-1.5 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2">
                Back
            </a>

            <a href="javascript:;" id="toggle"
               class="flex items-center px-4 py-2 text-gray-600 bg-white border rounded-lg focus:outline-none hover:bg-gray-100 transition-colors duration-200 transform dark:text-gray-200 dark:border-gray-200  dark:hover:bg-gray-700 ml-2"
               title="Members List">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
            </a>

        </div>

    </x-slot>
    <div class="max-w-8xl mx-auto mt-12 px-4 sm:px-6 lg:px-8 print:hidden " style="display: none" id="filters">
        <div class="rounded-xl p-4 bg-white shadow-lg">



            <form method="GET" action="#">
                <div class="mt-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <x-label for="id" value="{{ __('Application No') }}" />
                        <x-input id="id" class="block mt-1 w-full" type="text" name="filter[id]" value="{{ request('filter.id') }}" />
                    </div>

                    <div>
                        <x-label for="name" value="{{ __('Name') }}" />
                        <x-input id="name" class="block mt-1 w-full" type="text" name="filter[name]" value="{{ request('filter.name') }}" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <x-label for="fathers_name" value="{{ __('Father Name') }}" />
                        <x-input id="fathers_name" class="block mt-1 w-full" type="text" name="filter[fathers_name]" value="{{ request('filter.fathers_name') }}" />
                    </div>

                    <div>
                        <x-label for="contact_number" value="{{ __('Contact Number / Mobile') }}" />
                        <x-input id="contact_number" class="block mt-1 w-full" type="text" name="filter[contact_number]" value="{{ request('filter.cnic_number') }}" />
                    </div>
                    <!-- CNIC -->
                    <div>
                        <x-label for="cnic_number" value="{{ __('CNIC') }}" />
                        <x-input id="cnic_number" class="block mt-1 w-full" type="text" name="filter[cnic_number]" value="{{ request('filter.cnic_number') }}" />
                    </div>


                    <!-- Gender -->
                    <div>
                        <x-label for="gender" value="{{ __('Gender') }}" />
                        <select name="filter[gender]" id="gender" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a gender</option>
                            <option value="Male" {{ request('filter.gender') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('filter.gender') === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Religion -->
                    <div>
                        <x-label for="religion" value="{{ __('Religion') }}" />
                        <select name="filter[religion]" id="religion" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a religion</option>
                            <option value="islam" {{ request('filter.religion') === 'islam' ? 'selected' : '' }}>Islam</option>
                            <option value="christianity" {{ request('filter.religion') === 'christianity' ? 'selected' : '' }}>Christianity</option>
                            <option value="hinduism" {{ request('filter.religion') === 'hinduism' ? 'selected' : '' }}>Hinduism</option>
                            <option value="buddhism" {{ request('filter.religion') === 'buddhism' ? 'selected' : '' }}>Buddhism</option>
                            <option value="judaism" {{ request('filter.religion') === 'judaism' ? 'selected' : '' }}>Judaism</option>
                        </select>
                    </div>



                    <div>
                        <x-label for="district" value="District" :required="false"/>
                        <select id="district" name="filter[district]" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a district</option>
                            <option value="Muzaffarabad" {{ request('filter.district') === 'Muzaffarabad' ? 'selected' : '' }}>Muzaffarabad</option>
                            <option value="Jhelum Valley" {{ request('filter.district') === 'Jhelum Valley' ? 'selected' : '' }}>Jhelum Valley</option>
                            <option value="Neelum" {{ request('filter.district') === 'Neelum' ? 'selected' : '' }}>Neelum</option>
                            <option value="Mirpur" {{ request('filter.district') === 'Mirpur' ? 'selected' : '' }}>Mirpur</option>
                            <option value="Bhimber" {{ request('filter.district') === 'Bhimber' ? 'selected' : '' }}>Bhimber</option>
                            <option value="Kotli" {{ request('filter.district') === 'Kotli' ? 'selected' : '' }}>Kotli</option>
                            <option value="Poonch" {{ request('filter.district') === 'Poonch' ? 'selected' : '' }}>Poonch</option>
                            <option value="Bagh" {{ request('filter.district') === 'Bagh' ? 'selected' : '' }}>Bagh</option>
                            <option value="Haveli" {{ request('filter.district') === 'Haveli' ? 'selected' : '' }}>Haveli</option>
                            <option value="Sudhanoti" {{ request('filter.district') === 'Sudhanoti' ? 'selected' : '' }}>Sudhanoti</option>
                            <option value="Refugee" {{ request('filter.district') === 'Refugee' ? 'selected' : '' }}>Refugee</option>
                        </select>
                    </div>

                    <div>
                        <x-label for="district_of_domicile" value="District of Domicile" :required="false"/>
                        <select id="district_of_domicile" name="filter[district_of_domicile]" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a district of domicile</option>
                            <option value="Muzaffarabad" {{ request('filter.district') === 'Muzaffarabad' ? 'selected' : '' }}>Muzaffarabad</option>
                            <option value="Jhelum Valley" {{ request('filter.district') === 'Jhelum Valley' ? 'selected' : '' }}>Jhelum Valley</option>
                            <option value="Neelum" {{ request('filter.district') === 'Neelum' ? 'selected' : '' }}>Neelum</option>
                            <option value="Mirpur" {{ request('filter.district') === 'Mirpur' ? 'selected' : '' }}>Mirpur</option>
                            <option value="Bhimber" {{ request('filter.district') === 'Bhimber' ? 'selected' : '' }}>Bhimber</option>
                            <option value="Kotli" {{ request('filter.district') === 'Kotli' ? 'selected' : '' }}>Kotli</option>
                            <option value="Poonch" {{ request('filter.district') === 'Poonch' ? 'selected' : '' }}>Poonch</option>
                            <option value="Bagh" {{ request('filter.district') === 'Bagh' ? 'selected' : '' }}>Bagh</option>
                            <option value="Haveli" {{ request('filter.district') === 'Haveli' ? 'selected' : '' }}>Haveli</option>
                            <option value="Sudhanoti" {{ request('filter.district') === 'Sudhanoti' ? 'selected' : '' }}>Sudhanoti</option>
                            <option value="Refugee" {{ request('filter.district') === 'Refugee' ? 'selected' : '' }}>Refugee</option>
                        </select>
                    </div>


                    <div>
                        <x-label for="education_degrees_search" value="Subject" />
                        <select id="education_degrees_search" name="filter[education_degrees_search.major_subject]" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Please select a subject</option>
                            <option value="Biology/Physics/Commerce (In Case of Metric/FSC)" {{ request('filter.education_degrees_search.major_subject') === 'Biology/Physics/Commerce (In Case of Metric/FSC)' ? 'Economics' : '' }}>Biology/Physics/Commerce (In Case of Metric/FSC)</option>
                            <option value="Economics" {{ request('filter.education_degrees_search.major_subject') === 'Male' ? 'Economics' : '' }}>Economics</option>
                            <option value="Business Administration" {{ request('filter.education_degrees_search.major_subject') === 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                            <option value="Accounting" {{ request('filter.education_degrees_search.major_subject') === 'Accounting' ? 'selected' : '' }}>Accounting</option>
                            <option value="Finance" {{ request('filter.education_degrees_search.major_subject') === 'Finance' ? 'selected' : '' }}>Finance</option>
                            <option value="Commerce" {{ request('filter.education_degrees_search.major_subject') === 'Commerce' ? 'selected' : '' }}>Commerce</option>
                            <option value="CS/MCS/MIT" {{ request('filter.education_degrees_search.major_subject') === 'CS/MCS/MIT' ? 'selected' : '' }}>Computer Science & IT / MCS / IT</option>
                        </select>
                    </div>

                    <div>
                        <x-label for="profile_status" value="{{ __('Submit Status') }}" />
                        <select name="filter[profile_status]" id="profile_status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a status</option>
                            <option value="0" {{ request('filter.profile_status') === 'Male' ? 'selected' : '' }}>In-Process</option>
                            <option value="1" {{ request('filter.profile_status') === 'Female' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>






                </div>

                <div class="mt-4">
                    <x-button class="bg-indigo-500 text-white">
                        {{ __('Apply Filters') }}
                    </x-button>
                </div>
            </form>

        </div>
    </div>

    <div class="py-6">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden ">
                <div class=" bg-white overflow-x-auto dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    <table class="w-full text-sm border-collapse border border-slate-400 text-left text-black dark:text-gray-400">
                        <thead class="text-black uppercase bg-gray-50 dark:bg-gray-700 ">
                        <tr>

                            <th scope="col" class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
                                ID
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                Name
                            </th>


                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                Father Name
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                Gender
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                Age
                            </th>


                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                district
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                domicile
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center">
                                Mobile
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center print:hidden">
                                CNIC
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center print:hidden">
                                Applied On
                            </th>


                            <th scope="col" class="px-1 py-2 border border-black  text-center print:hidden">
                                Education
                            </th>


                            <th scope="col" class="px-1 py-2 border border-black  text-center print:hidden">
                                Status
                            </th>

                            <th scope="col" class="px-1 py-2 border border-black  text-center print:hidden">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach ($candidates as $candidate)
                            <tr class="bg-white  border-b dark:bg-gray-800 dark:border-black text-center">
                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
                                    {{ $candidate->id }}
                                </td>

                                <td class="border px-2 py-2  border-black font-medium text-black text-left dark:text-white">
                                    {{ ucwords(strtolower($candidate->name)) }}
                                </td>

                                <td class="border px-2 py-2  border-black font-medium text-black text-left dark:text-white">
                                    {{ ucwords(strtolower($candidate->fathers_name)) }}
                                </td>

                                <td class="px-1 py-3 border border-black text-center">
                                    {{ $candidate->gender }}
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
{{--                                    {{ \Carbon\Carbon::parse($candidate->date_of_birth)->format('d-M-Y') }} - --}}
                                    {{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }}y
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
                                    {{ $candidate->district }}
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
                                    {{ $candidate->district_of_domicile }}
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white">
                                    {{ $candidate->contact_number }}
                                </td>

                                <td class="px-1 py-3 border border-black text-center">
                                    {{ $candidate->cnic_number }}
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white print:hidden">
                                    {{ \Carbon\Carbon::parse($candidate->created_at)->format('d-M-Y H:i:s') }}
                                </td>


                                <td class="border px-0.5 py-2 border-black font-medium text-black text-center dark:text-white print:hidden">
                                    @php
                                        $csDegree = $candidate->education_degrees->whereIn('major_subject', ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT'])->first();
                                    @endphp
                                    @if($csDegree)
                                        {{ $csDegree->major_subject }}
                                    @else
                                        N/A
                                    @endif
                                </td>


                                <td class="border px-0.5 py-2 @if($candidate->profile_status == 1) bg-green-500 @else bg-red-500 @endif  border-black font-medium text-black text-center dark:text-white print:hidden">
                                    @if($candidate->profile_status == 1) Submitted @else In-Complete @endif
                                </td>

                                <td class="border px-0.5 py-2  border-black font-medium text-black text-center dark:text-white print:hidden">
                                    <a href="{{ route('candidate.print', $candidate->id) }}" class="inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{ $candidates->links() }}
                </div>

            </div>
        </div>
    </div>
    @push('modals')
        <script>

            const targetDiv = document.getElementById("filters");
            const btn = document.getElementById("toggle");
            btn.onclick = function () {
                if (targetDiv.style.display !== "none") {
                    targetDiv.style.display = "none";
                } else {
                    targetDiv.style.display = "block";
                }
            };

            function redirectToLink(url) {
                window.location.href = url;
            }
        </script>
    @endpush
</x-app-layout>
