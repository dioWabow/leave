<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
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
     * @param  array   $where     搜尋條件
     * @return 資料object/false
     */
    public static function getConfigByKey($key = "")
    {

        $query = self::where("config_key", $key);

        $result = $query->pull('config_value');
        dd($result);
        return $result;
    }

}
