<?php

namespace App\Providers;

use App\Classes\SlackHelper; //include custom class
use Illuminate\Support\ServiceProvider;

class SlackHelperServiceProvider extends ServiceProvider
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
        $this->app->bind('slackhelper', function() {
            return new SlackHelper();
        });
    }

    public function provides()
    {
        return ['slackhelper'];
    }
}