<?php

namespace App\Classes;

use App\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class LeaveHelper
{
    /**
     * 傳入user_id 取得 user的等待核准假單
     * tag 狀態 2,3,4,5
     * 
     */
    public static function getProveLeavesTotal($id)
    {
        $tag_id = [2,3,4,5];
        $result = Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
        return $result;
    }
    /**
     * 傳入user_id 取得 user的即將放假假單
     * tag 狀態 7
     * 
     */
    public static function getUpComingLeavesTotal($id)
    {
        $tag_id = [9];
        $result = Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
        return $result;
    }
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDays($start_time)
    {
        $to_day = Carbon::now();
        $end_day = Carbon::parse($start_time);
        $diff_days = '';

        if ($end_day->gt($to_day))  {

            $diff_days = '倒數'. $to_day->diffInDays(Carbon::parse($start_time)) . '天'; 

        } 
       
        return $diff_days;

    }

}