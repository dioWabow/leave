<?php

namespace App\Classes;

use App\Leave;
use App\LeaveAgent;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 傳入該代理人的agent_id(Auth::user()->id)
     * 
     * 取得該代理人所代理的的假單數量
     * 
     */
    public static function getAgentLeavesTotal($id)
    {
        $leave_id = LeaveAgent::getLeaveIdByUserId($id);
        $result = Leave::whereIn('id', $leave_id)->count();
        return $result;
    }
    
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDaysLabel($data)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($data);
        $result = '';

        if ($start_time->gte($today))  {

            $result = $today->diffInDays(Carbon::parse($start_time));

        } 

        return $result;
    }
}