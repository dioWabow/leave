<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Leave;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    /**
     * 搜尋
     *
     * @return \Illuminate\Http\Response
     */
    public static function getIndex(Request $request)
    {
        return view('index');
    }

    public function ajaxGetAllAvailableLeaveListByDateRange(Request $request)
    {
        $start_time = date('Y-m-d', $request['start']);
        $end_time = date('Y-m-d', $request['end']);

        $start_time = date('Y-m-d', strtotime("$end_time -2 month"));
        $end_time = date('Y-m-d', strtotime("$end_time +2 month"));

        $result = [];

        $model = new Leave;

        // 撈出全部假單
        $leave_list = $model->leaveDataRange($start_time, $end_time);

        foreach ($leave_list as $key => $value) {
            // 判斷如果有user 被移除的情況
            if ($value->user != null) {
                // 用關聯方式取值
                $user_name = $value->user->nickname;
                $vacation_name = $value->type->name;
                $team_color = $value->userTeam->team->color;

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
