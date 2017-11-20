<?php

namespace App;

use DB;
Use App\Leave;
Use App\User;
Use App\Type;
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

    /**
     * 不會被計算在放假天數之內的狀態
     *
     * @var array
     */
    protected $leave_cancel_and_refuse_tag_arr = [7,8];

    /**
     * 通過的狀態
     *
     * @var array
     */
    protected $leave_pass_tag_arr = [9];

    /**
     * 待審核的狀態
     *
     * @var array
     */
    protected $leave_in_check = [1,2,3,4,5,6];

    /**
     * 抓取某段時間不包含取消及退回的假單
     *
     * @var array
     */
    public function getLeaveByUserIdDateType($user_id,$start_date,$end_date,$type)
    {
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

        foreach ($LeaveDays as $key => $LeaveDay) {

            if (in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_cancel_and_refuse_tag_arr)) {

                unset($LeaveDays[$key]);

            }

        }

        $result = $LeaveDays;
        return $result;
    }

    /**
     * 抓取某段時間已經通過的假單
     *
     * @var array
     */
    public function getPassLeaveByUserIdDateType($user_id,$start_date,$end_date,$type)
    {
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

        foreach ($LeaveDays as $key => $LeaveDay) {

            if (!in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_pass_tag_arr)) {

                unset($LeaveDays[$key]);

            }

        }

        $result = $LeaveDays;
        return $result;
    }

    /**
     * 抓取某段時間不包含取消及退回的假單的總時數
     *
     * @var array
     */
    public static function getLeaveHoursByUserIdDateType($user_id,$start_date,$end_date,$type)
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

            if (!in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_cancel_and_refuse_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }

        }

        $result = $leave_hours;
        return $result;
    }

    /**
     * 抓取某段時間已經通過的假單的總時數
     *
     * @var array
     */
    public static function getPassLeaveHoursByUserIdDateType($user_id,$start_date,$end_date,$type)
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

        $LeaveDays = $query->remember(0.2)->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_pass_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }

        }

        $result = $leave_hours;
        return $result;
    }

    /**
     * 抓取某段時間待審核的總時數
     *
     * @var array
     */
    public static function getLeaveInCheckHoursByUserIdDateType($user_id,$start_date,$end_date,$type)
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

        $LeaveDays = $query->remember(0.2)->get();

        foreach ($LeaveDays as $LeaveDay) {

            if (in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_in_check)) {

                $leave_hours += $LeaveDay->hours;

            }

        }

        $result = $leave_hours;
        return $result;
    }

    public static function getLeavesIdByDateRangeAndLeavesId($start_time, $end_time, $leave_id)
    {
        $result = self::whereIn('leave_id', $leave_id)
            ->whereBetween('start_time' , [$start_time, $end_time])
            ->groupBy('leave_id')
            ->pluck('leave_id');
        return $result;
    }
    
    public static function getLeavesIdByDate($leave_id, $date)
    {
        $result = self::whereIn('leave_id', $leave_id)
            ->where('start_time', '<' , $date)
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


    public static function getLeaveByUserIdEndTimeType($user_id,$date,$type)
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

            if (!in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_cancel_and_refuse_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }

    public static function getLeaveByUserIdStartTimeType($user_id,$date,$type)
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

            if (!in_array($LeaveDay->fetchLeave->tag_id, $LeaveDay->leave_cancel_and_refuse_tag_arr)) {

                $leave_hours += $LeaveDay->hours;

            }
        }

        $result = $leave_hours;
        return $result;
    }

    public function fetchLeave()
    {
        $result = $this::hasOne('App\Leave','id','leave_id');
        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }

    public function fetchType()
    {
        $result = $this::hasOne('App\Type','id','type_id');
        return $result;
    }

    public static function getAllData()
    {
        $result = self::get();
        return $result;
    }

    public function search($year, $month)
    {
    	$query = $this->select('leaves.user_id', 'leaves.tag_id', 'leaves_days.type_id', 'leaves_days.hours', 'leaves_days.start_time')
		    ->leftJoin('leaves', 'leaves_days.leave_id', '=', 'leaves.id')
            ->where('leaves.tag_id', '9')
            ->whereYear('leaves_days.start_time', $year);

            if ($month != 'year') {
                $query->whereMonth('leaves_days.start_time', $month);
            }

            $result = $query->get();

		return $result;
    }

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

    public static function getNaturalDisasterInDate($type_id,$date)
    {
        $result = self::whereIn('leaves_days.type_id',$type_id)
            ->whereDate("leaves_days.start_time",$date)
            ->where("tag_id","9")
            ->leftJoin("leaves","leaves.id", "=", "leaves_days.leave_id")
            ->leftJoin("users","users.id", "=", "leaves_days.user_id")
            ->select('leaves_days.*')
            ->addSelect('users.*')
            ->addSelect('leaves.*')
            ->addSelect('leaves_days.hours as leave_hours')
            ->get();
        return $result;
    }

    public static function getNotNaturalDisasterInDate($type_id,$date)
    {
        $result = self::whereNotIn('leaves_days.type_id' ,$type_id)
            ->whereDate("leaves_days.start_time",$date)
            ->where("tag_id","9")
            ->leftJoin("leaves","leaves.id", "=", "leaves_days.leave_id")
            ->leftJoin("users","users.id", "=", "leaves_days.user_id")
            ->select('leaves_days.*')
            ->addSelect('users.*')
            ->addSelect('leaves.*')
            ->addSelect('leaves_days.hours as leave_hours')
            ->get();
        return $result;
    }

    public static function getLeaveByLeaveDayId($leave_id)
    {
        $result = self::where('id' ,$leave_id)->get();
        foreach ($result as $key => $value) {
            $result[$key] = $value->fetchLeave;
        }
        return $result->first();
    }

    public static function getLeaveDayByLeaveId($leave_id)
    {
        $result = self::where('leave_id' ,$leave_id)->orderby('start_time')->get();
        return $result;
    }
}
