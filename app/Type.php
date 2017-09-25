<?php

namespace App;

use Illuminate\Support\Facades\Schema;

class Type extends BaseModel
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
        $query = $this->OrderedBy();
        foreach ($where as $key => $value) {

            if (Schema::hasColumn('types', $key) && !empty($value)) {

                if ($key == 'name') {

                    $query->where('name', 'LIKE', '%'. $value .'%');

                }  else {

                    $query->where($key, $value);
                    
                }

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
    
    public static function getTypeIdByException($exception)
    {
        $result = Type::where('exception', $exception)
                        ->get()
                        ->pluck('id');
        return $result;
    }

    public static function getAllType() 
    {
        $result = self::get();
        return $result;
    }

    public static function getTypeByException($exception)
    {
        $result = self::whereIn('exception', $exception)->get();
        return $result;
    }
}

