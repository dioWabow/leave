<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_days';


    public static function getLeavesIdByDateRange($start_time,$end_time)
    {
        $result = self::whereBetween('start_time' , [$start_time, $end_time])
                    ->groupBy('leave_id')
                    ->pluck('leave_id');
        return $result;
    }
}
