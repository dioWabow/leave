<?php

namespace App;

class AnnualHour extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'user_id',
        'annual_hours',
        'used_annual_hours',
        'remain_annual_hours',
        'create_time',
        'order_by',
        'order_way',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'annuals_hours';

    public function search($where = array())
    {
        $query = self::OrderedBy();

        $columns = array_map('strtolower', Schema::getColumnListing('annuals_hours'));

        foreach($where as $key => $value){

            if (in_array($key, $columns) && !empty($value)) {

                if ($key == 'year' && isset($value)) {

                    $query->whereYear('create_time' , $value);

                }
            }
        }

        $result =  $query->get();
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }

    public static function deleteAnnualHourByUserId($id,$create_time) 
    {
        $result = self::where('user_id', $id)
            ->whereYear('create_time' , $create_time)
            ->delete();
        return $result;
    }
}
