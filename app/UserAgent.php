<?php

namespace App;

class UserAgent extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'users_agents';

    //可以傳入數值的欄位
    protected $fillable = [
        'user_id',
        'agent_id',
    ];

    public static function deleteUserAgentByUserId($user_id)
    {
        $result = self::where('user_id',$user_id)->delete();
        return $result;
    }

    public static function getUserAgentByUserId($user_id)
    {
        $result = self::where('user_id',$user_id)->get();
        return $result;
    }

    public static function getAgentIdByUserId($user_id)
    {
        $result = self::where('user_id',$user_id)->get()->pluck('agent_id');
        return $result;
    }

    public function fetchUser() 
    {
        $result = self::hasOne('App\User','id','agent_id');
        return $result;
    }
}
