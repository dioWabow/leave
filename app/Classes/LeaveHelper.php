<?php

namespace App\Classes;

use App\Team;
use App\Leave;
use App\UserTeam;
use App\LeaveRespon;

use Auth;
use Carbon\Carbon;

class LeaveHelper
{
    /**
     * 1. 取得登入者
     * 2. boss tag 4 total leaves
     * 3. manager tag 3 & 主管team下的user total leaves
     * 3. mini_manager tag 2 & 小主管team下的user total leaves
     * 
     */
    public static function getProveManagerLeavesTabLable($role)
    {
        if ($role == 'Admin' && !empty(Auth::hasAdmin())) {

            return self::getAdminLeavesTotal();

        } elseif ($role == 'Manager' && !empty(Auth::hasManagement())) {

            return self::getManagerAllLeavesTotal();

        } elseif ($role == 'Mini_Manager' && !empty(Auth::hasMiniManagement())) {

            return self::getMiniManagerLeavesTotal();

        } 
    }

    /**
     * 取得大BOSS的待審核假單
     * 
     */
    private static function getAdminLeavesTotal()
    {
        $model = new Leave;
        $search['tag_id'] = ['4'];
        $search['hours'] = '24';
        $result = $model->searchForProveInManager($search)->count();
        return $result;
    }

    /**
     * 取得主管子團隊以及所屬團隊的待審核假單總數量
     * 
     */
    private static function getManagerAllLeavesTotal() 
    {
        $result = self::getManagerSubTeamLeavesTotal() + self::getManagerTeamsLeavesTotal();
        return $result;
    }

    /**
     * 取得主管子團隊待審核假單數量
     * 
     */
    private static function getManagerSubTeamLeavesTotal()
    {
        $teams = Auth::hasManagement();
        $teams_id = Team::getTeamsByManagerTeam($teams);
        $user_id = UserTeam::getUserByTeams($teams_id);
        $tag_id = ['3'];
        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    /**
     * 取得主管所屬團隊待審核假單數量
     * 
     */
    private static function getManagerTeamsLeavesTotal()
    {
        $teams = Auth::hasManagement();
        $user_id = UserTeam::getUserByTeams($teams);
        $tag_id = ['2'];
        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    /**
     * 取得小主管所屬團隊下的假單數量
     * 
     */
    private static function getMiniManagerLeavesTotal()
    {
        $teams = Auth::hasMiniManagement();
        $user_id = UserTeam::getUserByTeams($teams);
        $tag_id = ['2'];

        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    /**
     * 取得該
     * 找到審核通過的假單
     * tag 狀態 9
     */
    public static function getUpComingManagerLeavesTotal()
    {
        $search['id'] = LeaveRespon::getLeavesIdByUserIdForUpComing(Auth::user()->id);
        $search['start_time'] = Carbon::now()->format('Y-m-d');

        $model = new Leave;
        $result = $model->searchForUpComingInManager($search)->count();
        return $result;
    }
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDaysLabel($data)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($data);
        $result = '';

        if ($start_time->gte($today))  {

            $result = $today->diffInDays(Carbon::parse($start_time));

        } 
    
        return $result;

    }

    /**
     * 傳入 dataProvider 取得 假單排除狀態 tag 7(取消) 的時數總和
     * 
     */
    public function LeavesHoursTotal($data)
    {
        $result = $data->whereNotIn('tag_id','7')->sum('hours');
        return $result;
    }

}