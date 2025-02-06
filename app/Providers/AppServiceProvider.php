<?php

namespace App\Providers;

use App\Models\Business;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Blade::if('dateNotIsToday', function (Carbon $date) {
            return ! $date->isToday();
        });

        Blade::if('dateWithinMaxFutureDays', function (Carbon $date, Business $business) {
            return $date->dayOfYear < (now()->dayOfYear + $business->max_future_days);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
