<?php

namespace App;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'type_id',
        'tag_id',
        'start_time',
        'end_time',
        'hours',
        'reason',
        'prove',
        'creat_user_id',
        'order_by',
        'order_way',
        'pagesize',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
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
        
        $query = $this->OrderedBy()->getLeavesByUserId()->getStaticByTagId();
        
        foreach ($where as $key => $value) {

            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                    $query->where($key, $value);
                    
                }

            }

        if (!empty($where['start_time']) && !empty($where['end_time'])) {

            $query->whereBetween('start_time', [$where['start_time'], $where['end_time']]);

        }
        
        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    public function scopegetLeavesByUserId($query)
    {
        $result = $query->where('user_id', $this->user_id);
        return $result;
    }
 
    public function scopegetStaticByTagId($query)
    {
        $result = $query->whereIn('tag_id',$this->tag_id);
        return $result;
    }

}
