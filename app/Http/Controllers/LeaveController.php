<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;
use App\Type;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    /**
     * 搜尋
     *
     * @return \Illuminate\Http\Response
     */
    public static function getIndex (Request $request)
    {
        $model = new Leave;
        $userModel = new User;
        $typeModel = new Type;

        $return_data = [];

        $today = date('Y-m-d');

        $first_day = date("Y-m", strtotime('+1 month',strtotime($today)));
        $last_day = date('Y-m-d', strtotime(date('Y-m-01', strtotime($today)) . ' +1 month -1 day'));


        // 處理 上個月 下個月 今天

        $leave_list = $model->testDate($first_day, $last_day);

        foreach ($leave_list as $key => $value) {

            $user_name = $userModel->getUserNameByKey($value['user_id']);
            $vacation_name = $typeModel->getTypeNameByKey($value['type_id']);

            $return_data[$key]['title'] = $user_name . ' / ' . $vacation_name;
            $return_data[$key]['start'] = $value['start_time'];
            $return_data[$key]['end'] = $value['end_time'];
            $return_data[$key]['backgroundColor'] = "#f56954";
            $return_data[$key]['borderColor'] = "#f56954";

        }

        // dd($return_data);

        return view('index', compact(
            'return_data'
        ));
    }

}
