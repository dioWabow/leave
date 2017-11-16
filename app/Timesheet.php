<?php

namespace App;

use Illuminate\Support\Facades\Schema;

class Timesheet extends BaseModel
{
    /**
    * 與Model關聯的table
    *
    * @var string
    */
    protected $table = 'timesheets';

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
    ];

    protected $attributes = [
        'order_by' => "id",
        'order_way' => "DESC",
        'pagesize' => '25',
    ];

    /**
     * 搜尋table多個資料
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
    public function search($where = [])
    {
        $query = $this->OrderedBy();
        foreach ($where as $key => $value) {

            if (Schema::hasColumn('timesheets', $key) && isset($value)) {

                $query->where($key, $value);

            }

        }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    public static function getTimesheetById($data)
    {
        $result = self::whereIn('id', $data)->get();
        return $result;
    }

    public static function getTimesheetsByUserIdAndPeriod($user_id, $start_date = null, $end_date = null)
    {
        $query = self::where('user_id', $user_id)
                ->whereBetween('working_day' , [$start_date, $end_date])
                ->orderBy('working_day');
        $result = $query->get();

        return $result;
    }

    public function searchForTimesheetSearch($where = [],$allow_users_id)
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

    public static function getTimesheetUserIdByNotLeavedUserId($user_id, $date)
    {
        $result = self::where('user_id', $user_id)->where('working_day', $date)->sum('hour');
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
}
