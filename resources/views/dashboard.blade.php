<x-app-layout>
    @push('custom_headers')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @endpush
    <x-slot name="header">
        <x-page-header title="Dashboard" :showRefresh="true" backRoute="dashboard"/>
    </x-slot>

        @role('Super-Admin|admin')
            <div class="max-w-7xl mx-auto mt-4 px-4 sm:px-6 lg:px-8 print:hidden">
                <form method="GET" action="{{ route('dashboard') }}" class="bg-white rounded-xl shadow-lg px-4 py-3 flex flex-wrap items-center gap-x-6 gap-y-2">
                    <div class="flex items-center gap-2 text-sm">
                        <label for="batch_no" class="font-semibold text-gray-700">Batch</label>
                        <select name="batch_no" id="batch_no" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm py-1.5 pr-8">
                            <option value="all" @selected($batch_no === 'all')>All batches</option>
                            @foreach($batches as $b)
                                <option value="{{ $b }}" @selected($batch_no === $b)>{{ $b }}{{ $b === $registration['batch'] ? ' (registration)' : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center gap-2 text-sm">
                        <label for="show" class="font-semibold text-gray-700">Latest applications</label>
                        <select name="show" id="show" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm text-sm py-1.5 pr-8">
                            @foreach([10, 50, 100] as $n)
                                <option value="{{ $n }}" @selected($show === $n)>Show {{ $n }}</option>
                            @endforeach
                        </select>
                    </div>
                    <span class="ml-auto text-xs text-gray-500">Showing <b>{{ $batch_no === 'all' ? 'all batches' : $batch_no }}</b></span>
                </form>
            </div>
        @endrole

        <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            @role('Intern')
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                @if($user->profile_status != 1)
                    <x-internee-tabs :user="$user"/>

                    <div class="px-6 mb-4 lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                        <!-- resources/views/users/create.blade.php -->
                        <x-status-message class="ml-4 mt-4"/>
                        <x-validation-errors class="ml-4 mt-4"/>
                        <form method="POST" action="{{ route('user.update', $user->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
                                <div>
                                    <x-label for="name" value="Name" :required="true"/>
                                    <x-input id="name" name="name" class="block mt-1 w-full" type="text" required value="{{ $user->name }}"/>
                                </div>
                                <div>
                                    <x-label for="fathers_name" value="Father's Name" :required="true"/>
                                    <x-input id="fathers_name" name="fathers_name" required class="block mt-1 w-full" type="text" value="{{ $user->fathers_name }}"/>
                                </div>
                                <div>
                                    <x-label for="date_of_birth" value="Date of Birth" :required="true"/>
                                    <x-input id="date_of_birth" required max="2006-03-01" min="1989-09-15" name="date_of_birth" class="block mt-1 w-full" type="date" value="{{ $user->date_of_birth }}"/>
                                </div>

                                <div>
                                    <x-label for="nationality" value="Nationality" required :required="true"/>
                                    <select id="nationality" required name="nationality" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">-- select one --</option>
                                        @foreach($nationals as $key)
                                            <option value="{{ $key }}" @if($user->nationality == $key) selected @else
                                                {{ $key == "Pakistani"?"selected":"" }}
                                                @endif>{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <x-label for="gender" value="Gender" :required="true"/>
                                    <select id="gender" name="gender" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a gender</option>
                                        <option value="Male" @if($user->gender == "Male") selected @endif>Male</option>
                                        <option value="Female" @if($user->gender == "Female") selected @endif>Female</option>
                                    </select>
                                </div>
                                <div>
                                    <x-label for="cnic_number" value="CNIC Number" :required="true"/>
                                    <x-input id="cnic_number" required name="cnic_number" class="block mt-1 w-full" type="text" value="{{ $user->cnic_number }}"/>
                                </div>
                                <div>
                                    <x-label for="marital_status" value="Marital Status" :required="true"/>
                                    <select id="marital_status" required name="marital_status" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a marital status</option>
                                        <option value="Married" @if($user->marital_status == "Married") selected @endif>Married</option>
                                        <option value="Single" @if($user->marital_status == "Single") selected @endif>Single</option>
                                    </select>
                                </div>

                                <div>
                                    <x-label for="district" value="District" :required="true"/>
                                    <select id="district" required name="district" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a district</option>
                                        <option value="Muzaffarabad" @if($user->district == "Muzaffarabad") selected @endif>Muzaffarabad</option>
                                        <option value="Jhelum Valley" @if($user->district == "Jhelum Valley") selected @endif>Jhelum Valley</option>
                                        <option value="Neelum" @if($user->district == "Neelum") selected @endif>Neelum</option>
                                        <option value="Mirpur" @if($user->district == "Mirpur") selected @endif>Mirpur</option>
                                        <option value="Bhimber" @if($user->district == "Bhimber") selected @endif>Bhimber</option>
                                        <option value="Kotli" @if($user->district == "Kotli") selected @endif>Kotli</option>
                                        <option value="Poonch" @if($user->district == "Poonch") selected @endif>Poonch</option>
                                        <option value="Bagh" @if($user->district == "Bagh") selected @endif>Bagh</option>
                                        <option value="Haveli" @if($user->district == "Haveli") selected @endif>Haveli</option>
                                        <option value="Sudhanoti" @if($user->district == "Sudhanoti") selected @endif>Sudhanoti</option>
                                        <option value="Refugee" @if($user->district == "Refugee") selected @endif>Refugee</option>
                                    </select>
                                </div>

                                <div>
                                    <x-label for="district_of_domicile" value="District of Domicile" :required="true"/>
                                    <select id="district_of_domicile" required name="district_of_domicile" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a district of domicile</option>
                                        <option value="Muzaffarabad" @if($user->district == "Muzaffarabad") selected @endif>Muzaffarabad</option>
                                        <option value="Jhelum Valley" @if($user->district == "Jhelum Valley") selected @endif>Jhelum Valley</option>
                                        <option value="Neelum" @if($user->district == "Neelum") selected @endif>Neelum</option>
                                        <option value="Mirpur" @if($user->district == "Mirpur") selected @endif>Mirpur</option>
                                        <option value="Bhimber" @if($user->district == "Bhimber") selected @endif>Bhimber</option>
                                        <option value="Kotli" @if($user->district == "Kotli") selected @endif>Kotli</option>
                                        <option value="Poonch" @if($user->district == "Poonch") selected @endif>Poonch</option>
                                        <option value="Bagh" @if($user->district == "Bagh") selected @endif>Bagh</option>
                                        <option value="Haveli" @if($user->district == "Haveli") selected @endif>Haveli</option>
                                        <option value="Sudhanoti" @if($user->district == "Sudhanoti") selected @endif>Sudhanoti</option>
                                        <option value="Refugee" @if($user->district == "Refugee") selected @endif>Refugee</option>
                                    </select>
                                </div>


                                <div>
                                    <x-label for="contact_number" value="Contact Number" :required="true"/>
                                    <x-input id="contact_number" required maxlength="12" minlength="12" name="contact_number" class="block mt-1 w-full" type="text" pattern="\d{4}-\d{7}" title="Contact number must be in the format 0000-0000000" value="{{ $user->contact_number }}"/>
                                </div>


                                <div>
                                    <x-label for="phone_no" value="Phone Number" :required="false"/>
                                    <x-input id="phone_no" required name="phone_no" class="block mt-1 w-full" type="text" value="{{ $user->phone_no }}"/>
                                </div>
                                <div>
                                    <x-label for="religion" value="Religion" :required="true"/>
                                    <select name="religion" required id="religion" required class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                                        <option value="">Select a religion</option>
                                        <option value="islam" @if($user->religion == "islam") selected @endif>Islam</option>
                                        <option value="christianity" @if($user->religion == "christianity") selected @endif>Christianity</option>
                                        <option value="hinduism" @if($user->religion == "hinduism") selected @endif>Hinduism</option>
                                        <option value="buddhism" @if($user->religion == "buddhism") selected @endif>Buddhism</option>
                                        <option value="judaism" @if($user->religion == "judaism") selected @endif>Judaism</option>
                                    </select>
                                </div>
                                <div>
                                    <x-label for="mailing_address" required value="Mailing Address" :required="true"/>
                                    <textarea id="mailing_address" name="mailing_address" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">{{ $user->mailing_address }}</textarea>
                                </div>


                                <div>
                                    <x-label for="profile_pic_1" value="Your Photo" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="profilePicture" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->profile_photo_path) }}">
                                    @else
                                        <img id="profilePicture" style="border: 1px solid #747474;" height="150" width="150" src="/images/profile_avatar.png">
                                    @endif
                                    <x-input id="profile_pic_1" required name="profile_pic_1" class="block mt-1 w-full" type="file"/>
                                </div>

                                <div>
                                    <x-label for="cnic_front" value="CNIC Front" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->cnic_front_path) }}">
                                    @else
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="/images/front.png">
                                    @endif
                                    <x-input id="cnic_front" required name="cnic_front" class="block mt-1 w-full" type="file"/>
                                </div>


                                <div>
                                    <x-label for="cnic_back" value="CNIC Back" :required="true"/>
                                    @if(!empty($user->profile_photo_path))
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="{{ Storage::url($user->cnic_back_path) }}">
                                    @else
                                        <img id="cnic_back_pic" style="border: 1px solid #747474;" height="150" width="150" src="/images/back.png">
                                    @endif
                                    <x-input id="cnic_back" required name="cnic_back" class="block mt-1 w-full" type="file"/>
                                </div>


                            </div>
                            {{--                            onclick="return confirm('Are you sure you want to update the basic information of Intern?')"--}}
                            <div class="flex items-center justify-end mt-4">
                                @if(empty($user->cnic_number))
                                    <x-button class="ml-4" id="submit-btn"> {{ __('Save & Next') }} </x-button>
                                @else
                                    <x-button class="ml-4" id="submit-btn"> {{ __('Update & Next') }} </x-button>
                                @endif

                                @if(!empty($user->cnic_number))
                                    <a href="{{ route('education.edit', $user->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-green-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4" id="submit-btn"> {{ __('Next') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
            </div>
            @else
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="px-6 mb-4 pt-4 text-center font-bold lg:px-8 bg-white dark:bg-gray-800 dark:bg-gradient-to-bl dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
                        <x-status-message class="ml-4 mt-4"/>
                        <x-validation-errors class="ml-4 mt-4"/>
                        You have successfully submitted your application to HRMD of The Bank of Azad Jammu & Kashmir. <br>
                        Your Application No is: {{ $user->id }}<br>
                        
            
                        
                        {{--                        Status: @if(!empty($user->latestStatus)) <span class="text-red-600">{{ $user->latestStatus->status }}</span> @endif--}}


                        <br>
                        @php
                            $examStart = $user->start_test_time ? Carbon\Carbon::parse($user->start_test_time) : null;
                            $examEnd = $user->end_test_time ? Carbon\Carbon::parse($user->end_test_time) : null;
                            $examOpen = $user->start_test == 1 && ! $user->exam_taken && $examStart && $examEnd && now()->between($examStart, $examEnd);
                            $examState = $user->exam_taken ? 'Exam completed' : (! $user->start_test ? 'Not scheduled yet' : ($examOpen ? 'Open now' : ($examStart && now()->lt($examStart) ? 'Starts '.$examStart->format('d-M-Y H:i') : 'Exam window closed')));
                            $stBadge = $user->status === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($user->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                        @endphp
                        <div class="mx-auto max-w-3xl mt-4 mb-4 text-left rounded-xl border border-gray-200 bg-gray-50 p-5 font-normal">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div><div class="text-xs text-gray-500">Application No</div><div class="font-bold text-gray-900">{{ $user->id }}</div></div>
                                <div><div class="text-xs text-gray-500">Batch</div><div class="font-bold text-gray-900">{{ $user->batch_no }}</div></div>
                                <div><div class="text-xs text-gray-500">Status</div><span class="px-2 py-0.5 rounded text-xs font-semibold {{ $stBadge }}">{{ $user->status }}</span></div>
                                <div><div class="text-xs text-gray-500">Exam</div><div class="font-bold {{ $examOpen ? 'text-green-700' : 'text-gray-900' }}">{{ $examState }}</div></div>
                            </div>
                            @if($examStart && $examEnd && $user->start_test)
                                <div class="mt-3 text-xs text-gray-600">Test window: {{ $examStart->format('d-M-Y H:i') }} &rarr; {{ $examEnd->format('d-M-Y H:i') }}</div>
                            @endif
                            <div class="mt-4 flex flex-wrap items-center gap-3">
                                @if($examOpen)
                                    <a href="{{ route('start_session') }}" class="inline-flex items-center px-5 py-2.5 bg-green-700 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">Start Your Test</a>
                                @endif
                                @if($user->status == 'Shortlisted' && ! empty($user->test_center))
                                    <a href="{{ route('report.result') }}" class="text-red-600 font-extrabold hover:underline">Result</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @endrole

                @role('Super-Admin|admin')
                @php
                    $link = fn (array $extra = []) => route('candidate.index', ['filter' => array_filter(array_merge(['batch_no' => $batch_no === 'all' ? null : $batch_no], $extra), fn ($v) => $v !== null)]);
                    $cards = [
                        ['Candidates', $stats['total'], $link(), 'bg-blue-950', 'All registered in this view'],
                        ['Profile submitted', $stats['submitted'], $link(['profile_status' => 1]), 'bg-green-600', 'Applications completed'],
                        ['In-process', $stats['in_process'], $link(['profile_status' => 0]), 'bg-red-500', 'Profile not finished'],
                        ['Shortlisted', $stats['shortlisted'], $link(['status' => 'Shortlisted']), 'bg-emerald-600', $stats['pending'].' pending · '.$stats['rejected'].' rejected'],
                        ['Exam allowed', $stats['exam_allowed'], $link(['exam_state' => 'allowed']), 'bg-amber-500', 'Allowed, not finished'],
                        ['Exam finished', $stats['exam_finished'], $link(['exam_state' => 'finished']), 'bg-indigo-600', 'Papers completed'],
                    ];
                    $statusBadge = fn ($v) => $v === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($v === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                @endphp

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
                    @foreach($cards as [$label, $value, $url, $color, $hint])
                        <a href="{{ $url }}" class="group bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl hover:-translate-y-0.5 transition">
                            <div class="h-1.5 {{ $color }}"></div>
                            <div class="p-4">
                                <div class="text-3xl font-extrabold text-gray-900">{{ number_format($value) }}</div>
                                <div class="mt-1 text-sm font-semibold text-gray-700">{{ $label }}</div>
                                <div class="mt-0.5 text-[11px] text-gray-400 truncate">{{ $hint }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold text-gray-700">Registration</div>
                            <span class="px-2 py-0.5 rounded text-xs font-semibold {{ $registration['open'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $registration['open'] ? 'Open' : 'Closed' }}</span>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">New registrations go to <b>{{ $registration['batch'] }}</b></div>
                        <div class="text-xs text-gray-500">{{ $registration['open'] ? 'Closes' : 'Closed' }} {{ $registration['deadline']->format('d-M-Y H:i') }}</div>
                        <a href="{{ route('settings.batches.index') }}" class="mt-3 inline-block text-xs text-indigo-600 hover:underline">Change batch or date &rarr;</a>
                    </div>
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-4">
                        <div class="text-sm font-semibold text-gray-700 mb-3">Quick actions</div>
                        <div class="flex flex-wrap gap-2">
                            @php $qa = 'inline-flex items-center px-4 py-2 bg-blue-950 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-800 transition'; @endphp
                            <a href="{{ route('settings.candidates.create', $batch_no === 'all' ? [] : ['batch_no' => $batch_no]) }}" class="{{ $qa }}">Add Candidates</a>
                            <a href="{{ route('settings.batch-exam.index', ['filter' => array_filter(['batch_no' => $batch_no === 'all' ? null : $batch_no])]) }}" class="{{ $qa }}">Batch Exam Setup</a>
                            <a href="{{ $link() }}" class="{{ $qa }}">Candidates</a>
                            <a href="{{ route('settings.questions.index') }}" class="{{ $qa }}">Questions</a>
                            <a href="{{ route('settings.index') }}" class="{{ $qa }}">Settings</a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
                    <div class="bg-white rounded-xl shadow-lg p-4"><div id="chart"></div></div>
                    <div class="bg-white rounded-xl shadow-lg p-4"><div id="chart_two"></div></div>
                    <div class="bg-white rounded-xl shadow-lg p-4"><div id="chart_subjects"></div></div>
                    <div class="bg-white rounded-xl shadow-lg p-4"><div id="service_length_chart"></div></div>
                </div>

                <div class="mt-4 bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-4 py-3 flex items-center justify-between border-b">
                        <div class="text-sm font-semibold text-gray-700">Latest applications <span class="text-gray-400 font-normal">(last {{ $show }})</span></div>
                        <a href="{{ $link() }}" class="text-xs text-indigo-600 hover:underline">View all &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-max w-full table-auto text-sm">
                            <thead>
                            <tr class="bg-green-800 text-white uppercase text-xs">
                                <th class="py-2 px-3 text-left">ID</th>
                                <th class="py-2 px-2 text-left">Name</th>
                                <th class="py-2 px-2 text-left">District</th>
                                <th class="py-2 px-2 text-left">Batch</th>
                                <th class="py-2 px-2 text-left">Applied</th>
                                <th class="py-2 px-2 text-center">Profile</th>
                                <th class="py-2 px-2 text-center">Status</th>
                                <th class="py-2 px-2 text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-black">
                            @forelse($recent as $r)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-1.5 px-3">{{ $r->id }}</td>
                                    <td class="py-1.5 px-2">{{ ucwords(strtolower($r->name)) }}</td>
                                    <td class="py-1.5 px-2">{{ $r->district_of_domicile ?: $r->district }}</td>
                                    <td class="py-1.5 px-2">{{ $r->batch_no }}</td>
                                    <td class="py-1.5 px-2 text-xs whitespace-nowrap">{{ $r->created_at?->format('d-M-Y H:i') }}</td>
                                    <td class="py-1.5 px-2 text-center"><span class="px-2 py-0.5 rounded text-xs font-semibold {{ $r->profile_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $r->profile_status == 1 ? 'Submitted' : 'In-Complete' }}</span></td>
                                    <td class="py-1.5 px-2 text-center"><span class="px-2 py-0.5 rounded text-xs font-semibold {{ $statusBadge($r->status) }}">{{ $r->status }}</span></td>
                                    <td class="py-1.5 px-2 text-center"><a href="{{ route('candidate.print', $r->id) }}" class="text-blue-600 hover:underline">Open</a></td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="py-6 text-center text-gray-500">No candidates yet.</td></tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endrole


        </div>
    </div>


    @push('modals')
        <script>
            // Add a script to format the CNIC input as 00000-0000000-0
            document.getElementById('cnic_number')?.addEventListener('input', function (e) {
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


            document.getElementById('cnic_front')?.addEventListener('change', function() {
                const file = this.files[0]; // Get the first file in the input
                if (file) { // Check if any file is selected
                    const fileSize = file.size / 1024; // Get file size in KB
                    if (fileSize > 512) { // Check if the file size is greater than 512 KB
                        alert('The file size must be less than 512 KB');
                        this.value = ''; // Clear the selected file
                    }
                }
            });


            document.getElementById('cnic_back')?.addEventListener('change', function() {
                const file = this.files[0]; // Get the first file in the input
                if (file) { // Check if any file is selected
                    const fileSize = file.size / 1024; // Get file size in KB
                    if (fileSize > 512) { // Check if the file size is greater than 512 KB
                        alert('The file size must be less than 512 KB');
                        this.value = ''; // Clear the selected file
                    }
                }
            });


            document.getElementById('profile_pic_1')?.addEventListener('change', function() {
                const file = this.files[0]; // Get the first file in the input
                if (file) { // Check if any file is selected
                    const fileSize = file.size / 1024; // Get file size in KB
                    if (fileSize > 512) { // Check if the file size is greater than 512 KB
                        alert('The file size must be less than 512 KB');
                        this.value = ''; // Clear the selected file
                    }
                }
            });

        </script>
        @role('Super-Admin|admin')
        <script>
            const title = (t) => ({ text: t, align: 'center', style: { fontSize: '16px', fontWeight: 'bold', color: '#263238' } });
            const render = (el, opts) => { const node = document.querySelector(el); if (node && window.ApexCharts) new ApexCharts(node, opts).render(); };

            render('#chart', {
                chart: { type: 'pie', width: '100%', height: 360 },
                series: @json(array_values($district_wise)),
                labels: @json(array_keys($district_wise)),
                title: title('AJK District Wise'),
                legend: { position: 'right' },
                responsive: [{ breakpoint: 640, options: { legend: { position: 'bottom' } } }]
            });

            render('#chart_two', {
                chart: { type: 'donut', width: '100%', height: 360 },
                series: @json(array_values($gender_wise)),
                labels: @json(array_keys($gender_wise)),
                colors: ['#1d4ed8', '#db2777'],
                title: title('Gender Wise'),
                legend: { position: 'bottom' }
            });

            render('#chart_subjects', {
                chart: { type: 'bar', height: 360, toolbar: { show: false } },
                series: [{ name: 'Candidates', data: @json(array_values($degreeCountsFormatted)) }],
                xaxis: { categories: @json(array_keys($degreeCountsFormatted)) },
                plotOptions: { bar: { horizontal: true, borderRadius: 4, distributed: true } },
                legend: { show: false },
                dataLabels: { enabled: true },
                title: title('Subject Wise')
            });

            render('#service_length_chart', {
                chart: { type: 'bar', height: 360, toolbar: { show: false } },
                series: [{ name: 'Candidates', data: @json(array_values($finalAgeWiseData)) }],
                xaxis: { categories: @json(array_keys($finalAgeWiseData)) },
                plotOptions: { bar: { columnWidth: '45%', borderRadius: 4, distributed: true } },
                legend: { show: false },
                dataLabels: { enabled: true },
                title: title('Age at Application')
            });
        </script>
        @endrole
    @endpush
</x-app-layout>
