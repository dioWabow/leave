<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //可以傳入數值的欄位
    protected $fillable = [
        'name',
        'shortname',
        'sort',
    ];


    public static function getLeavesTagIdByTagId($tag_id) 
    {
        $result = self::where('id',$tag_id)->get();
        return $result;
    }
}
