<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    protected $fillable = [
        'team_id',
        'project_id',
    ];

    public static function getProjectTeamByProjectId($project_id)
    {
        $result = self::where('project_id', $project_id)->get();
        return $result;
    }

    public static function deleteProjectTeamByProjectId($project_id)
    {
        $result = self::where('project_id', $project_id)->delete();
        return $result;
    }

    public function fetchTeam()
    {
        $result = self::hasOne('App\Team','id','team_id');
        return $result;
    }
}
