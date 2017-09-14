<?php

namespace App\Providers;

use App\Classes\LeaveHelper; //include custom class
use Illuminate\Support\ServiceProvider;

class LeaveHelperServiceProvider extends ServiceProvider
{
     /**
     * Indicates if loading of the provider is deferred. 
     * 延遲使用程序加載，有用到才載入，增加效能
     *
     * @var bool
     */
     protected $defer = true;

     /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     * 
     * @return void
     */
    public function register()
    {
        $this->app->bind('leavehelper', function() {
            return new LeaveHelper();
        });
    }

    public function provides()
    {
        return ['leavehelper'];
    }
}
