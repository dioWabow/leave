<?php

namespace App;

Use App\Leave;

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

    /**
     * 不會被計算在放假天數之內的狀態
     *
     * @var array
     */
    protected $leave_tag_arr = [7,8];

    public static function checkLeaveByUserIdDateTypeHours($user_id,$start_date,$end_date,$type,$hours)
    {
        $leave_hours = 0;

        $query = self::where('user_id' , $user_id);

        if (is_array($type)) {

            $query->whereIn('type_id' , $type);

        } elseif($type != '') {

           $query->where('type_id' , $type);

        }

        if ($start_date != '') {

            $query->where('start_time' , '>=' , $start_date);
            $query->where('end_time' , '<=' , $end_date);

        }

        $LeaveDays = $query->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (!in_array($LeaveDay->Leave->tag_id, $LeaveDay->leave_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = ($leave_hours > $hours);
        return $result;
    }

    public static function checkLeaveByUserIdDateRangeType($user_id,$start_time,$end_time,$type)
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

            if (!in_array($LeaveDay->Leave->tag_id, $LeaveDay->leave_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }


    public static function checkLeaveByUserIdEndTimeType($user_id,$date,$type)
    {
        $leave_hours = 0;

        $query = self::where('user_id' , $user_id);

        if (is_array($type)) {

            $query->whereIn('type_id' , $type);

        } elseif($type != "") {

            $query->where('type_id' , $type);

        }

        $query->where('end_time', 'like' ,$date.'%');

        $LeaveDays = $query->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (!in_array($LeaveDay->Leave->tag_id, $LeaveDay->leave_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }

    public static function checkLeaveByUserIdStartTimeType($user_id,$date,$type)
    {
        $leave_hours = 0;

        $query = self::where('user_id' , $user_id);

        if (is_array($type)) {

            $query->whereIn('type_id' , $type);

        } elseif($type != "") {

            $query->where('type_id' , $type);

        }

        $query->where('start_time', 'like' ,$date.'%');

        $LeaveDays = $query->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (!in_array($LeaveDay->Leave->tag_id, $LeaveDay->leave_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }

    public function Leave()
    {
        $result = $this::hasOne('App\Leave','id','leave_id');
        return $result;
    }
}
