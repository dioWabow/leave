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
    public function getDiffDaysLabel($start_time)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($start_time);
        $diff_days = '';

        if ($start_time->gt($today))  {

            $diff_days = '倒數'. $today->diffInDays(Carbon::parse($start_time)) . '天'; 

        } 
       
        return $diff_days;

    }

    public function LeavesHoursTotal($data)
    {
        $result = $data->whereNotIn('tag_id','7')->sum('hours');
        return $result;
    }

}