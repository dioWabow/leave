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

    public function absenceReportSearch($year, $month)
    {
        $query = $this->select('user_id')->whereYear('notfill_at', $year);

            if ($month != 'year') {
                $query->whereMonth('notfill_at', $month);
            }

            $result = $query->distinct('user_id')->get();

        return $result;
    }

    public function countUserId($user_id)
    {
        $query = $this->where('user_id', $user_id);

        $result = $query->count();

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
