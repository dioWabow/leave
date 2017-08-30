<?php

namespace App\Http\Controllers;

use App\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveController extends Controller
{
    /**
     * 搜尋
     *
     * @return \Illuminate\Http\Response
     */
    public static function getIndex ()
    {
    	//title: 'All Day Event',
        //start: new Date(y, m, 1),
        //backgroundColor: "#f56954",
        //borderColor: "#f56954"

        $model = new Leave;

        $leave_list = $model->testDate();

        $return_data = array();
        foreach ($leave_list as $key => $value) {

            $return_data[$key]['title'] = $value['user_id'] . ' / ' .$value['reson'];
            $return_data[$key]['start'] = $value['start_time'];
            $return_data[$key]['backgroundColor'] = "#f56954";
            $return_date[$key]['borderColor'] = "#f56954";

        }

        dd($return_date);

        return view('index', compact(
            'return_date'
        ));
    }

}
