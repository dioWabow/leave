<?php

namespace App\Classes;

use App\Config;

use Illuminate\Notifications\Notifiable;
use Config as SystemConfig;

class EmailHelper
{
    public $to = '';

    use Notifiable;

    public function routeNotificationForMail()
    {
        SystemConfig::set('app.name', Config::getConfigValueByKey("smtp_display"));
        SystemConfig::set('mail.host', Config::getConfigValueByKey("smtp_host"));
        SystemConfig::set('mail.port', Config::getConfigValueByKey("smtp_port"));
        SystemConfig::set('mail.username', Config::getConfigValueByKey("smtp_username"));
        SystemConfig::set('mail.password', Config::getConfigValueByKey("smtp_password"));
        return $this->to;
    }
}