<?php

namespace App\Http\Controllers;

use App\Models\Payout;
use App\Models\Application;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    public function payGig(Request $request, Application $application)
    {
        // Only the employer who posted the gig can pay
        if ($application->gig->user_id !== auth()->id()) abort(403);
        
        // Ensure it's completed before paying
        if ($application->status !== 'completed') {
            return back()->with('error', 'You can only pay for completed gigs.');
        }

        // Check if already paid
        if (Payout::where('payable_type', Application::class)->where('payable_id', $application->id)->exists()) {
            return back()->with('error', 'This gig has already been paid.');
        }

        Payout::create([
            'user_id' => auth()->id(),
            'recipient_id' => $application->user_id,
            'amount' => $application->gig->price,
            'payable_type' => Application::class,
            'payable_id' => $application->id,
            'status' => 'completed',
            'payment_method' => 'system_wallet',
        ]);

        return back()->with('success', 'Payment successful! Freelancer has been paid.');
    }

    public function payService(Request $request, ServiceBooking $booking)
    {
        // Only the employer who booked the service can pay
        if ($booking->user_id !== auth()->id()) abort(403);

        // Ensure it's completed before paying
        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can only pay for completed services.');
        }

        // Check if already paid
        if (Payout::where('payable_type', ServiceBooking::class)->where('payable_id', $booking->id)->exists()) {
            return back()->with('error', 'This service has already been paid.');
        }

        Payout::create([
            'user_id' => auth()->id(),
            'recipient_id' => $booking->service->user_id,
            'amount' => $booking->service->price,
            'payable_type' => ServiceBooking::class,
            'payable_id' => $booking->id,
            'status' => 'completed',
            'payment_method' => 'system_wallet',
        ]);

        return back()->with('success', 'Payment successful! Freelancer has been paid.');
    }

    public function index()
    {
        $user = auth()->user();
        $payouts = Payout::where('user_id', $user->id)
            ->orWhere('recipient_id', $user->id)
            ->with(['payer', 'recipient', 'payable'])
            ->latest()
            ->get();
            
        return view('payouts.index', compact('payouts'));
    }

    public function adminIndex()
    {
        $payouts = Payout::with(['payer', 'recipient', 'payable'])->latest()->get();
        return view('admin.payouts', compact('payouts'));
    }
}
