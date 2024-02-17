<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
        <div>
            <x-label for="education_level" value="Education Level" :required="true" />
            <select wire:model="name" id="education_level" name="education_level"  class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Please select a degree</option>
                <option value="Secondary School Certificate / Matriculation / O - level">Secondary School Certificate / Matriculation / O - level</option>
                <option value="Higher Secondary School Certificate / Intermediate/ A - level">Higher Secondary School Certificate / Intermediate/ A - level</option>
                <option value="Bachelor (14 Years) Degree">Bachelor (14 Years) Degree</option>
                <option value="Bachelor (16 Years) Degree">Bachelor (16 Years) Degree</option>
                <option value="Master (16 Years) Degree">Master (16 Years) Degree</option>
                <option value="Master/ MS (18 Years) Degree">Master/ MS (18 Years) Degree</option>
                <option value="M-Phil (18 Years) Degree">M-Phil (18 Years) Degree</option>
                <option value="Doctorate Degree">Doctorate Degree</option>
                <option value="MS leading to PhD">MS leading to PhD</option>
                <option value="Post Doctorate">Post Doctorate</option>
                <option value="PGD">PGD</option>
            </select>
        </div>
        <div>
            <x-label for="board_university_name" value="Board/University Name" :required="true" />
            <x-input id="board_university_name" name="board_university_name" class="block mt-1 w-full" type="text"/>
        </div>


        <div>
            <x-label for="passing_year" value="Passing Year" :required="true" />
            <select id="passing_year" name="passing_year" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Select a passing year</option>
                @for($year = 1990; $year <= 2024; $year++  )
                    <option value="{{ $year }}">{{ $year }}</option>
                @endfor
            </select>
        </div>

        <div>
            <x-label for="division" value="Division" :required="true" />
            <select id="division" name="division" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Select a division</option>
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
                <option value="3rd">3rd</option>
            </select>
        </div>
        <div>
            <x-label for="total_marks_cgpa" value="Total Marks / CGPA" :required="true" />
            <x-input id="total_marks_cgpa" name="total_marks_cgpa" class="block mt-1 w-full" type="number" step="0.01"/>
        </div>

        <div>
            <x-label for="obtain_marks_cgpa" value="Obtain Marks / CGPA" :required="true" />
            <x-input id="obtain_marks_cgpa" name="obtain_marks_cgpa" class="block mt-1 w-full" type="number" step="0.01"/>
        </div>

        <div>
            <x-label for="major_subject" value="Major Subject" :required="true" />
            This Selected {{ $name }}
            <select id="major_subject" name="major_subject" class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm block mt-1 w-full">
                <option value="">Please select a major subject</option>

                <option value="Biology (Matric/SSC 9th-10th Class)">Biology (Matric/SSC 9th-10th Class)</option>
                <option value="Computer (Matric/SSC 9th-10th Class)">Computer (Matric/SSC 9th-10th Class)</option>
                <option value="Others / Arts (Matric/SSC 9th-10th Class)">Others / Arts (Matric/SSC 9th-10th Class)</option>
                <option value="Pre Engineering (Intermediate HSSC 11th-12th Class)">Pre Engineering (Intermediate HSSC 11th-12th Class)</option>
                <option value="Pre Medical (Intermediate HSSC 11th-12th Class)">Pre Medical (Intermediate HSSC 11th-12th Class)</option>
                <option value="ICS (Intermediate HSSC 11th-12th Class)">ICS (Intermediate HSSC 11th-12th Class)</option>
                <option value="ICOM (Intermediate HSSC 11th-12th Class)">ICOM (Intermediate HSSC 11th-12th Class)</option>
                <option value="Others / Arts (Intermediate HSSC 11th-12th Class)">Others / Arts (Intermediate HSSC 11th-12th Class)</option>
                <option value="Economics">Economics</option>
                <option value="Business Administration">Business Administration</option>
                <option value="Accounting">Accounting</option>
                <option value="Finance">Finance</option>
                <option value="Commerce">Commerce</option>
                <option value="CS/MCS/MIT">Computer Science & IT / MCS / IT</option>
            </select>
        </div>
        <div>
            <x-label for="degree_photo" value="Degree Photo Certificate" :required="true" />
            <x-input id="degree_photo" name="degree_photo" class="block mt-1 w-full" type="file"/>
        </div>
    </div>
</div>
