<?php

namespace App\Http\Controllers;

use App\Models\RandomUserQuestion;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ReportController extends Controller
{
    public function callLetters()
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'Super-Admin'])) {
            $cdt = QueryBuilder::for(User::class)
                ->allowedFilters([
                    AllowedFilter::exact('batch_no'),
                    AllowedFilter::exact('status'),
                    AllowedFilter::exact('district_of_domicile'),
                ])
                ->whereNotNull('test_center')
                ->where('profile_status', 1)
                ->where('status', 'Shortlisted')
                ->whereIn('district_of_domicile', ['Sudhanoti', 'Haveli', 'Bagh', 'Poonch'])
                ->whereNotIn('id',[1965, 1756])
                ->get();

            return view('candidate.call-letters', compact('cdt'));
//            $cdt = User::where('profile_status', 1)->where('status', 'Shortlisted')->get();
//            return view('candidate.call-letters', compact('cdt'));
        }
        elseif ($user->hasRole('Intern')) {
            $cdt = User::where('profile_status', 1)->where('id', $user->id)->where('status', 'Shortlisted')->get();
            return view('candidate.call-letters', compact('cdt'));
        }
    }


    public function result()
    {
        $user = Auth::user();
        if ($user->email == "dh_hrd@bankajk.com" || $user->email == "hrd@bankajk.com") {
            $users = User::where('profile_status', 1)->where('status', 'Shortlisted')->orderBy('district', 'ASC')->get();
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();

            return view('candidate.results', compact('users', 'results'));
        }
        elseif ($user->hasRole('Intern')) {
            $cdt = User::where('profile_status', 1)->where('id', $user->id)->where('status', 'Shortlisted')->get();
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->where('user_id', $user->id)
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();
            return view('candidate.results', compact('cdt','user','results'));
        }
    }
    
    
    public function result_batch_two()
    {
        $user = Auth::user();
        if ($user->email == "dh_hrd@bankajk.com" || $user->email == "hrd@bankajk.com") {
            $users = User::where('profile_status', 1)->where('status', 'Shortlisted')
//            ->where('batch_no','Batch-02')
            ->where('test_date','2024-11-24')
//            ->whereIn('district_of_domicile',['Mirpur','Bhimber','Kotli'])
//            ->whereIn('district_of_domicile',['Bagh','Poonch','Sudhanoti','Haveli'])
//            ->whereNotIn('district_of_domicile',['Jhelum Valley','Muzaffarabad'])
//            ->whereIn('id',[808,869,897,928,946,983,994,1008,1017,1024,1034,1073,1093,1127,1137,1138,1149,1161,1162,1194,1199,1200,1230,1269,1332,1352,1356,1363,1365,1389,1402,1438,1439,1462,1488,1508,1528,1541,1582,1584,1585,1650,1668,1674,1678,1685,1690,1697,1705,1711,1712,1723,1726,1729,1761,1789,1802,1823,1848,1855,1863,1881,1888,1891,1909,1912,1913,1926,1950,1958,1987,2058,2102])
            // ->whereNotNull('start_test_time')
            ->orderBy('district_of_domicile', 'ASC')
            ->get();
            
            $results_ids = $users->pluck('id')->toArray();
            // dd($users->pluck('id')->toArray());
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->whereIn('user_id', $results_ids)
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();

            return view('candidate.result_batch_two', compact('users', 'results'));
        }
        elseif ($user->hasRole('Intern')) {
            $cdt = User::where('profile_status', 1)->where('id', $user->id)->where('status', 'Shortlisted')->get();
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->where('user_id', $user->id)
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();
            return view('candidate.result_batch_two', compact('cdt','user','results'));
        }
    }
    
    
    
        public function result_batch_two_kotli()
    {
        $user = Auth::user();
        if ($user->email == "dh_hrd@bankajk.com" || $user->email == "hrd@bankajk.com") {
            $users = User::where('profile_status', 1)->where('status', 'Shortlisted')
            ->where('batch_no','Batch-02')
            ->whereIn('district_of_domicile',['Kotli'])
            ->whereNotNull('start_test_time')->orderBy('district', 'ASC')->get();
            
            $results_ids = $users->pluck('id')->toArray();
            // dd($users->pluck('id')->toArray());
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->whereIn('user_id', $results_ids)
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();

            return view('candidate.result_batch_two_kotli', compact('users', 'results'));
        }
        elseif ($user->hasRole('Intern')) {
            $cdt = User::where('profile_status', 1)->where('id', $user->id)->where('status', 'Shortlisted')->get();
            $results = RandomUserQuestion::with('user')
                ->select('user_id', DB::raw('COUNT(question_id) AS system_assigned_questions'), DB::raw('SUM(is_answered) AS attemp_questions'), DB::raw('SUM(is_correct) AS correct_answer'))
                ->where('user_id', $user->id)
                ->groupBy('user_id')
                ->orderByDesc('correct_answer')
                ->get();
            return view('candidate.result_batch_two_kotli', compact('cdt','user','results'));
        }
    }
}
