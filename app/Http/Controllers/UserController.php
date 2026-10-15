<?php

namespace App\Http\Controllers;

use App\Filters\CandidateFilters;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Comment;
use App\Models\RandomUserQuestion;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role_name = Auth::user()->roles->first()->name;

        if ($role_name == 'admin' || $role_name == 'Super-Admin') {
            // Default 50 per page with pagination; the list can also show 10 / 100 / all.
            $perPage = in_array($request->query('per_page'), ['10', '50', '100', 'all'], true) ? $request->query('per_page') : '50';

            $query = QueryBuilder::for(User::candidates(), $request)
                ->allowedFilters(...CandidateFilters::allowed())
                ->allowedSorts(...CandidateFilters::sorts())
                ->defaultSort('id')
                ->with('education_degrees', 'education_degrees_search', 'latestStatus');

            $candidates = $perPage === 'all' ? $query->get() : $query->paginate((int) $perPage)->withQueryString();

            return view('candidate.index', [
                'candidates' => $candidates,
                'paginated' => $perPage !== 'all',
                'perPage' => $perPage,
                'isAdmin' => true,
                'statusCounts' => User::candidates()->selectRaw('status, count(*) n')->groupBy('status')->pluck('n', 'status'),
                'testCenters' => User::candidates()->whereNotNull('test_center')->distinct()->orderBy('test_center')->pluck('test_center'),
                'degreeLevels' => User::candidates()->whereNotNull('degree_level')->distinct()->orderBy('degree_level')->pluck('degree_level'),
            ]);
        } else {
            $candidates = User::with('education_degrees')->where('id', Auth::user()->id)->get();

            return view('candidate.index', [
                'candidates' => $candidates,
                'paginated' => false,
                'perPage' => 'all',
                'isAdmin' => false,
                'statusCounts' => collect(),
                'testCenters' => collect(),
                'degreeLevels' => collect(),
            ]);
        }
    }

    public function print(User $user)
    {
        $role_name = Auth::user()->roles->first()->name;
        if ($role_name == 'admin' || $role_name == 'Super-Admin') {
            $get_user_questions = RandomUserQuestion::where('user_id', $user->id)->get();

            //            dd($get_user_questions);
            return view('candidate.print', compact('user', 'get_user_questions'));
        } else {
            if (Auth::user()->id != $user->id) {
                abort(401);
            }
            // The paper review section is admin-only; interns get an empty set so the page still renders.
            $get_user_questions = collect();

            return view('candidate.print', compact('user', 'get_user_questions'));
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
        if ($role_name == 'admin' || $role_name == 'Super-Admin') {
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
        } else {
            // If user does not have the required role, abort with 401 Unauthorized
            return abort(401);
        }
    }
}
