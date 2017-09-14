<?php

namespace App\Classes;

use App\Leave;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 計算HR可查看等待審核的假單
     * tag 狀態 1,2,3,4
     * 
     */
    public static function getHrProveLeavesTotal()
    {
        $tag_id = [1,2,3,4];
        $result = Leave::whereIn('tag_id', $tag_id)->count();
        return $result;
    }

    /**
     * 計算HR可查看即將放假的假單
     * tag 狀態 9
     * 
     */
    public static function getHrUpComingLeavesTotal()
    {
        $tag_id = [9];
        $result = Leave::whereIn('tag_id', $tag_id)->count();
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

    public function LeavesHoursTotal($data)
    {
        $result = $data->whereNotIn('tag_id','7')->sum('hours');
        return $result;
    }

}