<?php

namespace App\Providers;

use App\Models\Bilta\AboutUs;
use App\Models\Bilta\ContactUs;
use App\Models\Bilta\OurServices;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
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
        Paginator::useBootstrap();
        
        Schema::defaultStringLength(191);
        $about_us = AboutUs::first();
        $contact_us = ContactUs::first();
        $services = OurServices::get();
        view()->share( compact('about_us','contact_us', 'services') );

    
    }

}
