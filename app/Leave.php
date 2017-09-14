<?php

namespace App;

use Schema;

class Leave extends BaseModel
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
        'start_time' => '',
        'end_time' => ''
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
        $query = self::OrderedBy();
        foreach ($where as $key => $value) {
            
            if (Schema::hasColumn('leaves', $key) && !empty($value)) {

                if ($key == 'tag_id') {
                    
                    if (!is_array($value)){
                        //如果傳近來不是array,先將字串分割再搜尋條件(搜尋全部時)
                        $value = explode(',',$value);

                    }

                    $query->whereIn('tag_id', $value);

                } elseif ($key == 'id' && is_array($value)) {

                    $query->whereIn('id', $value);

                } elseif ($key == 'user_id') {

                    $query->whereIn('user_id', $value);
                    
                } elseif ($key == 'start_time') {

                    $query->where('start_time', '>' , $value);
                    
                } elseif ($key == 'end_time') {

                    $query->where('end_time', '<' , $value);

                } else {

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

    public static function getTypeIdByLeaves($id) 
    {
        $result = self::where('type_id', $id)->get();
        return $result;
    }

    public function leaveDataRange($first_day, $last_day)
    {
        $result = $this->whereBetween('start_time', [$first_day, $last_day])->get();
    	return $result;
    }

    public function fetchUser()
    {
        $result = $this->hasOne('App\User', 'id' , 'user_id');
        return $result;
    }

    public function fetchType()
    {
        $result = $this->hasOne('App\Type', 'id', 'type_id');
        return $result;
    }

    public function fetchUserTeam()
    {
        $result = $this->hasOne('App\UserTeam', 'user_id', 'user_id');
        return $result;
    }
}
