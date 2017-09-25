<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    public static function getAllTeam() 
    {
        $result = self::get();
        return $result;
    }
    
    public static function getColorByKey($key = "")
    {
    	$result = self::where("id", $key)->pluck('color')->first();
    	return $result;
    }

    public static function getMiniTeamUser($id)
    {
        $result = self::where('parent_id',$id)->get();
        return $result;
    }

    public static function getTeamUser($user_id)
    {
        $teams = UserTeam::getManagerTeam($user_id);

        foreach ($teams as $team) {

            foreach(Team::getMiniTeam($team->team_id) as $miniteam) {

                $teams[] = $miniteam;

            }

        }

        $result = self::where('parent_id',$id)->get();
        return $result;
    }
}
