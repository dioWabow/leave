<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTeams extends BaseModel
{
    public static function getProjectByArrayTeamId($teams = [])
    {
        if ( is_string($teams) ){

            $teams = [$teams];

        }

        $result = [];

        $result = self::whereIn( "team_id" , $teams )
            ->groupBy("project_id")
            ->get();

        return $result;
    }
 
    public function fetchProject()
    {
        $result = $this->hasOne('App\Project', 'id' , 'project_id');
        return $result;
    }
}
