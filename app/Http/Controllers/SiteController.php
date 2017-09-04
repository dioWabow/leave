<?php

namespace App\Http\Controllers;

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

        $return_data = [];

        $model = new Leave;

        $leave_list = $model->leaveDataRange($start_time, $end_time);

        foreach ($leave_list as $key => $value) {
            // 用關聯方式取值
            $user_name = $value->user->nickname;
            $vacation_name = $value->type->name;
            $team_color = $value->userTeam->team->color;

            $return_data[$key]['title'] = addslashes($user_name . ' / ' .  $vacation_name);
            $return_data[$key]['start'] = $value['start_time'];
            $return_data[$key]['end'] = $value['end_time'];
            $return_data[$key]['backgroundColor'] = $team_color;
            $return_data[$key]['borderColor'] = $team_color;

        }

        return json_encode(
            $return_data
        );
    }

}
