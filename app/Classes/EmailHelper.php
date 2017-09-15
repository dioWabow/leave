<?php

namespace App\Classes;

use App\Config;

use Illuminate\Notifications\Notifiable;

class EmailHelper
{
    use Notifiable;

    public function routeNotificationForMail()
    {
        return "eno@wabow.com";
    }
}