<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\UserTeam;

class User extends Model
{
    //可以傳入數值的欄位
    protected $fillable = [
        'name', 
        'role',
        'status',
        'job_seek',
        'employee_no',
        'nickname',
        'sex',
        'birthday',
        'avatar',
        'enter_date',
        'leave_date',
        'arrive_time',
        'order_by',
        'order_way',
        'pagesize',
    ];

    protected $attributes = [
        'order_by' => 'id',
        'order_way' => 'DESC',
        'pagesize' => '1',
    ];
    /**
     * 搜尋table多個資料
     * 若有多個傳回第一個
     * 使用laravel的links方法產生分頁
     *
     * @param  array   $where     搜尋條件
     * @return 資料object/false
     */
    public function search($where = array())
    {
        $query = self::OrderedBy();
        foreach($where as $key => $value){
            if (isset($value)) {
                if ($key == 'teams') {      
                    $query->whereIn('id', UserTeam::getUserIdByTeamId($value));
                }
                if ($key == 'status') {
                    $query->where($key, $value);
                }
                if ($key == 'keywords') {
                    $query->Where(function ($query1) use ($value) {
                        $query1->orWhere("employee_no", '=', $value)
                               ->orWhere("name", 'like', '%'.$value.'%')
                               ->orWhere("nickname", 'like', '%'.$value.'%');
                    });
                }
            }
        }

        $result =  $query->paginate($this->pagesize);
        return $result;
    }

    public static function getAllUsersExcludeUserId($id){
        $result = self::where('id', '!=' , $id)
        ->get();
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        return $query->orderBy($this->order_by, $this->order_way);
    }

    public static function getAllUsers(){
        $result = self::get();
        return $result;
    }

    public function UserTeam(){
        return $this::hasMany('App\UserTeam','user_id','id');
    }
}
