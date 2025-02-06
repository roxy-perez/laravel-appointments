<?php

use App\Http\Controllers\Booking\CancelSlotBookingController;
use App\Http\Controllers\Booking\CreateSlotBookingController;
use App\Http\Controllers\Booking\ListAvailableBusinessesController;
use App\Http\Controllers\Booking\ShowBusinessesSlotsController;
use App\Http\Controllers\Booking\UserBookingsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/businesses', ListAvailableBusinessesController::class)->name('businesses.list');
    Route::get('/slots/{business}/{year}/{month}/{day}', ShowBusinessesSlotsController::class)->name('slots.show');
    Route::post('/slots/{business}/{slot}/book', CreateSlotBookingController::class)->name('slots.book');
    Route::post('/slots/{business}/{booking}/cancel', CancelSlotBookingController::class)->name('bookings.cancel');
    Route::get('/my-bookings', UserBookingsController::class)->name('user.bookings');
});

require __DIR__.'/auth.php';
