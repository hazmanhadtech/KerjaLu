<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Application;
use App\Models\Gig;

class ApplicationController extends Controller
{
    public function index()
    {
        $applications = Application::with('gig')->where('user_id', auth()->id())->get();
        return view('applications.employee_index', compact('applications'));
    }

    public function store(Request $request, Gig $gig)
    {
        $request->validate([
            'message' => 'nullable|string'
        ]);

        if (Application::where('user_id', auth()->id())->where('gig_id', $gig->id)->exists()) {
            return back()->withErrors(['message' => 'You have already applied for this gig.']);
        }

        Application::create([
            'gig_id' => $gig->id,
            'user_id' => auth()->id(),
            'message' => $request->message,
            'status' => 'pending'
        ]);

        return redirect()->route('applications.index')->with('success', 'Application submitted!');
    }

    public function update(Request $request, Application $application)
    {
        if ($application->gig->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:accepted,rejected,completed'
        ]);

        $application->update(['status' => $request->status]);

        if ($request->status === 'accepted') {
            $application->gig->update(['status' => 'in-progress']);
            
            Application::where('gig_id', $application->gig_id)
                ->where('id', '!=', $application->id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);
        } elseif ($request->status === 'completed') {
            $application->gig->update(['status' => 'closed']);
        }

        return back()->with('success', 'Status updated.');
    }

    public function destroy(Application $application)
    {
        if ($application->user_id == auth()->id() && $application->status == 'pending') {
            $application->delete();
            return back()->with('success', 'Application cancelled.');
        }
        return back()->withErrors(['error' => 'Cannot cancel this application.']);
    }
}
