<?php

namespace App;

class Absence extends BaseModel
{
   //可以傳入數值的欄位
    protected $fillable = [
        'user_id',
        'notfill_at',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
    ];


    public function search($where = array())
    {
        $query = self::OrderedBy();

        foreach($where as $key => $value){

            $query->where($key , $value);

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
}
