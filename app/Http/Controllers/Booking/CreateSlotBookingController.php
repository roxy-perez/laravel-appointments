<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\Slot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CreateSlotBookingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Business $business, Slot $slot): RedirectResponse
    {
        abort_if (! $request->user()->hasCredits(), 403, 'You do not have enough credits to book this slot!');

        $slot->booking()->create([
            'user_id' => $request->user()->id,
        ]);

        $request->user()->decrement('credit');

        return redirect()->route('slots.show', [
            'business' => $slot->business,
            'year' => $slot->slot_date->year,
            'month' => $slot->slot_date->month,
            'day' => $slot->slot_date->day,
        ]);
    }
}

