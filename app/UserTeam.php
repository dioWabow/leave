<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'users_teams';

    public static function getTeamIdByUserId($id)
    {
        $result = self::where('user_id', $id)->get()->pluck('team_id');
        return $result;
    }

    public function team()
    {
        $result = $this::hasOne('App\Team','id','team_id');
        return $result;
    }
}
