<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchController extends Controller
{
    public function index()
    {
        $counts = User::role('Intern')->selectRaw('batch_no, count(*) n')->groupBy('batch_no')->pluck('n', 'batch_no');

        return view('settings.batches.index', [
            'batches' => Batch::orderBy('name')->get(),
            'counts' => $counts,
            'deadline' => Setting::registrationDeadline(),
            'open' => Setting::registrationOpen(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:50', 'unique:batches,name']]);

        Batch::create(['name' => trim($data['name'])]);

        return back()->with('success', 'Batch added.');
    }

    public function destroy(Batch $batch)
    {
        if ($batch->is_registration) {
            return back()->with('error', 'This is the current registration batch. Choose another one first.');
        }
        if (User::where('batch_no', $batch->name)->exists()) {
            return back()->with('error', 'This batch has candidates, so it cannot be deleted.');
        }

        $batch->delete();

        return back()->with('success', 'Batch deleted.');
    }

    /** Registration batch + deadline. */
    public function registration(Request $request)
    {
        $data = $request->validate([
            'batch_id' => ['required', 'exists:batches,id'],
            'deadline' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($data) {
            Batch::query()->update(['is_registration' => false]);
            Batch::whereKey($data['batch_id'])->update(['is_registration' => true]);
            Setting::put('registration_deadline', \Carbon\Carbon::parse($data['deadline'])->format('Y-m-d H:i:s'));
        });

        return back()->with('success', 'Registration settings saved.');
    }
}
