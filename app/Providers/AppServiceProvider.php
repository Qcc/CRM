<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('zh');
		\App\Models\Follow::observe(\App\Observers\FollowObserver::class);
		\App\Models\Customer::observe(\App\Observers\CustomerObserver::class);
		\App\Models\Record::observe(\App\Observers\RecordObserver::class);
    }
}
