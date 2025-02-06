<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListAvailableBusinessesController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): View
    {
        $businesses = Business::with('schedules')->get();

        return view('business.list', compact('businesses'));
    }
}

