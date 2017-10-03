<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SlackHelper extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'slackhelper';
    }
}