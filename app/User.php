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
        'birthday',
        'birthday',
        'avatar',
        'enter_date',
        'leave_date',
        'status',
        'job_seek',
        'arrive_time',
    ];

    /**
     * 搜尋table單個資料
     *
     * @param  array   $where     搜尋條件
     * @return 資料object/false
     */
    public static function getUserByEmail($email="") {

        $query = self::where("email", $email);

        $result = $query->first();

        return $result;
    }
}
