<?php

namespace App\Classes;

use App\Config;

class ConfigHelper
{

    private $config;

    function __construct ()
    {
        $this->config = Config::getAllConfigValueArray();
    }

    /**
     * 取得 status (狀態) 名稱
     *
     * @return []
     */
    public function getConfigValueByKey($key)
    {        
        return (!empty($this->config[$key])) ? $this->config[$key] : null;
    }

}