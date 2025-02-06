<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserBookingsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): View
    {
        $bookings = $request->user()->bookings()->with('slot.business')->get();

        return view('user.bookings', compact('bookings'));
    }
}
