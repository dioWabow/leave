<?php

namespace App\Classes;

use Auth;
use App\Leave;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 我的假單
     * 取得 user的等待核准假單數量
     * tag 狀態 1,2,3,4
     * 
     */
    public static function getProveMyLeavesTotalByUserId()
    {
        $model = new Leave;
        $search['user_id'] = Auth::user()->id;
        $search['tag_id'] = ['1','2','3','4'];
        $result = $model->searchForProveAndUpComInMy($search)->count();
        return $result;
    }

    /**
     * 我的假單
     * 取得 user的即將放假假單數量
     * tag 狀態 9
     * 
     */
    public static function getUpComingMyLeavesTotalByUserId()
    {
        $model = new Leave;
        $search['user_id'] = Auth::user()->id;
        $search['tag_id'] = ['9'];
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        $result = $model->searchForProveAndUpComInMy($search)->count();
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
    public static function getLeavesHoursTotal($data)
    {
        return $data->whereNotIn('tag_id','7')->sum('hours');
    }

}