<?php

namespace App;

class Type extends BaseModel
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
}
