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
        if ($request->has('agreement')) {
            $user = Auth::user();
            $user->profile_status = 1;
            $user->save();
            session()->flash('success', 'Your profile has been submitted to Human Resource Management Division (HRMD) successfully.');
            return to_route('dashboard');
        }
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
