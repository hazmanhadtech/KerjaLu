<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Gig;

class AdminController extends Controller
{
    public function users()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function gigs()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        $gigs = Gig::with('employer')->get();
        return view('admin.gigs', compact('gigs'));
    }

    public function destroyUser(User $user)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        if ($user->role === 'admin') return back()->withErrors(['error' => 'Cannot delete another admin.']);
        
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
