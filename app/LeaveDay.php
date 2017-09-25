<?php

namespace App;

use Carbon\Carbon;

class LeaveDay extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'type_id',
        'start_time',
        'end_time',
        'hours',
        'create_user_id',
        'user_id',
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_days';

    public static function getLeavesIdByDateRangeAndLeavesId($start_time,$end_time, $leave_id)
    {
        $result = self::whereIn('leave_id', $leave_id)->whereBetween('start_time' , [$start_time, $end_time])
                    ->groupBy('leave_id')
                    ->pluck('leave_id');
        return $result;
    }

    public static function getLeavesIdByToDay($leave_id)
    {
        $today = Carbon::now()->format('Y-m-d');
        $result = self::whereIn('leave_id', $leave_id)->where('start_time', '<' , $today)
                    ->groupBy('leave_id')
                    ->pluck('leave_id');
        return $result;
    }

    public static function getLeaveByUserIdDateRangeType($user_id,$start_time,$end_time,$type)
    {
        $leave_hours = 0;

        $query = self::where('user_id' , $user_id);

        if (is_array($type)) {

            $query->whereIn('type_id' , $type);

        } elseif($type != "") {

           $query->where('type_id' , $type);

        }

        $query->Where(function ($query1) use ($start_time,$end_time) {
            
            $query1->orWhere(function ($query2) use ($start_time,$end_time) {
                $query2->Where("start_time", '>=' ,$start_time);
                $query2->Where("start_time", '<' ,$end_time);
            });

            $query1->orWhere(function ($query3) use ($start_time,$end_time) {
                $query3->Where("end_time", '>' ,$start_time);
                $query3->Where("end_time", '<=' ,$end_time);
            });

            $query1->orWhere(function ($query4) use ($start_time,$end_time) {
                $query4->Where("start_time", '<=' ,$start_time);
                $query4->Where("end_time", '>=' ,$end_time);
            });

        });

        $LeaveDays = $query->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (!in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_cancel_and_refuse_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }

}
