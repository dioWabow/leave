<?php

namespace App\Classes;

use App\Leave;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class LeaveHelper
{
    /**
     * 傳入user_id 取得 user的等待核准假單
     * tag 狀態 2,3,4,5
     * 
     */
    public static function getProveLeavesTotalByUserId($id)
    {
        $tag_id = [2,3,4,5];
        return Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
    }
    /**
     * 傳入user_id 取得 user的即將放假假單
     * tag 狀態 7
     * 
     */
    public static function getUpComingLeavesTotalByUserId($id)
    {
        $tag_id = [9];
        return Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
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

        if ($start_time->gt($today))  {

            $result = '倒數'. $today->diffInDays(Carbon::parse($start_time)) . '天'; 

        } 
       
        return $result;

    }
    /**
     * 傳入 dataProvider 取得 假單排除狀態 tag 7(取消) 的時數總和
     * 
     */
    public static function getLeavesHoursTotal($data)
    {
        return $data->whereNotIn('tag_id','7')->sum('hours');
    }

}