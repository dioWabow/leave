<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveAgent extends Model
{
     /**
     * 與Model關聯的table
     *
     * @var string
     */
     protected $table = 'leaves_agents';

    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'agent_id',
    ];


    public static function getLeaveIdByAgentId($leave_id)
    {
        $result = self::where('leave_id',$leave_id)->get();
        return $result;
    }

    public function user() 
    {
        $result = self::hasOne('App\User','id','agent_id');
        return $result;
    }
}
