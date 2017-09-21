<?php

namespace App;

class LeaveRespon extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves_respons';
     
    //可以傳入數值的欄位
    protected $fillable = [
        'leave_id',
        'user_id',
        'tag_id',
        'memo',
    ];

     
    public static function getLeaveIdByUserId($id)
    {
        $result = self::where('user_id', $id)->get()->pluck('leave_id');
        return $result;
    }

}
