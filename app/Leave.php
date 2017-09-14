<?php

namespace App;

class Leave extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'user_id',
        'type_id',
        'tag_id',
        'start_time',
        'end_time',
        'hours',
        'reason',
        'prove',
        'create_user_id',
        'agent',
        'notice_person',
        'timepicker',
        'dayrange',
    ];
    
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves';

}
