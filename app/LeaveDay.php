<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_days';

    public static function getAllData()
    {
        $result = self::get();
        return $result;
    }

    public function search($year, $month) {
    	$result = $this->select('leaves.user_id', 'leaves.type_id', 'leaves.tag_id', 'leaves.deductions', 'leaves.hours', 'leaves_days.start_time')
		    ->leftJoin('leaves', 'leaves_days.leave_id', '=', 'leaves.id')
            ->where('leaves.tag_id', '9')
            ->whereYear('leaves_days.start_time', $year)
            ->whereMonth('leaves_days.start_time', $month)
            ->get();

		return $result;
    }
}
