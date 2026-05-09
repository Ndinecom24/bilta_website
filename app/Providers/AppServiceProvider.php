<?php

namespace App\Providers;

use App\Models\Bilta\AboutUs;
use App\Models\Bilta\ContactUs;
use App\Models\Bilta\OurServices;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;


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

        $about_us = null;
        $contact_us = null;
        $services = collect();

        try {
            if (Schema::hasTable('about_us')) {
                $about_us = AboutUs::first();
            }

            if (Schema::hasTable('contact_us')) {
                $contact_us = ContactUs::first();
            }

            if (Schema::hasTable('our_services')) {
                $services = OurServices::get();
            }
        } catch (Throwable $th) {
            $about_us = null;
            $contact_us = null;
            $services = collect();
        }

        view()->share( compact('about_us','contact_us', 'services') );

    
    }

}
