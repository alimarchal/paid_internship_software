<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $candidates = User::where('profile_status', 1)->get();
        return view('candidate.index', compact('candidates'));
    }

    public function print(User $user)
    {
        return view('candidate.print',compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        if ($request->hasFile('profile_pic_1')) {
            $profile_path = $request->file('profile_pic_1')->store('profile-photos', 'public');
            $request->merge(['profile_photo_path' => $profile_path]);
        }

        if ($request->hasFile('cnic_front')) {
            $profile_path = $request->file('cnic_front')->store('cnic-front', 'public');
            $request->merge(['cnic_front_path' => $profile_path]);
        }

        if ($request->hasFile('cnic_back')) {
            $profile_path = $request->file('cnic_back')->store('cnic-back', 'public');
            $request->merge(['cnic_back_path' => $profile_path]);
        }


        $user->update($request->all());
        session()->flash('success', 'Your basic information record updated successfully.');
        return to_route('dashboard');
    }
}
