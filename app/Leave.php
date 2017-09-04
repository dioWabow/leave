<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'tag_id',
        'start_time',
        'end_time',
        'hours',
        'reason',
        'prove',
        'creat_user_id',
        'order_by',
        'order_way',
        'pagesize',
    ];

    public static function getTypeIdByLeaves($type_id) 
    {
        $result = self::where('type_id', $type_id)->get();
        return $result;
    }
}
