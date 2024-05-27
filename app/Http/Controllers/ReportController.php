<?php

namespace App\Http\Controllers;

use App\Models\RandomUserQuestion;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function callLetters()
    {
        $user = Auth::user();

        if ($user->hasRole(['admin', 'Super-Admin'])) {
            $cdt = User::where('profile_status', 1)->where('status', 'Shortlisted')->get();
            return view('candidate.call-letters', compact('cdt'));
        }
        elseif ($user->hasRole('Intern')) {
            $cdt = User::where('profile_status', 1)->where('id', $user->id)->where('status', 'Shortlisted')->get();
            return view('candidate.call-letters', compact('cdt'));
        }
    }


    public function result()
    {
        $user = Auth::user();
        if ($user->email == "dh_hrd@bankajk.com") {
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
}
