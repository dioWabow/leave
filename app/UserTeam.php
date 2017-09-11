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

    public static function getAllUserTeamData()
    {
        $result = self::get();
        return $result;
    }

    public function team()
    {
        $result = $this::hasOne('App\Team','id','team_id');
        return $result;
    }

    public function user()
    {
        $result = $this::hasOne('App\User','id','user_id');
        return $result;
    }
}
