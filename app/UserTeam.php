<?php

namespace App;

class UserTeam extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'users_teams';

    //可以傳入數值的欄位
    protected $fillable = [
        'role',
        'user_id',
        'team_id',
    ];

    public static function getTeamUsersWithoutUserByUserId($id)
    {
      $result = self::where('user_id', '!=' , $id)->groupBy("user_id")->get();
      return $result;
    }

    public static function deleteUserTeamByUserId($id)
    {
        $result = self::where('user_id', $id)->delete();
        return $result;
    }

    public static function checkUserInTeamByUserId($id)
    {
        $result = self::where('user_id', $id)->count();
        return $result;
    }

    public static function getTeamIdByUserId($id)
    {
        $result = self::where('user_id', $id)->get()->pluck('team_id');
        return $result;
    }

    public static function getUserIdByTeamId($id)
    {
        $result = self::where('team_id', $id)->get()->pluck('user_id');
        return $result;
    }

    public static function getUserTeamByUserId($id)
    {
        $result = self::where("user_id", $id)->get();
        return $result;
    }

    public function fetchTeam()
    {
        $result = $this::hasOne('App\Team','id','team_id');
        return $result;
    }

    public static function getManagerTeamByUserId($id)
    {
        $result = self::where('user_id', $id)
            ->where('role', 'manager')
            ->pluck('team_id');
        return $result;
    }

    public static function getUsersIdByTeamsId($id, $user_id)
    {
        $result = self::whereIn('team_id', $id)
            ->where('user_id', '!=', $user_id)
            ->get()
            ->pluck('user_id');
        return $result;
    }

    public function fetchUser()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }

    public static function getTeamIdByUserIdInMiniManagement($id)
    {
        $result = [];
        $empty = true;

        $teams = self::where('user_id', $id)
            ->where('role', 'manager')
            ->get();

        foreach ($teams as $key => $team) {

            if (!empty($team->fetchteam->parent_id)) {

                $result[] = $team->fetchteam;
                $empty = false;

            }

        }

        if ($empty) {

            return false;

        }else{

            return $result;

        }
    }

    public static function getTeamIdByUserIdInManagement($id)
    {
        $result = [];
        $empty = true;

        $teams = self::where('user_id', $id)
            ->where('role', 'manager')
            ->get();

        foreach ($teams as $key => $team) {

            if (empty($team->fetchteam->parent_id)) {

                $result[] = $team->fetchteam;
                $empty = false;

            }

        }

        if ($empty) {

            return false;

        }else{

            return $result;

        }
    }


    public static function getUserByTeams($teams)
    {
        $result = [];

        foreach ($teams as $team) {

            $team_user_role = self::where('team_id', $team->id)
                ->get();

            foreach ($team_user_role as $user) {
               
                if (!in_array($user->user_id, $result)) {

                    $result[] = $user->user_id;

                }

            }

        }

        return $result;
    }

    public static function getUserIdByTeamIdAndRole($team_id,$role) 
    {
        $result = self::where('team_id', $team_id)
            ->where('role' , $role)
            ->get();
        return $result;
    }

    public static function getTeamIdByUserIdAndRole($user_id,$role) 
    {
        $result = self::where('user_id', $user_id)
            ->where('role' , $role)
            ->get();
        return $result;
    }

    public static function getMiniTeamUsers($user_id)
    {

        $result = [];
        
        $teams = self::where('user_id', $user_id)
            ->where('role', 'manager')
            ->get();

        $miniteams = Team::whereIn('parent_id' , $teams->pluck('team_id')->toArray())->get();

        foreach ($miniteams as $miniteam) {

            $team_user_role = self::where('user_id' , '!=' , $user_id)
                ->where('team_id' , $miniteam->id)
                ->get();

            foreach ($team_user_role as $user) {
                    
                if (!in_array($user->user_id, $result)) {

                    $result[] = $user->user_id;

                }

            }
            
        }

        return $result;
    }

    public static function getAllTeamUser()
    {
        $result = self::where("role", 'user')->get();
        return $result;
    }

    public static function getAllTeamManager()
    {
        $result = self::where("role", 'manager')->get();
        return $result;
    }
    
}
