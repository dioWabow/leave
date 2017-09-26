<?php

namespace App\Http\Controllers;

use Auth;
use App\UserTeam;
use App\Leave;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * 首頁
     *
     */
    public static function getIndex(Request $request)
    {
        return view('index');
    }

    /**
     * 行事曆用的 ajax
     * 1.判斷 getRole 是否有值 有(團隊假單) 無(首頁)
     * 2.有 抓取登入人id 且 判斷 role 為何 再去撈資料
     * 3.無 抓出全部通過的假單
     * 4.合成要給前台的資料
     */
    public function ajaxGetAllAvailableLeaveListByDateRange(Request $request)
    {
        $getRole = $request['role'];
        $start_time = date('Y-m-d', $request['start']);
        $end_time = date('Y-m-d', $request['end']);

        $result = [];

        if (isset($getRole) && !empty($getRole)) {

            $user_id = Auth::user()->id;

            if ($getRole == 'manager' && !empty(Auth::hasManagement())) {

                $teams = Auth::hasManagement();

            } elseif ($getRole == 'minimanager' && !empty(Auth::hasMiniManagement()) ) {

                $teams = Auth::hasMiniManagement();

            } else {

                return Redirect::route('index')->withErrors(['msg' => '你無權限']);

            }

            $model = new UserTeam;
            $all_member = $model->getUserByTeams($teams);

            $leaveModel = new Leave;
            $leave_list = $leaveModel->leaveManagerDataRange($all_member, $start_time, $end_time);

        } else {

            $model = new Leave;
            $leave_list = $model->leaveDataRange($start_time, $end_time);
        }

        foreach ($leave_list as $key => $value) {
            // 判斷如果有user 被移除的情況
            if ($value->fetchUser != null) {
                // 用關聯方式取值
                $user_name = $value->fetchUser->nickname;
                $vacation_name = $value->fetchType->name;
                if (empty($value->fetchUserTeam->fetchTeam->color)) {

                    $team_color = "#000";

                } else {

                    $team_color = $value->fetchUserTeam->fetchTeam->color;

                }

                $result[$key]['title'] = addslashes($user_name . ' / ' .  $vacation_name);
                $result[$key]['start'] = $value['start_time'];
                $result[$key]['end'] = $value['end_time'];
                $result[$key]['backgroundColor'] = $team_color;
                $result[$key]['borderColor'] = $team_color;

            }
        }

        return json_encode(
            $result
        );
    }

}
