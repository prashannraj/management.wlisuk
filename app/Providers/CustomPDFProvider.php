<?php

namespace App\Providers;

use App\Custom\NewPDF;
use Barryvdh\DomPDF\ServiceProvider as DomPDFServiceProvider;
use Dompdf\Dompdf;

class CustomPDFProvider extends DomPDFServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = base_path().'/vendor/barryvdh/laravel-dompdf/config/dompdf.php';
        $this->mergeConfigFrom($configPath, 'dompdf');

        $this->app->bind('dompdf.options', function(){
            $defines = $this->app['config']->get('dompdf.defines');

            if ($defines) {
                $options = [];
                foreach ($defines as $key => $value) {
                    $key = strtolower(str_replace('DOMPDF_', '', $key));
                    $options[$key] = $value;
                }
            } else {
                $options = $this->app['config']->get('dompdf.options');
            }

            return $options;

        });

        $this->app->bind('dompdf', function() {

            $options = $this->app->make('dompdf.options');
            $dompdf = new Dompdf($options);
            $dompdf->setBasePath(realpath(base_path('public')));

            return $dompdf;
        });
        $this->app->alias('dompdf', Dompdf::class);

        $this->app->bind('dompdf.wrapper', function ($app) {
            return new NewPDF($app['dompdf'], $app['config'], $app['files'], $app['view']);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
