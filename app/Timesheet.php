<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Timesheet extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
    
    public static function getTimeSheetsByUserIdAndPeriod($user_id, $start_date = null, $end_date = null)
    {
        $query = self::where('user_id', $user_id)
                ->whereBetween('working_day' , [$start_date, $end_date])
                ->orderBy('working_day');
        $result = $query->get();

        return $result;
    }

    public function fetchUser()
    {
        return $this->hasOne('user');
    }
    
    public function fetchProject()
    {
        return $this->hasOne('project');
    }
}
