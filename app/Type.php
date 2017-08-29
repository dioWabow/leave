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
        'start_time',
        'end_time',
        'reason',
        'prove',
        'available',
    ];
    
    protected $attributes = [
        'order_by' => "id",
        'order_way' => "DESC",
        'pagesize' => '2',
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
    public function search( $where = [] )
    {
        
        $query = $this->OrderedBy();

        if (count($where) > 0 ) {
            foreach ($where as $key => $val) {
                if (isset($val) && $val != "") {
                    if ($key == 'keywords') {
                        $query->orWhere('name', 'LIKE', '%'. $val .'%');
                    } else {
                        $query->where($key, $val);
                    }
                }
            }
        }
       
        $result =  $query->paginate($this->pagesize);
        
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        return $query->orderBy($this->order_by, $this->order_way);
    }

}
