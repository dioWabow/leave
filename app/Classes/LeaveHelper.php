<?php

namespace App\Classes;

use App\LeaveAgent;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 傳入該代理人的agent_id
     * 取得該代理人所代理的的假單數量
     * 
     */
     public static function getAgentLeavesTotal($id)
     {
         $result = LeaveAgent::where('agent_id', $id)->count();
         return $result;
     }
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDaysLabel($start_time)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($start_time);
        $result = '';

        if ($start_time->gt($today))  {

            $result = '倒數'. $today->diffInDays(Carbon::parse($start_time)) . '天'; 

        } 
       
        return $result;

    }
}