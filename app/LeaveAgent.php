<?php

namespace App;

use Schema;

class LeaveAgent extends BaseModel
{
    protected $table = 'leaves_agents';

    protected $fillable = [
        'leave_id',
        'agent_id',
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
        $query = self::OrderedBy();

        foreach ($where as $key => $value) {

            if (Schema::hasColumn('leaves_agents', $key)  && !empty($value)) {

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

    public function fetchLeave()
    {
        $result = $this->hasOne('App\Leave', 'id' , 'leave_id');
        return $result;
    }

    public static function getLeaveIdByUserId($id) {
        
        $result = self::where('agent_id', $id)->get()->pluck('leave_id');
        return $result;     
    }
}
