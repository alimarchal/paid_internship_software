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
            .official-doc table, .official-doc td, .official-doc th {
                padding-left: 5px;
            }

            .official-doc table {
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
                <span class="hidden md:inline-block ml-1">Print profile &amp; paper</span>
            </button>
        </x-page-header>
    </x-slot>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 print:hidden">
            <x-validation-errors/>
            <x-status-message/>

            @php
                $viewer = Auth::user();
                $viewerIsAdmin = $viewer->hasRole(['admin', 'Super-Admin']);
                $canSeeResult = in_array($viewer->email, ['dh_hrd@bankajk.com', 'hrd@bankajk.com']);
                $badge = fn ($v) => $v === 'Shortlisted' ? 'bg-green-100 text-green-800' : ($v === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800');
                $initials = \Illuminate\Support\Str::of($user->name)->trim()->explode(' ')->filter()->take(2)->map(fn ($w) => \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($w, 0, 1)))->implode('');
                $dob = $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth) : null;
                $paperCount = \App\Models\RandomUserQuestion::where('user_id', $user->id)->count();
                $history = $user->comments()->get();
                $basicOnly = ! $dob && empty($user->cnic_number) && $user->education_degrees->isEmpty();
                $dash = fn ($v) => filled($v) ? e($v) : '<span class="text-gray-400">&mdash;</span>';
                $examState = $user->exam_taken ? 'Exam finished' : ($user->start_test ? 'Exam allowed' : 'Exam not allowed');
                $docs = collect();
                if ($user->cnic_front_path) $docs->push(['CNIC front', $user->cnic_front_path]);
                if ($user->cnic_back_path) $docs->push(['CNIC back', $user->cnic_back_path]);
                foreach ($user->education_degrees->sortBy('passing_year') as $d) { if ($d->degree_photo_path) $docs->push(['Degree: '.$d->education_level, $d->degree_photo_path]); }
                foreach ($user->experience as $x) { if ($x->experience_photo_path) $docs->push(['Experience: '.$x->organization, $x->experience_photo_path]); if ($x->relieving_letter_path ?? null) $docs->push(['Relieving letter: '.$x->organization, $x->relieving_letter_path]); }
            @endphp

            {{-- Profile header --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="h-2 bg-green-800"></div>
                <div class="p-5 flex flex-wrap items-center gap-5">
                    <div class="relative h-24 w-24 rounded-full bg-blue-950 text-white flex items-center justify-center text-3xl font-bold shrink-0 overflow-hidden">
                        {{ $initials }}
                        @if($user->profile_photo_path)
                            <img src="{{ Storage::url($user->profile_photo_path) }}" alt="" class="absolute inset-0 h-full w-full object-cover" onerror="this.remove()">
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold text-gray-900">{{ ucwords(strtolower($user->name)) }}</h1>
                        <div class="text-sm text-gray-500">Application No <b class="text-gray-700">{{ $user->id }}</b> &middot; {{ $user->email }}</div>
                        <div class="mt-2 flex flex-wrap items-center gap-2 text-xs">
                            <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-800 font-semibold">{{ $user->batch_no }}</span>
                            <span class="px-2 py-1 rounded font-semibold {{ $user->profile_status == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $user->profile_status == 1 ? 'Profile submitted' : 'Profile incomplete' }}</span>
                            <span class="px-2 py-1 rounded font-semibold {{ $badge($user->status) }}">{{ $user->status }}</span>
                            <span class="px-2 py-1 rounded bg-gray-200 text-gray-700 font-semibold">{{ $examState }}@if($paperCount) &middot; {{ $paperCount }} q. @endif</span>
                        </div>
                    </div>
                    <div class="ml-auto flex flex-wrap gap-2">
                        <button type="button" onclick="window.print()" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white bg-blue-950 rounded-md hover:bg-green-800">Print profile &amp; paper</button>
                        <a href="{{ request()->fullUrlWithQuery(['mode' => 'docs', 'print' => 1]) }}" target="_blank" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-blue-950 bg-white border border-blue-950 rounded-md hover:bg-gray-100">Print documents (PDF)</a>
                        @if($viewerIsAdmin)
                            <a href="{{ route('candidate-user.password-change', $user->id) }}" class="px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white bg-green-700 rounded-md hover:bg-green-600">Exam setup</a>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 border-t border-gray-100 text-sm">
                    <div class="px-5 py-3"><div class="text-xs text-gray-500">Applied on</div><div class="font-semibold text-gray-800">{{ $user->created_at?->format('d-M-Y') }}</div></div>
                    <div class="px-5 py-3"><div class="text-xs text-gray-500">Age</div><div class="font-semibold text-gray-800">{!! $dob ? $dob->age.' years' : '<span class="text-gray-400">&mdash;</span>' !!}</div></div>
                    <div class="px-5 py-3"><div class="text-xs text-gray-500">District / Domicile</div><div class="font-semibold text-gray-800">{!! $dash($user->district_of_domicile ?: $user->district) !!}</div></div>
                    <div class="px-5 py-3"><div class="text-xs text-gray-500">Mobile</div><div class="font-semibold text-gray-800">{!! $dash($user->contact_number) !!}</div></div>
                </div>
            </div>

            @if($basicOnly)
                <div class="rounded-lg border border-blue-200 bg-blue-50 text-blue-900 px-4 py-3 text-sm">
                    This candidate was added with basic details only (name and email), for example for an assessment test. Personal details, education and documents were not collected.
                </div>
            @endif

            {{-- Decision --}}
            @if($viewerIsAdmin || $history->isNotEmpty())
                <div class="bg-white rounded-xl shadow-lg p-5">
                    <h2 class="font-bold text-gray-800">Decision</h2>
                    @if($viewerIsAdmin)
                        <form action="{{ route('candidate.shortlisted', $user->id) }}" method="POST" class="mt-3 grid grid-cols-1 md:grid-cols-6 gap-3 items-end">
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
                    @endif
                    @if($history->isNotEmpty())
                        <ol class="mt-4 relative border-s border-gray-200 ms-2">
                            @foreach($history as $h)
                                <li class="mb-4 ms-5">
                                    <span class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-white {{ $h->status === 'Shortlisted' ? 'bg-green-500' : ($h->status === 'Rejected' ? 'bg-red-500' : 'bg-yellow-400') }}"></span>
                                    <div class="text-sm">
                                        <span class="px-1.5 py-0.5 rounded text-xs font-semibold {{ $badge($h->status) }}">{{ $h->status }}</span>
                                        <span class="text-gray-700">by {{ \App\Models\User::find($h->user_id_comment_by)?->name ?? 'HRMD' }}</span>
                                        <span class="text-gray-400 text-xs">&middot; {{ $h->created_at->format('d-M-Y H:i') }}</span>
                                    </div>
                                    @if(filled($h->comments))
                                        <div class="text-sm text-gray-600 mt-0.5">{{ trim(strip_tags(html_entity_decode($h->comments))) }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="lg:col-span-2 space-y-4">
                    {{-- Personal --}}
                    <div class="bg-white rounded-xl shadow-lg p-5">
                        <h2 class="font-bold text-gray-800 mb-3">Personal information</h2>
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3 text-sm">
                            @foreach([
                                'Full name' => $user->name, "Father's name" => $user->fathers_name, 'Gender' => $user->gender,
                                'Date of birth' => $dob?->format('d-M-Y'), 'Nationality' => $user->nationality, 'CNIC' => $user->cnic_number,
                                'Religion' => ucfirst((string) $user->religion), 'Marital status' => $user->marital_status, 'District' => $user->district,
                                'Domicile' => $user->district_of_domicile, 'Mobile' => $user->contact_number, 'Phone' => $user->phone_no,
                            ] as $label => $value)
                                <div><dt class="text-xs text-gray-500">{{ $label }}</dt><dd class="font-medium text-gray-900">{!! $dash($value) !!}</dd></div>
                            @endforeach
                            <div class="sm:col-span-2"><dt class="text-xs text-gray-500">Email</dt><dd class="font-medium text-gray-900">{{ $user->email }}</dd></div>
                            <div class="sm:col-span-2"><dt class="text-xs text-gray-500">Mailing address</dt><dd class="font-medium text-gray-900">{!! $dash($user->mailing_address) !!}</dd></div>
                        </dl>
                    </div>
                </div>

                {{-- Right column: exam --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-lg p-5">
                        <h2 class="font-bold text-gray-800 mb-3">Online exam</h2>
                        <dl class="text-sm space-y-2">
                            <div class="flex justify-between"><dt class="text-gray-500">State</dt><dd class="font-semibold text-gray-900">{{ $examState }}</dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Test window</dt><dd class="font-medium text-gray-900 text-right">
                                @if($user->start_test_time) {{ \Carbon\Carbon::parse($user->start_test_time)->format('d-M H:i') }} &rarr; {{ \Carbon\Carbon::parse($user->end_test_time)->format('d-M H:i') }} @else <span class="text-gray-400">&mdash;</span> @endif
                            </dd></div>
                            <div class="flex justify-between"><dt class="text-gray-500">Paper</dt><dd class="font-medium text-gray-900">@if($paperCount){{ $paperCount }} questions @elseif($user->exam_config){{ $user->exam_config['total'] ?? '?' }} questions set @else <span class="text-gray-400">default</span> @endif</dd></div>
                        </dl>

                        @if($canSeeResult && $get_user_questions->isNotEmpty())
                            @php
                                $assigned = $get_user_questions->count();
                                $attempted = (int) $get_user_questions->sum('is_answered');
                                $correct = (int) $get_user_questions->sum('is_correct');
                                $pct = $assigned ? round($correct / $assigned * 100) : 0;
                            @endphp
                            <div class="mt-4 pt-4 border-t">
                                <div class="flex items-end justify-between">
                                    <div class="text-3xl font-extrabold text-gray-900">{{ $correct }}<span class="text-lg text-gray-400">/{{ $assigned }}</span></div>
                                    <div class="text-sm font-semibold {{ $pct >= 60 ? 'text-green-700' : 'text-red-600' }}">{{ $pct }}%</div>
                                </div>
                                <div class="mt-2 h-2 rounded bg-gray-200 overflow-hidden"><div class="h-2 {{ $pct >= 60 ? 'bg-green-600' : 'bg-red-500' }}" style="width: {{ $pct }}%"></div></div>
                                <div class="mt-3 grid grid-cols-3 text-center text-xs text-gray-600">
                                    <div><div class="text-base font-bold text-gray-900">{{ $attempted }}</div>Attempted</div>
                                    <div><div class="text-base font-bold text-green-700">{{ $correct }}</div>Correct</div>
                                    <div><div class="text-base font-bold text-red-600">{{ $attempted - $correct }}</div>Incorrect</div>
                                </div>
                            </div>
                        @elseif($user->exam_taken && $get_user_questions->isEmpty() && $canSeeResult)
                            <div class="mt-4 text-sm text-gray-500">Exam finished, but no paper record exists (absent).</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                    {{-- Education --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-5 pt-4 pb-2 font-bold text-gray-800">Education</div>
                        @if($user->education_degrees->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto text-sm">
                                    <thead><tr class="bg-green-800 text-white uppercase text-xs">
                                        <th class="py-2 px-4 text-left">Degree</th><th class="py-2 px-3 text-left">University</th><th class="py-2 px-3 text-left">Year / Division</th><th class="py-2 px-3 text-left">Marks</th><th class="py-2 px-3 text-left">Major subject</th>
                                    </tr></thead>
                                    <tbody class="text-gray-900">
                                    @foreach($user->education_degrees->sortBy('passing_year') as $deg)
                                        <tr class="border-b border-gray-100">
                                            <td class="py-2 px-4">{{ $deg->education_level }}</td>
                                            <td class="py-2 px-3">{{ $deg->board_university_name }}</td>
                                            <td class="py-2 px-3 whitespace-nowrap">{{ $deg->passing_year }} / {{ $deg->division }}</td>
                                            <td class="py-2 px-3 whitespace-nowrap">{{ $deg->obtain_marks_cgpa }} / {{ $deg->total_marks_cgpa }} <span class="font-semibold">({{ $deg->percentage_marks }}%)</span></td>
                                            <td class="py-2 px-3">{{ $deg->major_subject }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-5 pb-4 text-sm text-gray-400">No education record.</div>
                        @endif
                    </div>

                    {{-- Experience --}}
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-5 pt-4 pb-2 font-bold text-gray-800">Experience</div>
                        @if($user->experience->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto text-sm">
                                    <thead><tr class="bg-green-800 text-white uppercase text-xs">
                                        <th class="py-2 px-4 text-left">Organization</th><th class="py-2 px-3 text-left">Designation</th><th class="py-2 px-3 text-left">Type</th><th class="py-2 px-3 text-left">Salary</th><th class="py-2 px-3 text-left">Period</th><th class="py-2 px-3 text-left">Reason of leaving</th>
                                    </tr></thead>
                                    <tbody class="text-gray-900">
                                    @foreach($user->experience->sortBy('starting_date') as $x)
                                        <tr class="border-b border-gray-100">
                                            <td class="py-2 px-4">{{ $x->organization }}</td>
                                            <td class="py-2 px-3">{{ $x->designation }}</td>
                                            <td class="py-2 px-3">{{ $x->government_private ? 'Government' : 'Private' }}</td>
                                            <td class="py-2 px-3">{{ number_format($x->monthly_salary, 2) }}</td>
                                            <td class="py-2 px-3 whitespace-nowrap">{{ $x->starting_date }} &rarr; {{ $x->ending_date }}</td>
                                            <td class="py-2 px-3">{{ $x->reason_of_leaving }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="px-5 pb-4 text-sm text-gray-400">No experience record.</div>
                        @endif
                    </div>

                    {{-- Documents --}}
                    <div class="bg-white rounded-xl shadow-lg p-5">
                        <h2 class="font-bold text-gray-800 mb-3">Documents</h2>
                        @if($docs->isNotEmpty())
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                                @foreach($docs as [$label, $path])
                                    <a href="{{ Storage::url($path) }}" target="_blank" rel="noopener" class="block group">
                                        <div class="h-32 rounded-lg border border-gray-200 bg-gray-50 overflow-hidden flex items-center justify-center text-xs text-gray-400">
                                            <img src="{{ Storage::url($path) }}" alt="{{ $label }}" class="h-full w-full object-cover group-hover:opacity-90" onerror="this.replaceWith(document.createTextNode('Open file'))">
                                        </div>
                                        <div class="mt-1 text-xs text-gray-600 truncate group-hover:text-indigo-600">{{ $label }}</div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-sm text-gray-400">No documents uploaded.</div>
                        @endif
                    </div>
            </div>

            {{-- Paper review (restricted as before) --}}
            @if($viewer->email == 'dh_hrd@bankajk.com' && $get_user_questions->isNotEmpty())
                <details class="bg-white rounded-xl shadow-lg p-5">
                    <summary class="cursor-pointer font-bold text-gray-800">Paper review ({{ $get_user_questions->count() }} questions)</summary>
                    <ol class="mt-4 space-y-4 list-decimal ms-5 text-sm">
                        @foreach($get_user_questions as $question)
                            @php $q = \App\Models\Question::with('answers')->find($question->question_id); @endphp
                            @continue(! $q)
                            <li>
                                <div class="font-medium text-gray-900">{!! $q->text !!}</div>
                                <ul class="mt-1 space-y-0.5">
                                    @foreach($q->answers as $ans)
                                        <li class="px-2 py-0.5 rounded {{ $ans->is_correct ? 'bg-green-50 text-green-800' : (($question->answer_id == $ans->id) ? 'bg-red-50 text-red-700' : 'text-gray-600') }}">
                                            {{ $ans->text }}
                                            @if($question->answer_id == $ans->id) <b>&#10003; chosen</b> @endif
                                            @if($ans->is_correct) <span class="text-xs">(correct)</span> @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ol>
                </details>
            @endif
        </div>

        @php
            $docsMode = request('mode') === 'docs';
            $showPaper = $viewer->email == 'dh_hrd@bankajk.com' && $get_user_questions->isNotEmpty();
            $dobPrint = $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth) : null;
        @endphp
        <style>
            .rpt { display: none; }
            @media print {
                @page { size: A4; margin: 9mm 10mm; }
                html, body { background: #fff !important; -webkit-print-color-adjust: economy; }
                .rpt { display: block; color: #000; font-family: Arial, Helvetica, sans-serif; font-size: 9.5pt; line-height: 1.3; }
                .rpt * { color: #000 !important; background: transparent !important; box-shadow: none !important; }
                .rpt h2 { font-size: 10pt; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; border-bottom: 1.2px solid #000; margin: 9px 0 4px; padding-bottom: 1px; }
                .rpt table { width: 100%; border-collapse: collapse; }
                .rpt .grid-info td { padding: 2px 5px; border: .6px solid #000; vertical-align: top; }
                .rpt .grid-info td.l { font-weight: 700; width: 17%; background: #eee !important; }
                .rpt .grid-tbl th, .rpt .grid-tbl td { border: .6px solid #000; padding: 2px 5px; font-size: 8.8pt; text-align: left; vertical-align: top; }
                .rpt .grid-tbl th { font-weight: 700; background: #eee !important; }
                .rpt .qcols { column-count: 2; column-gap: 7mm; column-rule: .5px solid #999; }
                .rpt .q { break-inside: avoid; margin-bottom: 5px; font-size: 8.8pt; }
                .rpt .q .qt { font-weight: 700; }
                .rpt .q .qt p { display: inline; margin: 0; }
                .rpt .q ul { list-style: none; margin: 1px 0 0 12px; padding: 0; }
                .rpt .q li { margin: 0; }
                .rpt .ok { font-weight: 700; text-decoration: underline; }
                .rpt .sheet { break-inside: avoid; page-break-inside: avoid; margin: 0 0 6mm; text-align: center; }
                .rpt .sheet img { max-width: 100%; max-height: 118mm; filter: grayscale(1) contrast(1.1); border: .6px solid #000; }
                .rpt .sheet.big img { max-height: 255mm; }
                .rpt .sheet .cap { font-size: 9pt; font-weight: 700; margin-bottom: 2px; text-align: left; }
                .rpt .pagebreak { break-before: page; }
            }
        </style>

        <div class="rpt">
            @if($docsMode)
                {{-- Attachments only: separate print --}}
                <table style="margin-bottom:6px">
                    <tr>
                        <td style="width:70%"><b style="font-size:13pt">Attachments &mdash; {{ $user->name }}</b><br>Application No {{ $user->id }} &middot; CNIC {{ $user->cnic_number }} &middot; {{ $user->batch_no }}</td>
                        <td style="text-align:right">{!! DNS2D::getBarcodeSVG("https://pip.bankajk.com/candidate/show/" . $user->id, 'QRCODE', 2, 2) !!}</td>
                    </tr>
                </table>
                @if(!empty($user->cnic_front_path) || !empty($user->cnic_back_path))
                    <h2>CNIC</h2>
                    <div style="display:flex; gap:6mm">
                        @foreach(['cnic_front_path' => 'Front', 'cnic_back_path' => 'Back'] as $col => $lbl)
                            @if(!empty($user->$col))
                                <div class="sheet" style="flex:1"><div class="cap">{{ $lbl }}</div><img src="{{ Storage::url($user->$col) }}" alt="CNIC {{ $lbl }}"></div>
                            @endif
                        @endforeach
                    </div>
                @endif
                @foreach($user->education_degrees->sortBy('passing_year') as $deg)
                    @if(!empty($deg->degree_photo_path))
                        <div class="sheet big pagebreak"><div class="cap">Education &mdash; {{ $deg->education_level }} ({{ $deg->board_university_name }}, {{ $deg->passing_year }})</div><img src="{{ Storage::url($deg->degree_photo_path) }}" alt="Degree"></div>
                    @endif
                @endforeach
                @foreach($user->experience->sortBy('passing_year') as $exp)
                    @if(!empty($exp->experience_photo_path))
                        <div class="sheet big pagebreak"><div class="cap">Experience &mdash; {{ $exp->organization }} ({{ $exp->designation }})</div><img src="{{ Storage::url($exp->experience_photo_path) }}" alt="Experience"></div>
                    @endif
                @endforeach
            @else
                {{-- Header + photo --}}
                <table>
                    <tr>
                        <td style="width:16%; vertical-align:top">{!! DNS2D::getBarcodeSVG("https://pip.bankajk.com/candidate/show/" . $user->id, 'QRCODE', 2, 2) !!}</td>
                        <td style="text-align:center; vertical-align:middle">
                            <img src="{{ url('images/logo.png') }}" alt="" style="height:52px; margin:0 auto 3px; filter:grayscale(1)">
                            <div style="font-size:14pt; font-weight:700; line-height:1.1">Paid Internship &mdash; Candidate Profile &amp; Paper</div>
                            <div style="font-size:9pt">{{ $user->batch_no }} &middot; Printed {{ now()->format('d-M-Y H:i') }}</div>
                        </td>
                        <td style="width:16%; text-align:right; vertical-align:top">
                            @if($user->profile_photo_path)
                                <img src="{{ Storage::url($user->profile_photo_path) }}" alt="Photo" style="width:30mm; height:38mm; object-fit:cover; border:1px solid #000; filter:grayscale(1); margin-left:auto">
                            @else
                                <div style="width:30mm; height:38mm; border:1px solid #000; margin-left:auto; display:flex; align-items:center; justify-content:center">Photo N/A</div>
                            @endif
                        </td>
                    </tr>
                </table>

                <h2>Personal information</h2>
                <table class="grid-info">
                    <tr><td class="l">Application No</td><td>{{ $user->id }}</td><td class="l">Applied on</td><td>{{ $user->created_at?->format('d-M-Y') }}</td></tr>
                    <tr><td class="l">Name</td><td>{{ $user->name }}</td><td class="l">Father name</td><td>{{ $user->fathers_name }}</td></tr>
                    <tr><td class="l">Gender</td><td>{{ $user->gender }}</td><td class="l">Date of birth</td><td>@if($dobPrint){{ $dobPrint->format('d-M-Y') }} ({{ (int) $dobPrint->diffInYears(now()) }} yrs)@endif</td></tr>
                    <tr><td class="l">CNIC</td><td>{{ $user->cnic_number }}</td><td class="l">Nationality</td><td>{{ $user->nationality }}</td></tr>
                    <tr><td class="l">District</td><td>{{ $user->district }}</td><td class="l">Domicile</td><td>{{ $user->district_of_domicile }}</td></tr>
                    <tr><td class="l">Religion</td><td>{{ $user->religion }}</td><td class="l">Marital status</td><td>{{ $user->marital_status }}</td></tr>
                    <tr><td class="l">Mobile</td><td>{{ $user->contact_number }}</td><td class="l">Phone</td><td>{{ $user->phone_no }}</td></tr>
                    <tr><td class="l">Email</td><td>{{ $user->email }}</td><td class="l">Test centre</td><td>{{ $user->test_center }} @if($user->test_date)({{ \Carbon\Carbon::parse($user->test_date)->format('d-M-Y') }})@endif</td></tr>
                    <tr><td class="l">Mailing address</td><td colspan="3">{{ $user->mailing_address }}</td></tr>
                    <tr><td class="l">Profile</td><td>{{ $user->profile_status == 1 ? 'Submitted' : 'Incomplete' }}</td><td class="l">Status</td><td><b>{{ $user->status }}</b></td></tr>
                </table>

                @if($user->education_degrees->isNotEmpty())
                    <h2>Education</h2>
                    <table class="grid-tbl">
                        <tr><th>#</th><th>Degree</th><th>Board / University</th><th>Year / Div</th><th>Marks</th><th>Major</th></tr>
                        @foreach($user->education_degrees->sortBy('passing_year') as $deg)
                            <tr><td>{{ $loop->iteration }}</td><td>{{ $deg->education_level }}</td><td>{{ $deg->board_university_name }}</td><td>{{ $deg->passing_year }} / {{ $deg->division }}</td><td>{{ $deg->obtain_marks_cgpa }} / {{ $deg->total_marks_cgpa }} = {{ $deg->percentage_marks }}%</td><td>{{ $deg->major_subject }}</td></tr>
                        @endforeach
                    </table>
                @endif

                @if($user->experience->isNotEmpty())
                    <h2>Experience</h2>
                    <table class="grid-tbl">
                        <tr><th>#</th><th>Organization</th><th>Designation</th><th>Type</th><th>Salary</th><th>From / To</th><th>Reason of leaving</th></tr>
                        @foreach($user->experience->sortBy('passing_year') as $exp)
                            <tr><td>{{ $loop->iteration }}</td><td>{{ $exp->organization }}</td><td>{{ $exp->designation }}</td><td>{{ $exp->government_private ? 'Government' : 'Private' }}</td><td>{{ number_format($exp->monthly_salary, 0) }}</td><td>{{ $exp->starting_date }} / {{ $exp->ending_date }}</td><td>{{ $exp->reason_of_leaving }}</td></tr>
                        @endforeach
                    </table>
                @endif

                @if($user->comments->isNotEmpty())
                    <h2>HRMD decisions</h2>
                    <table class="grid-tbl">
                        <tr><th>Date</th><th>Decided by</th><th>Status</th><th>Remarks</th></tr>
                        @foreach($user->comments as $cmt)
                            <tr><td style="white-space:nowrap">{{ \Carbon\Carbon::parse($cmt->created_at)->format('d-M-Y H:i') }}</td><td>{{ \App\Models\User::find($cmt->user_id_comment_by)?->name }}</td><td><b>{{ $cmt->status }}</b></td><td>{{ strip_tags(html_entity_decode((string) $cmt->comments)) }}</td></tr>
                        @endforeach
                    </table>
                @endif

                {{-- Paper --}}
                @if($showPaper)
                    @php
                        $paperQs = \App\Models\Question::with('answers')->whereIn('id', $get_user_questions->pluck('question_id'))->get()->keyBy('id');
                        $assigned = $get_user_questions->count();
                        $attempted = (int) $get_user_questions->sum('is_answered');
                        $correct = (int) $get_user_questions->sum('is_correct');
                    @endphp
                    <h2 class="pagebreak" style="margin-top:0">Question paper &amp; answers &mdash; {{ $user->name }} (#{{ $user->id }})</h2>
                    <div style="font-size:8.5pt; margin-bottom:4px">Marked: <b>[X]</b> = candidate's answer, <span class="ok">underlined</span> = correct answer.</div>
                    <div class="qcols">
                        @foreach($get_user_questions as $uq)
                            @php $q = $paperQs->get($uq->question_id); @endphp
                            @continue(! $q)
                            <div class="q">
                                <div class="qt">{{ $loop->iteration }}. {!! $q->text !!}</div>
                                <ul>
                                    @foreach($q->answers as $ans)
                                        <li class="{{ $ans->is_correct ? 'ok' : '' }}">{{ $uq->answer_id == $ans->id ? '[X]' : '[ ]' }} {{ $ans->text }}@if($ans->is_correct) &#10003;@endif</li>
                                    @endforeach
                                    @if(empty($uq->answer_id))<li><i>Not attempted</i></li>@endif
                                </ul>
                            </div>
                        @endforeach
                    </div>

                    <h2>Result</h2>
                    <table class="grid-info" style="break-inside:avoid">
                        <tr><td class="l">Assigned</td><td>{{ $assigned }}</td><td class="l">Attempted</td><td>{{ $attempted }}</td><td class="l">Not attempted</td><td>{{ $assigned - $attempted }}</td></tr>
                        <tr><td class="l">Correct</td><td>{{ $correct }}</td><td class="l">Incorrect</td><td>{{ $attempted - $correct }}</td><td class="l">Obtained / Total</td><td><b>{{ $correct }} / {{ $assigned }} = {{ $assigned ? round($correct / $assigned * 100, 1) : 0 }}%</b></td></tr>
                    </table>
                @elseif($user->exam_taken == 1 && $get_user_questions->isEmpty())
                    <h2>Result</h2><div>Candidate was absent &mdash; no paper record exists.</div>
                @endif
            @endif
        </div>
    </div>
    @push('modals')
        <script>
            @if(request()->boolean('print')) window.addEventListener('load', () => setTimeout(() => window.print(), 600)); @endif
            document.getElementById('submit-btn')?.addEventListener('click', function(event) {
                const confirmed = confirm('Are you sure you have read all the profile of this candidate?');
                if (!confirmed) {
                    event.preventDefault(); // Prevent form submission
                }
            });

        </script>
    @endpush
</x-app-layout>