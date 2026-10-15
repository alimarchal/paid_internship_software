<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index', [
            'categories' => Category::count(),
            'questions' => Question::count(),
            'answers' => Answer::count(),
            'candidates' => User::role('Intern')->count(),
        ]);
    }
}
