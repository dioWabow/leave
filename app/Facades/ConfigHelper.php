<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ConfigHelper extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'confighelper';
    }
}