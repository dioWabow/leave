<?php

namespace App;

use Illuminate\Support\Facades\Schema;

class TimeSheet extends BaseModel
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

    public static function getTimeSheetById($data)
    {
        $result = self::whereIn('id', $data)->get();
        return $result;
    }

    public function fetchProject()
    {
        $result = $this->hasOne('App\Project', 'id' , 'project_id');
        return $result;
    }
}
