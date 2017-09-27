<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveRespon extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_responses';

     //可以傳入數值的欄位
     protected $fillable = [
        'leave_id',
        'user_id',
        'tag_id',
        'memo',
    ];
}
