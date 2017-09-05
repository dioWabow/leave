<?php

namespace App;

class Leave extends BaseModel
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

    public static function getTypeIdByLeaves($id) 
    {
        $result = self::where('type_id', $id)->get();
        return $result;
    }
}
