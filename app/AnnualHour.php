<?php

namespace App;

class AnnualHour extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'order_by',
        'order_way',
        'year',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
        'year' => '',
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'annuals_hours';

    public static function search($where = array())
    {
        $query = self::OrderedBy();
        foreach($where as $key => $value){

            if ($key == 'year' && isset($value)) {

                $query->where('created_at', 'like' ,$value. '%');

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
}
