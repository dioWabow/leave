<?php

namespace App;

class Absences extends BaseModel
{
    public function search($year, $month)
    {
        $query = $this->select('user_id')->whereYear('notfill_at', $year);

            if ($month != 'year') {
                $query->whereMonth('notfill_at', $month);
            }

            $result = $query->distinct('user_id')->get();

        return $result;
    }

    public function countUserId($user_id)
    {
        $query = $this->where('user_id', $user_id);

        $result = $query->count();

        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }
}
