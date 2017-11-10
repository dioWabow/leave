<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class Timesheet extends Model
{
    protected $fillable = [
        'project_id',
        'tag',
        'user_id',
        'items',
        'description',
        'hour',
        'working_day',
        'url',
        'remark',
        'pagesize',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
        'pagesize' => '25',
        'start_time' => '',
        'end_time' => '',
        'exception' => '',
    ];
    
    public static function getTimeSheetsByUserIdAndPeriod($user_id, $start_date = null, $end_date = null)
    {
        $query = self::where('user_id', $user_id)
                ->whereBetween('working_day' , [$start_date, $end_date])
                ->orderBy('working_day');
        $result = $query->get();

        return $result;
    }

    public function searchForTimeSheetSearch($where = [],$allow_users_id)
    {
        $query = self::OrderedBy();
        foreach ($where as $key => $value) {
            
            if (Schema::hasColumn('timesheets', $key) && !empty($value)) {

                $query->where($key, $value);

            }elseif ($key == "text") {

                    $query->where(function ($query) use ($value) {
                        $query->where("items","like","%$value%")
                            ->orWhere("tag","like","%$value%")
                            ->orWhere("description","like","%$value%")
                            ->orWhere("remark","like","%$value%");
                    });


            }

        }

        if (empty($where["user_id"])) {

            $query->whereIn("user_id",$allow_users_id);

        }


        if (!empty($where['start_time']) && !empty($where['end_time'])) {

            $query->whereBetween('working_day', [$where['start_time'], $where['end_time']]);

        }
        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function fetchUser()
    {
        $result = $this->hasOne('App\User', 'id' , 'user_id');
        return $result;
    }
 
    public function fetchProject()
    {
        $result = $this->hasOne('App\Project', 'id' , 'project_id');
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }
}
