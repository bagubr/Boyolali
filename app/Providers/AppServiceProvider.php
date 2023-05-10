<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
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
    public function boot(UrlGenerator $url)
    {
        if(env('ENFORCE_SSL', false)) {
            $url->forceScheme('https');
        }
        Blade::directive('tampil', function ($expression, $depan = '', $belakang = '') {
            if(!$expression){
                return '-';
            }else{
                return $expression;
            }
        });
    }
}
