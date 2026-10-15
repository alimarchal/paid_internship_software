<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Setting;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        $role_name = Auth::user()->roles->first()->name;

        if ($role_name == "admin" || $role_name == "Super-Admin") {
            // Batch to show: the current registration batch by default, or "all".
            $batches = Batch::orderBy('name')->pluck('name');
            // Default: the registration batch once it has candidates, otherwise every batch.
            $registrationBatch = Batch::registrationName();
            $batch_no = $request->input('batch_no')
                ?: (User::candidates()->where('batch_no', $registrationBatch)->exists() ? $registrationBatch : 'all');
            $allBatches = $batch_no === 'all';

            $candidates = fn () => User::candidates()->when(! $allBatches, fn ($q) => $q->where('batch_no', $batch_no));
            $submitted = fn () => $candidates()->where('profile_status', 1);

            $district = ['Muzaffarabad', 'Jhelum Valley', 'Neelum', 'Mirpur', 'Bhimber', 'Kotli', 'Poonch', 'Bagh', 'Haveli', 'Sudhanoti', 'Refugee'];
            $districtCounts = $submitted()->selectRaw('district, count(*) n')->groupBy('district')->pluck('n', 'district');
            $district_wise = collect($district)->mapWithKeys(fn ($d) => [$d => (int) ($districtCounts[$d] ?? 0)])->all();

            $genderCounts = $submitted()->selectRaw('gender, count(*) n')->groupBy('gender')->pluck('n', 'gender');
            $gender_wise = ['Male' => (int) ($genderCounts['Male'] ?? 0), 'Female' => (int) ($genderCounts['Female'] ?? 0)];

            // Age at the time of applying.
            $ageCounts = $submitted()->whereNotNull('date_of_birth')
                ->selectRaw("CASE
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, created_at) BETWEEN 18 AND 21 THEN '18-21 Years'
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, created_at) BETWEEN 22 AND 24 THEN '22-24 Years'
                    WHEN TIMESTAMPDIFF(YEAR, date_of_birth, created_at) BETWEEN 25 AND 27 THEN '25-27 Years'
                    ELSE 'Other' END AS age_group, count(*) as total")
                ->groupBy('age_group')->pluck('total', 'age_group');
            $finalAgeWiseData = [
                '18-21 Years' => (int) ($ageCounts['18-21 Years'] ?? 0),
                '22-24 Years' => (int) ($ageCounts['22-24 Years'] ?? 0),
                '25-27 Years' => (int) ($ageCounts['25-27 Years'] ?? 0),
                'Other' => (int) ($ageCounts['Other'] ?? 0),
            ];

            $majors = ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT'];
            $degreeCounts = $submitted()
                ->join('education', 'users.id', '=', 'education.user_id')
                ->whereIn('education.major_subject', $majors)
                ->groupBy('education.major_subject')
                ->select('education.major_subject', DB::raw('count(distinct users.id) as total'))
                ->pluck('total', 'education.major_subject');
            $degreeCountsFormatted = collect($majors)->mapWithKeys(fn ($m) => [$m => (int) ($degreeCounts[$m] ?? 0)])->all();

            $statusCounts = $candidates()->selectRaw('status, count(*) n')->groupBy('status')->pluck('n', 'status');
            $stats = [
                'total' => $candidates()->count(),
                'submitted' => $submitted()->count(),
                'in_process' => $candidates()->where('profile_status', 0)->count(),
                'shortlisted' => (int) ($statusCounts['Shortlisted'] ?? 0),
                'pending' => (int) ($statusCounts['Pending'] ?? 0),
                'rejected' => (int) ($statusCounts['Rejected'] ?? 0),
                'exam_allowed' => $candidates()->where('start_test', 1)->where('exam_taken', 0)->count(),
                'exam_finished' => $candidates()->where('exam_taken', 1)->count(),
            ];

            // Latest applications: Show 10 (default) / 50 / 100.
            $show = in_array((int) $request->input('show'), [10, 50, 100], true) ? (int) $request->input('show') : 10;
            $recent = $candidates()->latest('created_at')->limit($show)->get(['id', 'name', 'district', 'district_of_domicile', 'batch_no', 'profile_status', 'status', 'created_at']);

            $registration = [
                'open' => Setting::registrationOpen(),
                'deadline' => Setting::registrationDeadline(),
                'batch' => Batch::registrationName(),
            ];

            return view('dashboard', compact('user', 'batches', 'batch_no', 'district_wise', 'gender_wise', 'finalAgeWiseData', 'degreeCountsFormatted', 'stats', 'recent', 'show', 'registration'));
        } else {
            $nationals = array('Afghan', 'Albanian', 'Algerian', 'American', 'Andorran', 'Angolan', 'Antiguans', 'Argentinean', 'Armenian', 'Australian', 'Austrian', 'Azerbaijani', 'Bahamian', 'Bahraini', 'Bangladeshi', 'Barbadian', 'Barbudans', 'Batswana', 'Belarusian', 'Belgian', 'Belizean', 'Beninese', 'Bhutanese', 'Bolivian', 'Bosnian', 'Brazilian', 'British', 'Bruneian', 'Bulgarian', 'Burkinabe', 'Burmese', 'Burundian', 'Cambodian', 'Cameroonian', 'Canadian', 'Cape Verdean', 'Central African', 'Chadian', 'Chilean', 'Chinese', 'Colombian', 'Comoran', 'Congolese', 'Costa Rican', 'Croatian', 'Cuban', 'Cypriot', 'Czech', 'Danish', 'Djibouti', 'Dominican', 'Dutch', 'East Timorese', 'Ecuadorean', 'Egyptian', 'Emirian', 'Equatorial Guinean', 'Eritrean', 'Estonian', 'Ethiopian', 'Fijian', 'Filipino', 'Finnish', 'French', 'Gabonese', 'Gambian', 'Georgian', 'German', 'Ghanaian', 'Greek', 'Grenadian', 'Guatemalan', 'Guinea-Bissauan', 'Guinean', 'Guyanese', 'Haitian', 'Herzegovinian', 'Honduran', 'Hungarian', 'I-Kiribati', 'Icelander', 'Indian', 'Indonesian', 'Iranian', 'Iraqi', 'Irish', 'Israeli', 'Italian', 'Ivorian', 'Jamaican', 'Japanese', 'Jordanian', 'Kazakhstani', 'Kenyan', 'Kittian and Nevisian', 'Kuwaiti', 'Kyrgyz', 'Laotian', 'Latvian', 'Lebanese', 'Liberian', 'Libyan', 'Liechtensteiner', 'Lithuanian', 'Luxembourger', 'Macedonian', 'Malagasy', 'Malawian', 'Malaysian', 'Maldivan', 'Malian', 'Maltese', 'Marshallese', 'Mauritanian', 'Mauritian', 'Mexican', 'Micronesian', 'Moldovan', 'Monacan', 'Mongolian', 'Moroccan', 'Mosotho', 'Motswana', 'Mozambican', 'Namibian', 'Nauruan', 'Nepali', 'New Zealander', 'Nicaraguan', 'Nigerian', 'Nigerien', 'North Korean', 'Northern Irish', 'Norwegian', 'Omani', 'Pakistani', 'Palauan', 'Panamanian', 'Papua New Guinean', 'Paraguayan', 'Peruvian', 'Polish', 'Portuguese', 'Qatari', 'Romanian', 'Russian', 'Rwandan', 'Saint Lucian', 'Salvadoran', 'Samoan', 'San Marinese', 'Sao Tomean', 'Saudi', 'Scottish', 'Senegalese', 'Serbian', 'Seychellois', 'Sierra Leonean', 'Singaporean', 'Slovakian', 'Slovenian', 'Solomon Islander', 'Somali', 'South African', 'South Korean', 'Spanish', 'Sri Lankan', 'Sudanese', 'Surinamer', 'Swazi', 'Swedish', 'Swiss', 'Syrian', 'Taiwanese', 'Tajik', 'Tanzanian', 'Thai', 'Togolese', 'Tongan', 'Trinidadian/Tobagonian', 'Tunisian', 'Turkish', 'Tuvaluan', 'Ugandan', 'Ukrainian', 'Uruguayan', 'Uzbekistani', 'Venezuelan', 'Vietnamese', 'Welsh', 'Yemenite', 'Zambian', 'Zimbabwean');
            return view('dashboard', compact('user', 'nationals'));
        }
    }
}
