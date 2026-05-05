<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return view('dashboards.admin');
        } elseif ($user->role === 'employer') {
            $myGigs = \App\Models\Gig::where('user_id', $user->id)->latest()->get();
            
            // Browse Services with Proximity
            $query = \App\Models\Service::where('is_active', true);
            $searchMode = $request->input('search_mode');
            $radius = $request->input('radius', 50);
            $lat = null;
            $lng = null;

            if ($searchMode === 'home') {
                $lat = $user->latitude;
                $lng = $user->longitude;
            } elseif ($searchMode === 'current') {
                $lat = $request->input('lat');
                $lng = $request->input('lng');
            }

            if ($lat && $lng) {
                $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                      ->having('distance', '<=', $radius)
                      ->orderBy('distance');
            } else {
                $query->latest();
            }

            $services = $query->get();

            return view('dashboards.employer', compact('myGigs', 'services', 'searchMode', 'radius', 'lat', 'lng'));
        } else {
            $query = \App\Models\Gig::where('status', 'open');

            $searchMode = $request->input('search_mode'); // 'home' or 'current'
            $radius = $request->input('radius', 50); // Default 50km
            $lat = null;
            $lng = null;

            if ($searchMode === 'home') {
                $lat = $user->latitude;
                $lng = $user->longitude;
            } elseif ($searchMode === 'current') {
                $lat = $request->input('lat');
                $lng = $request->input('lng');
            }

            if ($lat && $lng) {
                $query->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
                      ->having('distance', '<=', $radius)
                      ->orderBy('distance');
            } else {
                $query->latest();
            }

            $gigs = $query->get();
            return view('dashboards.employee', compact('gigs', 'searchMode', 'radius', 'lat', 'lng'));
        }
    }
}
