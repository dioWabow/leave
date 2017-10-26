<?php

namespace App;

class TimesheetPermission extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'timesheet_permissions';

    //可以傳入數值的欄位
    protected $fillable = [
        'user_id',
        'allow_user_id',
    ];

    public static function getTimeSheetPermissionByUserId($user_id)
    {
        $result = self::where('user_id',$user_id)->get();
        return $result;
    }

    public function fetchUser() 
    {
        $result = self::hasOne('App\User','id','allow_user_id');
        return $result;
    }
}
