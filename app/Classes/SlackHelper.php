<?php

namespace App\Classes;

use App\Config;

use Illuminate\Notifications\Notifiable;

class SlackHelper
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        $result = Config::getConfigValueByKey("slack_token");

        return $result;
    }
}