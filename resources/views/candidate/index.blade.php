<x-app-layout>
    @push('custom_headers')
        <link rel="stylesheet" href="{{ url('jsandcss/daterangepicker.min.css') }}">
        <script src="{{ url('jsandcss/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ url('jsandcss/moment.min.js') }}"></script>
        <script src="{{ url('jsandcss/knockout-3.5.1.js') }}" defer></script>
        <script src="{{ url('jsandcss/daterangepicker.min.js') }}" defer></script>
        <style>
            table { font-size: 9px!important;}
        </style>
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
    <div class="max-w-8xl mx-auto mt-12 px-4 sm:px-2 lg:px-8 print:hidden " style="display: none" id="filters">
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
                        <x-label for="batch_no" value="{{ __('Batch No') }}" />
                        <select name="filter[batch_no]" id="batch_no" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                            <option value="">Select a Batch No</option>
                            <option value="Batch-01">Batch-01</option>
                            <option value="Batch-02">Batch-02</option>
                        </select>
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
                            <option value="Muzaffarabad" {{ request('filter.district_of_domicile') === 'Muzaffarabad' ? 'selected' : '' }}>Muzaffarabad</option>
                            <option value="Jhelum Valley" {{ request('filter.district_of_domicile') === 'Jhelum Valley' ? 'selected' : '' }}>Jhelum Valley</option>
                            <option value="Neelum" {{ request('filter.district_of_domicile') === 'Neelum' ? 'selected' : '' }}>Neelum</option>
                            <option value="Mirpur" {{ request('filter.district_of_domicile') === 'Mirpur' ? 'selected' : '' }}>Mirpur</option>
                            <option value="Bhimber" {{ request('filter.district_of_domicile') === 'Bhimber' ? 'selected' : '' }}>Bhimber</option>
                            <option value="Kotli" {{ request('filter.district_of_domicile') === 'Kotli' ? 'selected' : '' }}>Kotli</option>
                            <option value="Poonch" {{ request('filter.district_of_domicile') === 'Poonch' ? 'selected' : '' }}>Poonch</option>
                            <option value="Bagh" {{ request('filter.district_of_domicile') === 'Bagh' ? 'selected' : '' }}>Bagh</option>
                            <option value="Haveli" {{ request('filter.district_of_domicile') === 'Haveli' ? 'selected' : '' }}>Haveli</option>
                            <option value="Sudhanoti" {{ request('filter.district_of_domicile') === 'Sudhanoti' ? 'selected' : '' }}>Sudhanoti</option>
                            <option value="Refugee" {{ request('filter.district_of_domicile') === 'Refugee' ? 'selected' : '' }}>Refugee</option>
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
                            <option value="0" {{ request('filter.profile_status') === '0' ? 'selected' : '' }}>In-Process</option>
                            <option value="1" {{ request('filter.profile_status') === '1' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>


                    <div>
                        <x-label for="status" value="Shortlisted/Rejected/Pending" :required="false"/>
                        <select name="filter[latestStatus.status]" id="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
{{--                        <select name="filter[status]" id="status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">--}}
                            <option value="">Select a status</option>
                            <option value="Pending" {{ request('filter.latestStatus.status') === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Shortlisted" {{ request('filter.latestStatus.status') === 'Shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                            <option value="Rejected" {{ request('filter.latestStatus.status') === 'Rejected' ? 'selected' : '' }}>Rejected</option>
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
        <div class="max-w-8xl mx-auto sm:px-2 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg">
                <div class="rounded-lg bg-white overflow-x-auto dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">

                    <x-status-message class="mb-4"/>
                    <div class="relative overflow-x-auto rounded-lg ">
                        <table class="min-w-max w-full table-auto">
                            <thead>
                            <tr class="bg-gray-200 text-black uppercase text-sm">
                                <th class="py-2 px-2 text-center">ID</th>
                                <th class="py-2 px-2 text-center">Name & Email</th>
                                <th class="py-2 px-2 text-center">Age / Sex</th>
                                <th class="py-2 px-2 text-center">district</th>
                                <th class="py-2 px-2 text-center">domicile</th>
                                <th class="py-2 px-2 text-center"> Mobile</th>
                                <th class="py-2 px-2 text-center">CNIC</th>
                                <th class="py-2 px-2 text-center">Applied On</th>
                                <th class="py-2 px-2 text-center">Education</th>
                                <th class="py-2 px-2 text-center">Profile</th>
                                <th class="py-2 px-2 text-center"> Status</th>
                                <th class="py-2 px-2 text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-black text-sm leading-normal">
                            @foreach ($candidates as $candidate)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-1 px-2 text-center">
                                        {{ $candidate->id }}
                                    </td>
                                    <td class="py-1 px-2 text-left">
                                        
                                        @if(Auth::user()->email == "hrd@bankajk.com")
                                            <!--<a href="{{ route('candidate-user.password-change',$candidate->id) }}">-->
                                            {{ ucwords(strtolower($candidate->name)) }}
                                             <!--<br>-->
                                            
                                            <!--</a>-->
                                            <!--{{ $candidate->email }}-->
                                        @else
                                            <!--<a href="{{ route('candidate-user.password-change',$candidate->id) }}">-->
                                            {{ ucwords(strtolower($candidate->name)) }}
                                           
                                            <!--</a>-->
                                        @endif
                                       

                                    </td>
                                    <td class="py-1 px-2 text-center">
                                        {{ \Carbon\Carbon::parse($candidate->date_of_birth)->age }}y   @if($candidate->gender == "Male") / M @elseif($candidate->gender == "Female") F @endif
                                    </td>
                                    <td class="py-1 px-2 text-left">
                                        {{ $candidate->district }}
                                    </td>
                                    <td class="py-1 px-2 text-left">
                                        {{ $candidate->district_of_domicile }}
                                    </td>
                                    <td class="py-1 px-2 text-center">
                                        {{ $candidate->contact_number }}
                                    </td>
                                    <td class="py-1 px-2 text-center">
                                        {{ $candidate->cnic_number }}
                                    </td>
                                    <td class="py-1 px-2 text-center">
                                        {{ \Carbon\Carbon::parse($candidate->created_at)->format('d-M-Y H:i:s') }}
                                    </td>
                                    <td class="py-1 px-2 text-center">
                                        @php
                                            $csDegree = $candidate->education_degrees->whereIn('major_subject', ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT'])->first();
                                        @endphp
                                        @if($csDegree)
                                            {{ $csDegree->major_subject }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="py-1 px-2 text-center @if($candidate->profile_status == 1) font-extrabold text-white bg-green-600 @else font-extrabold text-white bg-red-600 @endif">
                                        @if($candidate->profile_status == 1) Submitted @else In-Complete @endif
                                    </td>
                                    <td class="py-1 px-2 text-center @if($candidate->status == "Shortlisted") bg-green-500 font-extrabold @elseif($candidate->status == "Pending") text-white bg-yellow-500 font-extrabold  @elseif($candidate->status == "Rejected") bg-red-500 font-extrabold @endif">
                                        {{ $candidate->status }}
                                    </td>

                                    <td class="py-1 px-2 text-center">
                                        <a href="{{ route('candidate.print', $candidate->id) }}" class="inline-flex ">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                            </svg>
                                        </a>
                                    </td>




{{--                                    <td class="py-1 px-2 text-center">--}}
{{--                                        <div class="flex item-center justify-center">--}}
{{--                                            <!-- Edit Button -->--}}
{{--                                            <a href="{{ route('certificateCategory.edit', $cat) }}" class="inline-flex items-center px-4 py-2 bg-blue-800 dark:bg-blue-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-blue-800 uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-white focus:bg-blue-700 dark:focus:bg-white active:bg-blue-900 dark:active:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-blue-800 transition ease-in-out duration-150">--}}
{{--                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.207V18.5H3.793l13.439-13.439z"></path></svg>--}}
{{--                                                Edit--}}
{{--                                            </a>--}}

{{--                                            <!-- Delete Button -->--}}
{{--                                            --}}{{--                                    <form action="{{ route('course.destroy', $cat) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');" class="ml-2">--}}
{{--                                            --}}{{--                                        @csrf--}}
{{--                                            --}}{{--                                        @method('DELETE')--}}
{{--                                            --}}{{--                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-800 dark:bg-red-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-red-800 uppercase tracking-widest hover:bg-red-700 dark:hover:bg-white focus:bg-red-700 dark:focus:bg-white active:bg-red-900 dark:active:bg-red-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-red-800 transition ease-in-out duration-150">--}}
{{--                                            --}}{{--                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>--}}
{{--                                            --}}{{--                                            Delete--}}
{{--                                            --}}{{--                                        </button>--}}
{{--                                            --}}{{--                                    </form>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
            {{ $candidates->links() }}
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
