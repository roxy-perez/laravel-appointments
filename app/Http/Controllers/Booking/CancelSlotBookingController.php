<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Business;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CancelSlotBookingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Business $business, Booking $booking): RedirectResponse
    {
        $booking->delete();

        $request->user()->increment('credit');

        return redirect()->route('slots.show', [
            'business' => $business,
            'year' => $booking->slot->slot_date->year,
            'month' => $booking->slot->slot_date->month,
            'day' => $booking->slot->slot_date->day,
        ]);
    }
}
