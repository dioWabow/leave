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
        $tag_id = ['1','2','3','4'];
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
        $tag_id = ['9'];
        $today = Carbon::now()->format('Y-m-d');
        $result = Leave::where('start_time', '>=', $today)->whereIn('tag_id', $tag_id)->count();
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
     
    /**
     * 傳入 dataProvider 取得 假單排除狀態 tag 7(取消) 的時數總和
     * 
     */
    public function LeavesHoursTotal($data)
    {
        $result = $data->whereNotIn('tag_id', '7')->sum('hours');
        return $result;
    }

}