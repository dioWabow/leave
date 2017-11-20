<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends BaseModel
{

    //可以傳入數值的欄位
    protected $fillable = [
        'config_key',
        'config_value',
        'comment',
    ];


    /**
     * 搜尋table單個資料
     *
     * @param  config key值
     * @return 資料string/false
     */
    public static function getConfigValueByKey($key = "")
    {
        $result = self::where("config_key", $key)->pluck('config_value')->first();
        return $result;
    }

    public static function updateConfigValueByKey($key = "",$value = "")
    {
        $result = self::where('config_key', $key)->update(['config_value' => $value]);
        return $result;
    }

    /**
     *
     * 回傳全Config
     * @var string array( key => value )
     */
    public static function getAllConfigValueArray() 
    {
        $config = self::remember(0.2)->get();
        $result = [];
        foreach ($config as $key => $value) {
            $result[ $value->config_key ] = $value->config_value;
        }
        return $result;
    }

}
