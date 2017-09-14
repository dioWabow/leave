<?php

namespace App\Classes;

use Auth;
use App\Team;
use App\Leave;
use App\UserTeam;
use Carbon\Carbon;
use App\LeaveRespon;

class LeaveHelper
{
    /**
     * 傳入user_id 取得 user的等待核准假單
     * tag 狀態 2,3,4,5
     * 
     */
    public static function getProveLeavesTotal($id)
    {
        $tag_id = [2,3,4,5];
        $result = Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
        return $result;
    }
    /**
     * 傳入user_id 取得 user的即將放假假單
     * tag 狀態 7
     * 
     */
    public static function getUpComingLeavesTotal($id)
    {
        $tag_id = [9];
        $result = Leave::where('user_id', $id)->whereIn('tag_id',$tag_id)->count();
        return $result;
    }
    /**
     * 1. 取得登入者
     * 2. boss tag 4 total leaves
     * 3. manager tag 3 & 主管team下的user total leaves
     * 3. mini_manager tag 2 & 小主管team下的user total leaves
     * 
     */
    public static function getProveManagerLeavesTabLable($role)
    {
        $manager_team_id = UserTeam::getManagerTeamByUserId(Auth::user()->id);
        
        switch ($role) {

            case 'boss':
                return self::getBossLeavesTotal();
                break;

            case 'manager':
                return self::getManagerLeavesTotal($manager_team_id);
                break;

            case 'mini_manager':
                return self::getMiniManagerLeavesTotal($manager_team_id);
                break;
            
            default:
                break;
        }
    }

    private static function getBossLeavesTotal()
    {
        $tag_id = [4];
        $result = Leave::where('tag_id', $tag_id)->count();
        return $result;
    }

    private static function getManagerLeavesTotal($id)
    {
        $team_id = Team::getManagerTeamIdByTeamId($id);
        $teams_id = Team::getIdByParentId($team_id);
        $user_id = UserTeam::getUsersIdByTeamsId($teams_id, Auth::user()->id);
        $tag_id = [3];
                        
        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    private static function getMiniManagerLeavesTotal($id)
    {
        $team_id = Team::getMiniManagerTeamIdByTeamId($id);
        $user_id = UserTeam::getUsersIdByTeamsId($team_id, Auth::user()->id);
        $tag_id = [2];

        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }
    /**
     * 傳入該主管的user_id
     * 找到審核通過的假單
     * tag 狀態 9
     */
    public static function getUpComingManagerLeavesTotal($user_id)
    {
        $tag_id = [9];
        $id = LeaveRespon::getLeaveIdByUserId($user_id);
        $result = Leave::whereIn('id', $id)->whereIn('tag_id',$tag_id)->count();
        return $result;
    }
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDaysLabel($start_time)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($start_time);
        $result = '';

        if ($start_time->gt($today))  {

            $result = '倒數'. $today->diffInDays(Carbon::parse($start_time)) . '天'; 

        } 
       
        return $result;

    }

    public function LeavesHoursTotal($data)
    {
        $result = $data->whereNotIn('tag_id','7')->sum('hours');
        return $result;
    }

}