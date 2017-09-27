<?php

namespace App;


class LeaveNotice extends BaseModel
{
    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'user_id',
        'send_time',
    ];

    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_notices';

    public static function getNoticeByLeaveId($leave_id)
    {
        $result = self::where('leave_id',$leave_id)->get();
        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }
}
