<?php

namespace App\Providers;

use App\Models\BasicInfo;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View; // ⬅️ Import View
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

        // ✅ Register view namespace for adminlte-templates
        View::addNamespace('adminlte-templates', resource_path('views/vendor/adminlte-templates'));

        if (Schema::hasTable('basic_infos')) {
            $b = BasicInfo::where('delete_at', ">=", now())->get();
            foreach ($b as $p) {
                // $p->delete();
            }
        }
    }
}
