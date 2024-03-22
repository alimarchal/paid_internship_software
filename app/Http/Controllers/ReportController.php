<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function callLetters()
    {
        $cdt = User::where('profile_status', 1)->where('status','Shortlisted')->get();
        return view('candidate.call-letters', compact('cdt'));
    }
}
