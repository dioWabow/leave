<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveResponse extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_responses';

    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'user_id',
        'tag_id',
        'memo',
    ];

    public static function getResponseByLeaveId($leave_id)
    {
        $result = self::where('leave_id' , $leave_id)
            ->orderBy('id','DESC')
            ->get();
        return $result;
    }

    public static function getResponseByLeaveIdAndTagId($leave_id , $tag_id)
    {
        $result = self::where('leave_id' , $leave_id)
            ->where('tag_id' , $tag_id)
            ->get();
        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }

    public function fetchTag()
    {
        $result = $this::hasOne('App\Tag','id','tag_id');
        return $result;
    }

    public function fetchLeave()
    {
        $result = $this::hasOne('App\Leave','id','leave_id');
        return $result;
    }
}
