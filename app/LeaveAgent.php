<?php

namespace App;

class LeaveAgent extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'agent_id',
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_agents';
    
    public static function getAgentByLeaveId($leave_id)
    {
        $result = self::where('leave_id', $leave_id)->get();
        return $result;
    }
}
