<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LeaveHelper extends Facade
{
    protected static function getFacadeAccessor() 
    {
        return 'leavehelper';
    }
}
