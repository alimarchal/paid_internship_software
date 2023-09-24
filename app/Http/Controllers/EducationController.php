<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Education;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    //StoreEducationRequest $request
    public function store(StoreEducationRequest $request)
    {
        $user = Auth::user();
        $request->merge(['user_id' => $user->id]);
        if ($request->hasFile('degree_photo')) {
            $profile_path = $request->file('degree_photo')->store('degree-photo', 'public');
            $request->merge(['degree_photo_path' => $profile_path]);
        }
        $education = Education::create($request->all());
        session()->flash('success', 'Your education record added successfully.');
        return to_route('education.edit', $user->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user = Auth::user();
        return view('education.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEducationRequest $request, Education $education)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education, User $user)
    {
        $education->delete();
        session()->flash('success', 'Your education record has been deleted successfully.');
        return to_route('education.edit', $user->id);
    }
}
