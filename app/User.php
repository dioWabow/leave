<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
   //可以傳入數值的欄位
   protected $fillable = [
        'employee_no',
        'email',
        'password',
        'token',
        'remember_token',
        'name',
        'role',
        'status',
        'job_seek',
        'employee_no',
        'nickname',
        'sex',
        'birthday',
        'avatar',
        'enter_date',
        'leave_date',
        'status',
        'job_seek',
        'arrive_time',
        'order_by',
        'order_way',
        'pagesize',
    ];


    public static function getAgentIdByUsers($agent_id)
    {
        $result = self::whereIn('id',$agent_id);
    }




}
