<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShowBusinessesSlotsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Business $business, int $year, int $month, int $day): View
    {
        $date = now()->setDate($year, $month, $day);

        $business->load(['slots' => function ($query) use ($date) {
            $query->with('booking')->where('slot_date', $date->format('Y-m-d'));
        }]);

        return view('business.slots', compact('business', 'date'));
    }
}

