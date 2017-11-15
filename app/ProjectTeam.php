<?php

namespace App;

class ProjectTeam extends BaseModel
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

    public static function getProjectIdByTeamId($team_id)
    {
        $result = self::where('team_id', $team_id)->orWhere('team_id', '0')->get();
        return $result;
    }

    public function fetchTeam()
    {
        $result = self::hasOne('App\Team','id','team_id');
        return $result;
    }

    public function fetchProject()
    {
        $result = self::hasOne('App\Project','id','project_id');
        return $result;
    }
}
