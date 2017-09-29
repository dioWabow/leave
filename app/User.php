<?php

namespace App;

use App\UserTeam;

use Schema;

class User extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'employee_no',
        'email',
        'password',
        'token',
        'remember_token',
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
        'status',
        'job_seek',
        'arrive_time',
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
     * 使用laravel的links方法產生分頁
     *
     * @param  array   $where     搜尋條件
     * @return 資料object/false
     */
    public function search($where = array())
    {
        $query = self::OrderedBy();
        foreach($where as $key => $value){
            if(Schema::hasColumn('users', $key) && isset($value)){

                $query->where($key, $value);

            } else {

                if ($key == 'keywords' && isset($value)) {

                    $query->Where(function ($query1) use ($value) {
                        $query1->orWhere('employee_no', $value);
                        $query1->orWhere('name', 'like', '%'.$value.'%');
                        $query1->orWhere('nickname', 'like', '%'.$value.'%');
                    });

                } elseif ($key == 'teams' && isset($value)) {

                    $query->whereIn('id', UserTeam::getUserIdByTeamId($value)->toArray());

                }

            }
        }

        $result =  $query->paginate($this->pagesize);
        return $result;
    }

    public static function getAllUsersExcludeUserId($id)
    {
        $result = self::where('id', '!=' , $id)
            ->where('status' , '1')
            ->get();
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy($this->order_by, $this->order_way);
        return $result;
    }

    public static function getAllUsers()
    {
        $result = self::get();
        return $result;
    }

    public static function getAllUsersWithoutLeaved()
    {
        $result = self::where('status' , '1')->get();
        return $result;
    }

    public static function getUsersById($id)
    {
        $result = self::where('id',$id)->get();
        return $result;
    }

    public function fetchUserTeam()
    {
        $result = $this::hasMany('App\UserTeam','user_id','id');
        return $result;
    }

    /**
     * 搜尋table單個資料
     *
     * @param  array   $where     搜尋條件
     * @return 資料object/false
     */
    public static function getUserByEmail($email='')
    {

        $query = self::where('email', $email);

        $result = $query->first();

        return $result;
    }

    public static function getLeavesUserIdByUserId($user_id) 
    {
        $result = self::where('id', $user_id)->get();
        return $result;
    }

    public static function getJobSeekByUserId($user_id)
    {
        $result = self::where('id',$user_id)->pluck('job_seek');
        return $result;
    }

    public static function getRoleByUserId($user_id)
    {
        $result = self::where('id',$user_id)->pluck('role')->first();
        return $result;
    }

    public static function getUserByEnterMonth($month)
    {
        $result = self::whereMonth('enter_date',$month)->get();
        return $result;
    }

    public static function getUserByRole($role)
    {
        $result = self::where('role',$role)->get();
        return $result;
    }

    public static function getAgentIdByUsers($agent_id)
    {
        $result = self::where('id', $agent_id)->get();
        return $result;
    }
    
    public static function getUserByLeaveYearAndMonth($year,$month)
    {
        $result = self::whereYear('leave_date',$year)
            ->whereMonth('leave_date',$month)
            ->get();
        return $result;
    }

}
