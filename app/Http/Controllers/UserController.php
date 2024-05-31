<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Comment;
use App\Models\RandomUserQuestion;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index()
    {
        $role_name = \Auth::user()->roles->first()->name;

        if ($role_name == "admin" || $role_name == "Super-Admin") {
            $candidates = QueryBuilder::for(User::class)
                ->allowedFilters([
                    'name',
                    'fathers_name',
                    'email',
                    AllowedFilter::exact('latestStatus.status'),
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('religion'),
                    AllowedFilter::exact('district'),
                    AllowedFilter::exact('district_of_domicile'),
                    AllowedFilter::exact('cnic_number'),
                    AllowedFilter::exact('profile_status'),
                    AllowedFilter::exact('batch_no'),
                    AllowedFilter::exact('status'),
                    AllowedFilter::exact('contact_number'),
                    AllowedFilter::exact('education_degrees_search.major_subject'),
                ])
                ->where('id', '>', 3)
                ->with('education_degrees', 'education_degrees_search','latestStatus')
                ->paginate(15)->withQueryString();

            return view('candidate.index', compact('candidates'));
        }
        else {
            $candidates = QueryBuilder::for(User::class)->with('education_degrees')
                ->allowedFilters([
                    'name',
                    'fathers_name',
                    'email',
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('religion'),
                    AllowedFilter::exact('district'),
                    AllowedFilter::exact('district_of_domicile'),
                    AllowedFilter::exact('cnic_number'),
                    AllowedFilter::exact('profile_status'),
                    AllowedFilter::exact('contact_number'),
                ])
                ->where('id', \Auth::user()->id)
                ->paginate(15)->withQueryString();

            return view('candidate.index', compact('candidates'));
        }
    }

    public function print(User $user)
    {
        $role_name = \Auth::user()->roles->first()->name;
        if ($role_name == "admin" || $role_name == "Super-Admin") {
            $get_user_questions = RandomUserQuestion::where('user_id', $user->id)->get();
//            dd($get_user_questions);
            return view('candidate.print', compact('user','get_user_questions'));
        }
        else {
            if (\Auth::user()->id != $user->id) {
                abort(401);
            }
            return view('candidate.print', compact('user'));
        }
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


    public function shortlisted(Request $request, User $user)
    {
        // Check if the authenticated user has the required role
        $role_name = Auth::user()->roles->first()->name;
        if ($role_name == "admin" || $role_name == "Super-Admin") {
            // Begin a transaction
            DB::beginTransaction();

            try {
                $commentText = $request->comment;
                $status = $request->status;

                // Create a comment
                $comment = Comment::create([
                    'user_id' => $user->id,
                    'user_id_comment_by' => Auth::id(), // corrected from $auth_id->id to Auth::id()
                    'comments' => $commentText,
                    'status' => $status,
                ]);

                // Update user status
                $user->status = $status;
                $user->save();

                // Commit the transaction
                DB::commit();

                // Flash a professional success message
                session()->flash('success', 'Decision recorded successfully.');

                // Redirect
                return to_route('candidate.print', $user->id);
            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();

                // Log the error or handle it as per your requirement
                // Log::error($e->getMessage());

                // Flash a professional error message
                session()->flash('error', 'Unable to process your decision at this moment. Please try again later.');

                // Redirect back or to a specific route
                return back();
            }
        }
        else {
            // If user does not have the required role, abort with 401 Unauthorized
            return abort(401);
        }
    }
}
