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

    public static function getTeamIdByKey($key = "")
	{
		$result = self::where("user_id", $key)->pluck('team_id')->first();
		return $result;
	}

    public function Team()
    {
        $result = $this->hasOne('App\Team', 'id', 'team_id');
        return $result;
    }
}
