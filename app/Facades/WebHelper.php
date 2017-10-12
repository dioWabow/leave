<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class WebHelper extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'webhelper';
    }
}