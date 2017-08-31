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
        'order_way'
    ];
    
    
    public $pagesize = 5;
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
    public function search($where = []) {
        
        $query = $this->OrderedBy($this->order_by, $this->order_way);

        foreach ($where as $key => $val) {
            
            if ($key == 'reset_time' || $key == 'exception' || $key == 'available') {

                if($val!="all"){
                    $query->orwhere($key, '=', $val);
                }

            }elseif ($key == 'keywords') {

                $query->where('name', 'LIKE', '%'. $val .'%');

            }
        }

        $result = $query->paginate($this->pagesize)->appends(['pageSize' => $this->pagesize]);
        
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        return $query->orderBy($this->order_by, $this->order_way);
    }

}
