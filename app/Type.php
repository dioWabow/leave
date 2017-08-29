<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $fillable = [
        'name',
        'reset_time',
        'hours',
        'exception',
        'reason',
        'prove',
        'available',
        'pagesize',
        'order_by',
        'order_way',
        'pagesize',
    ];
    
    
    public $pagesize = 25;
    public $order_by = "id";
    public $order_way = "DESC";

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

        if (count($where) > 0 ) {
            foreach ($where as $key => $val) {
                if (isset($val) && $val != "") {
                    if ($key == 'keywords') {
                        $query->Where(function ($query1) use ($val) {
                            $query1->orWhere('name', 'LIKE', '%'. $val .'%');
                        });
                    } else {
                        $query->where($key, $val);
                    }
                }
            }
        }
        
        if (!empty($this->attributes['pagesize'])) {
            $result =  $query->paginate($this->attributes['pagesize']);
        } else {
            $result =  $query->paginate($this->pagesize);
        }
        
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        if (!empty($this->attributes['order_by']) && !empty($this->attributes['order_way'])) {
            return $query->orderBy($this->attributes['order_by'], $this->attributes['order_way']);
        } else {
            return $query->orderBy($this->order_by, $this->order_way);
        }
    }

}
