<?php

namespace App\Providers;

use Carbon\Carbon;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $start_date = "2018-01-01 00:00:00";
        $enter_date = "2016-11-04 00:00:00";
        $hours = "";
        $annual_date = 0;

        $start_date_year = ($start_date=="") ? date('Y', strtotime(Carbon::now())) : date('Y', strtotime($start_date));
        $enter_date_year = date('Y', strtotime($enter_date));
        $service_year = intval($start_date_year - $enter_date_year );

        switch ($service_year) {
            case 0:
            case 1:
                $enter_date_month = intval(date('m', strtotime($enter_date)));
                if ($enter_date_month <=6) {

                    $annual_date = 3;

                }
                break;
            case 2:
                $annual_date = 7;
                break;
            case 3:
                $annual_date = 10;
                break;
            case 4:
            case 5:
                $annual_date = 14;
                break;
            case ($service_year > 5 && $service_year <= 10):
                $annual_date = 15;
                break;
            case ($service_year > 10):
                $annual_date = ($service_year + 4 < 30) ? $service_year + 4 : 30;
                break;
        }

        $annual_date = $annual_date*8;

        View::share(compact('annual_date'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local')
        {
            $this->app->register('Barryvdh\Debugbar\ServiceProvider');
        }
    }
}
