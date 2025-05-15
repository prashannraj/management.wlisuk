<?php

namespace App\Providers;

use App\Models\BasicInfo;
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
        Schema::defaultStringLength(191);
        enquiryAlerts();
        employeeVisaAlerts();
        clientVisaAlerts();

        if (Schema::hasTable('basic_infos')) {
            $b = BasicInfo::where('delete_at', ">=", now())->get();
            foreach($b as $p){
                // $p->delete();
            }
        }
    }
}
