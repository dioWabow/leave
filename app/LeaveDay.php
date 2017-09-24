<?php

namespace App;

use Carbon\Carbon;

class LeaveDay extends BaseModel
{
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
}
