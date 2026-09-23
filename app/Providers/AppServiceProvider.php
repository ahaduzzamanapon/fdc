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
        if (config('app.env') !== 'local') {
           // \URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer(['welcome', 'font_end.*'], function ($view) {
            $siteSetting = \App\Models\SiteSetting::first();
            $contactInfo = \App\Models\ContactInfo::first();
            $view->with('siteSetting', $siteSetting)->with('contactInfo', $contactInfo);
        });
    }
}
