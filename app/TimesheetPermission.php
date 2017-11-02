<?php

namespace App;

class TimesheetPermission extends BaseModel
{
    protected $fillable = [
        'user_id',
        'allow_user_id',
    ];

    public static function getAllPermission()
    {
        $result = self::get();
        return $result;
    }

    public static function getAllowUserIdByUserId($id)
    {
        $result = self::where('user_id', $id)->get();
        return $result;
    }

    public function fetchUser()
    {
        $result = $this->hasOne('App\User', 'id' , 'allow_user_id');
        return $result;
    }

}
