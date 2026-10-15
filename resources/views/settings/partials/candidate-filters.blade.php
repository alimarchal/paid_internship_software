        <p class="text-[11px] font-semibold uppercase tracking-widest text-gray-500 mb-2">Candidate</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <x-label for="f_search" value="Quick search (name / email / CNIC / ID)"/>
                <x-input id="f_search" name="filter[search]" type="text" class="mt-1 block w-full" value="{{ $f['search'] ?? '' }}" placeholder="Search"/>
            </div>
            <div>
                <x-label for="f_id" value="Application No"/>
                <x-input id="f_id" name="filter[id]" type="text" class="mt-1 block w-full" value="{{ $f['id'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_name" value="Name"/>
                <x-input id="f_name" name="filter[name]" type="text" class="mt-1 block w-full" value="{{ $f['name'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_fathers_name" value="Father Name"/>
                <x-input id="f_fathers_name" name="filter[fathers_name]" type="text" class="mt-1 block w-full" value="{{ $f['fathers_name'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_email" value="Email"/>
                <x-input id="f_email" name="filter[email]" type="text" class="mt-1 block w-full" value="{{ $f['email'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_cnic" value="CNIC"/>
                <x-input id="f_cnic" name="filter[cnic_number]" type="text" class="mt-1 block w-full" value="{{ $f['cnic_number'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_contact" value="Mobile"/>
                <x-input id="f_contact" name="filter[contact_number]" type="text" class="mt-1 block w-full" value="{{ $f['contact_number'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_gender" value="Gender"/>
                <select id="f_gender" name="filter[gender]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach(['Male', 'Female'] as $v) <option value="{{ $v }}" {{ $opt('gender', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_religion" value="Religion"/>
                <select id="f_religion" name="filter[religion]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach(['islam', 'christianity', 'hinduism', 'buddhism', 'judaism'] as $v) <option value="{{ $v }}" {{ $opt('religion', $v) }}>{{ ucfirst($v) }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_marital" value="Marital Status"/>
                <select id="f_marital" name="filter[marital_status]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach(['Single', 'Married'] as $v) <option value="{{ $v }}" {{ $opt('marital_status', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_district" value="District"/>
                <select id="f_district" name="filter[district]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($districts as $v) <option value="{{ $v }}" {{ $opt('district', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_domicile" value="District of Domicile"/>
                <select id="f_domicile" name="filter[district_of_domicile]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($districts as $v) <option value="{{ $v }}" {{ $opt('district_of_domicile', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_degree" value="Degree Level"/>
                <select id="f_degree" name="filter[degree_level]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($degreeLevels as $v) <option value="{{ $v }}" {{ $opt('degree_level', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_subject" value="Subject"/>
                <select id="f_subject" name="filter[education_degrees_search.major_subject]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($subjects as $v) <option value="{{ $v }}" {{ $opt('education_degrees_search.major_subject', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_from" value="Applied from"/>
                <x-input id="f_from" name="filter[applied_from]" type="date" class="mt-1 block w-full" value="{{ $f['applied_from'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="f_to" value="Applied to"/>
                <x-input id="f_to" name="filter[applied_to]" type="date" class="mt-1 block w-full" value="{{ $f['applied_to'] ?? '' }}"/>
            </div>
        </div>

        <p class="text-[11px] font-semibold uppercase tracking-widest text-gray-500 mt-5 mb-2">Batch &amp; Exam</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <x-label for="f_batch" value="Batch"/>
                <select id="f_batch" name="filter[batch_no]" class="{{ $sel }}">
                    <option value="">All batches</option>
                    @foreach(\App\Models\Batch::names() as $v) <option value="{{ $v }}" {{ $opt('batch_no', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_status" value="Shortlisted / Pending / Rejected"/>
                <select id="f_status" name="filter[status]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach(['Shortlisted', 'Pending', 'Rejected'] as $v) <option value="{{ $v }}" {{ $opt('status', $v) }}>{{ $v }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_profile" value="Profile"/>
                <select id="f_profile" name="filter[profile_status]" class="{{ $sel }}">
                    <option value="">All</option>
                    <option value="1" {{ $opt('profile_status', 1) }}>Submitted</option>
                    <option value="0" {{ $opt('profile_status', 0) }}>In-Complete</option>
                </select>
            </div>
            <div>
                <x-label for="f_exam" value="Exam"/>
                <select id="f_exam" name="filter[exam_state]" class="{{ $sel }}">
                    <option value="">All</option>
                    <option value="not_allowed" {{ $opt('exam_state', 'not_allowed') }}>Not allowed yet</option>
                    <option value="allowed" {{ $opt('exam_state', 'allowed') }}>Allowed, not finished</option>
                    <option value="finished" {{ $opt('exam_state', 'finished') }}>Exam finished</option>
                </select>
            </div>
            <div>
                <x-label for="f_paper" value="Question paper"/>
                <select id="f_paper" name="filter[paper]" class="{{ $sel }}">
                    <option value="">All</option>
                    <option value="allocated" {{ $opt('paper', 'allocated') }}>Paper already created</option>
                    <option value="not_allocated" {{ $opt('paper', 'not_allocated') }}>No paper yet</option>
                    <option value="configured" {{ $opt('paper', 'configured') }}>Custom paper set</option>
                </select>
            </div>
            <div>
                <x-label for="f_center" value="Test Centre"/>
                <select id="f_center" name="filter[test_center]" class="{{ $sel }}">
                    <option value="">All</option>
                    @foreach($testCenters as $v) <option value="{{ $v }}" {{ $opt('test_center', $v) }}>{{ \Illuminate\Support\Str::limit($v, 50) }}</option> @endforeach
                </select>
            </div>
            <div>
                <x-label for="f_test_date" value="Test Date"/>
                <x-input id="f_test_date" name="filter[test_date]" type="date" class="mt-1 block w-full" value="{{ $f['test_date'] ?? '' }}"/>
            </div>
            <div>
                <x-label for="sort" value="Sort by"/>
                <select id="sort" name="sort" class="{{ $sel }}">
                    @foreach(['id' => 'ID (low to high)', '-id' => 'ID (high to low)', 'name' => 'Name (A-Z)', '-name' => 'Name (Z-A)', '-created_at' => 'Applied (newest)', 'created_at' => 'Applied (oldest)', 'district_of_domicile' => 'Domicile (A-Z)', 'batch_no' => 'Batch'] as $v => $l)
                        <option value="{{ $v }}" @selected(request('sort', 'id') === $v)>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
        </div>
