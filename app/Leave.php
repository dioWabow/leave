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

    public function userVacationList($user_id, $type_id, $year, $month)
    {
        $query = $this->where('user_id', $user_id)
            ->where('type_id', $type_id)
            ->where('tag_id', '9')
            ->whereYear('start_time', $year);

            if ($month != 'year') {
                $query->whereMonth('start_time', $month);
                $query->whereMonth('end_time', $month);
            }

        $result = $query->paginate(10);
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

    public static function getLeaveByIdArr($id)
    {
        $result = self::whereIn('id', $id)->get();
        return $result;
    }
}
