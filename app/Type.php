<?php

namespace App;

use Schema;

class Type extends BaseModel
{

    protected $fillable = [
        'name',
        'reset_time',
        'hours',
        'exception',
        'start_time',
        'end_time',
        'deductions',
        'reason',
        'prove',
        'available',
        'order_by',
        'order_way',
        'pagesize',
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

        $columns = array_map('strtolower', Schema::getColumnListing('types'));

        foreach ($where as $key => $value) {

            if (in_array($key, $columns) && isset($value)) {

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
        $result = self::whereIn('exception', $exception)->remember(0.2)->get();
        return $result;
    }

    public static function getTypeInNaturalDisaster()
    {
        $result = self::where('exception', "natural_disaster")->get();
        return $result;
    }

    public static function checkTypeIdNaturalDisaster($id)
    {
        $result = self::where('exception', "natural_disaster")
            ->where("id",$id)
            ->get();
        return (!empty($result)) ? true : false;
    }

}
