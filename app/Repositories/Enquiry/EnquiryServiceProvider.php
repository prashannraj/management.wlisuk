<?php

namespace App\Repositories\Enquiry;

use Illuminate\Support\ServiceProvider;

class EnquiryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }


    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Enquiry\EnquiryInterface', 'App\Repositories\Enquiry\EnquiryRepository');
    }
}