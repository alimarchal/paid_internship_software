<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Education;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function submit(Request $request)
    {
        $user = Auth::user();
        return view('submit.edit', compact('user'));
    }

    public function submitStore(Request $request)
    {
        if (!$request->has('agreement')) {
            session()->flash('error', 'You must agree to the terms and conditions before submitting your application.');
            return back(); // Assuming you want to send the user back to the form page.
        }

        $found_degree = 0;
        $found_subject = 0;
        $user = Auth::user();

        $eligibleMajors = ['Economics', 'Business Administration', 'Accounting', 'Finance', 'Commerce', 'CS/MCS/MIT'];
        $user = Auth::user();

        if ($user->education_degrees->isEmpty()) {
            session()->flash('error', 'Your profile has not been submitted due to missing your education qualification.');
            return to_route('education.edit', $user->id);
        }

        $eligibleDegreeFound = $user->education_degrees->contains(function ($degree) use ($eligibleMajors) {
            $isEligibleLevel = in_array($degree->education_level, ['Bachelor (16 Years) Degree', 'Master (16 Years) Degree']);
            $isEligibleMajor = in_array($degree->major_subject, $eligibleMajors);
            $hasRequiredMarks = round($degree->percentage_marks) >= 70.00;

            return $isEligibleLevel && $isEligibleMajor && $hasRequiredMarks;
        });

        if (!$eligibleDegreeFound) {
            session()->flash(
                'error',
                'You are not eligible to submit the application as you do not have 70% marks in your BS Degree. Please view Eligibility Criteria: Eligible candidates must have completed a minimum (4) years Bachelor degree Program in the disciplines of Economics, Business Administration, Accounting, Finance, Commerce, Computer Sciences & IT. Must have a minimum of 70% marks where the percentage system applies or a minimum of 3.00 out of 4.00 or 4.00 out of 5.00 CGPA, where the GPA system is applicable. Candidates must meet these requirements at the time of applying for the program. Students awaiting results to meet the eligibility criteria are ineligible. The maximum age limit is 27 years as of March 01, 2024.'
            );
            return to_route('education.edit', $user->id);
        }

        $user->profile_status = 1;
        $user->save();
        session()->flash('success', 'Your profile has been submitted to Human Resource Management Division (HRMD) successfully.');
        return to_route('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request)
    {
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        if ($request->hasFile('experience_photo')) {
            $profile_path = $request->file('experience_photo')->store('experience-photo', 'public');
            $request->merge(['experience_photo_path' => $profile_path]);
        }

        if ($request->hasFile('relieving_letter')) {
            $profile_path = $request->file('relieving_letter')->store('relieving-letter', 'public');
            $request->merge(['relieving_letter_path' => $profile_path]);
        }
        $education = Experience::create($request->all());
        session()->flash('success', 'Your experience record added successfully.');
        return to_route('experience.edit', $user->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('experience.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience, User $user)
    {
        $experience->delete();
        session()->flash('success', 'Your experience record has been deleted successfully.');
        return to_route('experience.edit', $user->id);
    }
}
