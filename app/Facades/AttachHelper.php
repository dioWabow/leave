<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class AttachHelper extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'attachhelper';
    }
}
