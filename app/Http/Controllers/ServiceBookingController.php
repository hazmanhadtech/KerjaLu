<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class ServiceBookingController extends Controller
{
    public function store(Request $request, Service $service)
    {
        $request->validate([
            'message' => 'nullable|string',
        ]);

        ServiceBooking::create([
            'user_id' => auth()->id(),
            'service_id' => $service->id,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Service booked successfully!');
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'employer') {
            $bookings = ServiceBooking::where('user_id', $user->id)->with('service.employee')->latest()->get();
            return view('services.bookings.employer', compact('bookings'));
        } else {
            $bookings = ServiceBooking::whereHas('service', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with('employer')->latest()->get();
            return view('services.bookings.employee', compact('bookings'));
        }
    }

    public function update(Request $request, ServiceBooking $booking)
    {
        // Only the service owner can update the status
        if ($booking->service->user_id !== auth()->id()) abort(403);

        $request->validate([
            'status' => 'required|in:accepted,completed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated!');
    }
}
