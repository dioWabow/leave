<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //可以傳入數值的欄位
    protected $fillable = ['config_key', 'config_value'];
    
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'configs';

    public function getValue($key){
        $result = $this->where('config_key','=', $key)->pluck('config_value');
		return $result;
    }

}
