<?php

namespace App\Classes;

use App\Leave;
use App\LeaveAgent;

use Auth;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 傳入該代理人的user_id
     * 找到該代理人的所代理的假單
     * 確認假單在 tag 1 (代理人待核)
     * 取得代理假單的總數
     */
    public static function getAgentApproveLeavesTotal()
    {
        $id = Auth::user()->id;
        $tag_id = '1';
        
        $leave_id = LeaveAgent::getLeaveIdByUserId($id);
        $result = Leave::whereIn('id', $leave_id)->where('tag_id', $tag_id)->count();
        return $result;
    }
}