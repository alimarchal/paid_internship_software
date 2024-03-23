<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
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
}
