<?php

namespace App\Classes;

use App\Config;

class ConfigHelper
{
    /**
     * 取得 status (狀態) 名稱
     *
     * @return []
     */
    public static function getConfigValueByKey($key)
    {
        $value = Config::getConfigValueByKey($key);
        
        return (!empty($value)) ? $value : null;
    }

}