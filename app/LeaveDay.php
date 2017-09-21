<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_days';

    /**
     * 取得當天上午/下午/整天的拆單假單+請假人nickname
     */
    public static function getTodayLeave($type = "") 
    {
        $start_time = "";
        $end_time = "";
        switch ($type) {
            
            case 'morning':
                $start_time = date("Y-m-d 09:00:00");
                $end_time = date("Y-m-d 14:00:00");
                break;

            case 'afternoon':
                $start_time = date("Y-m-d 14:00:00");
                $end_time = date("Y-m-d 18:00:00");
                break;

            case 'all_day':
                $start_time = date("Y-m-d 09:00:00");
                $end_time = date("Y-m-d 18:00:00");
                break;

            default:
                $start_time = date("Y-m-d 09:00:00");
                $end_time = date("Y-m-d 18:00:00");
                break;

        }

        $result = self::where('leaves_days.start_time',">=", $start_time )->where('leaves_days.end_time',"<=", $end_time)->leftJoin('leaves', 'leaves.id', '=', 'leaves_days.leave_id')->where('leaves.tag_id', "9")->get();
        return $result;
    }

    public function hasUser(){

        $result = $this::hasOne('App\User', 'id', 'user_id');
        return $result;

    }
}
