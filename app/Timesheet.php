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
    
    public function user()
    {
        return $this->hasOne('user');
    }
    
    public function project()
    {
        return $this->hasOne('project');
    }
    
    public function fetchByUserIdAndPeriod($user_id, $start_date = null, $end_date = null)
    {
        $start_date = $start_date ?: Carbon::create()->subMonths(2)->firstOfMonth()->toDateString();
        $end_date = $end_date ?: Carbon::create()->addMonths(2)->lastOfMonth()->toDateString();
        return self::where('user_id', $user_id)
                ->whereBetween('working_day' , [$start_date, $end_date])
                ->orderBy('working_day')
                ->get();
    }
}
