<?php

namespace App;

class LeaveResponse extends BaseModel
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

    public static function getLeavesIdByUserIdAndTagId($id, $tag_id)
    {

        $result = self::where('user_id', $id)->whereIn('tag_id', $tag_id)->get()->pluck('leave_id');
        return $result;
    }
}
