<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gig;
use App\Models\Category;

class GigController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('gigs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        Gig::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'open',
        ]);

        return redirect()->route('dashboard')->with('success', 'Gig created successfully!');
    }

    public function show(Gig $gig)
    {
        $gig->load('applications.employee');
        return view('gigs.show', compact('gig'));
    }

    public function edit(Gig $gig)
    {
        if ($gig->user_id !== auth()->id()) abort(403);
        $categories = Category::all();
        return view('gigs.edit', compact('gig', 'categories'));
    }

    public function update(Request $request, Gig $gig)
    {
        if ($gig->user_id !== auth()->id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $gig->update($request->only('title', 'description', 'price', 'duration', 'category_id', 'address', 'latitude', 'longitude'));

        return redirect()->route('dashboard')->with('success', 'Gig updated successfully!');
    }

    public function destroy(Gig $gig)
    {
        if ($gig->user_id !== auth()->id() && auth()->user()->role !== 'admin') abort(403);
        $gig->delete();
        return back()->with('success', 'Gig deleted successfully!');
    }
}
