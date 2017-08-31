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
        $start_date = "2017-08-31 00:00:00";
        $enter_date = "2016-11-07 00:00:00";
        $hours = "";
        $annual_date = 0;

        $start_date_year = ($start_date=="") ? date('Y', strtotime(Carbon::now())) : date('Y', strtotime($start_date));
        $enter_date_year = date('Y', strtotime($enter_date));
        $service_year = intval($start_date_year - $enter_date_year );

        $start_date_month = ($start_date=="") ? date('m', strtotime(Carbon::now())) : date('m', strtotime($start_date));
        $enter_date_month = date('m', strtotime($enter_date));
        $service_month = intval($start_date_month - $enter_date_month);

        $start_date_day = ($start_date=="") ? date('d', strtotime(Carbon::now())) : date('d', strtotime($start_date));
        $enter_date_day = date('d', strtotime($enter_date));
        $service_day = intval($start_date_day - $enter_date_day);

        if (($start_date_month - $enter_date_month) <0 ) {

            $service_year --;

        }

        switch ($service_year) {
            case 0:
                if ($start_date_year != $enter_date_year) {

                    $service_month += 12;
                    if ($service_month > 6) {

                        $annual_date = 3;

                    } elseif($service_month == 6 && $service_day >= 0) {

                        $annual_date = 3;

                    }

                }
                break;
            case 1:
                $annual_date = 7;
                break;
            case 2:
                $annual_date = 10;
                break;
            case 3:
            case 4:
                $annual_date = 14;
                break;
            case ($service_year >= 5 && $service_year < 10):
                $annual_date = 15;
                break;
            case ($service_year >= 10):
                $annual_date = ($service_year + 6 < 30) ? $service_year + 6 : 30;
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
