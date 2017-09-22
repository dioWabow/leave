<?php

namespace App;

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
        'create_user_id',
        'order_by',
        'order_way',
        'pagesize',
	    'agent',
        'notice_person',
        'timepicker',
        'dayrange',
    ];

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

    public function User()
    {
        $result = $this->hasOne('App\User', 'id' , 'user_id');
        return $result;
    }

    public function Type()
    {
        $result = $this->hasOne('App\Type', 'id', 'type_id');
        return $result;
    }

    public function UserTeam()
    {
        $result = $this->hasOne('App\UserTeam', 'user_id', 'user_id');
        return $result;
    }
}
