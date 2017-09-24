<?php

namespace App;

class LeaveRespon extends BaseModel
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

     
    public static function getLeavesIdByUserIdAndTagIdForNotLeave($id, $tag_id)
    {
        if (!is_array($tag_id)) {

            $result = self::where('user_id', $id)->where('tag_id', $tag_id )->get()->pluck('leave_id');

        } else {

            $result = self::where('user_id', $id)->whereIn('tag_id', $tag_id )->get()->pluck('leave_id');

        }
        
        return $result;
    }

    public static function getLeavesIdByUserIdForUpComing($id)
    {
        $result = self::where('user_id', $id)->where('tag_id', '9' )->get()->pluck('leave_id');
        return $result;
    }
}
