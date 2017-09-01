<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name',
        'reset_time',
        'hours',
        'exception',
        'start_time',
        'end_time',
        'reason',
        'prove',
        'available',
        'order_by',
        'order_way',
        'pagesize',
    ];
    
    public static function getLeavesTypeIdByTypeId($type_id) 
    {
        $result = self::where('id',$type_id)->get();
        return $result;
    }
}
