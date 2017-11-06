<?php

namespace App;

use Illuminate\Support\Facades\Schema;

class Timesheet extends BaseModel
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

    /**
     * 搜尋table多個資料 (工作日誌頁搜尋)
     * 若有多個傳回第一個
     *
     * @param  array   $where     搜尋條件
     * @param  int     $page      頁數(1為開始)
     * @param  int     $pagesize  每頁筆數
     * @return 資料object/false
     */
    public function searchForTimeSheetSearch($where = [])
    {
        $query = self::OrderedBy();
        
        foreach ($where as $key => $value) {
            
            if (Schema::hasColumn('timesheets', $key) && !empty($value)) {

                $query->where($key, $value);

            }elseif ($key == "text") {

                    $query->where("items","like","%$value%")
                        ->orWhere("tag","like","%$value%")
                        ->orWhere("description","like","%$value%")
                        ->orWhere("remark","like","%$value%");

            }

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
