<?php

namespace App\Http\Controllers\Sheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Timesheet;
use App\User;
use App\TimesheetPermission;
use Auth;
use Redirect;

class CalendarController extends Controller
{
    public function view(Request $request)
    {
        $chosed_user_id = intval($request->user_id);
        $chosed_user_id = $chosed_user_id ?: Auth::user()->id;

        $timesheetpermissions = TimesheetPermission::getTimeSheetPermissionByUserId(Auth::user()->id);
        
        if ($chosed_user_id != Auth::user()->id && !in_array($chosed_user_id, $timesheetpermissions->pluck('allow_user_id')->toArray())) {

            return Redirect::route('index');

        }

    	return view('timesheet_calendar',compact(
            'chosed_user_id','timesheetpermissions'
        ));
    }

    /**
     * 月報表用的 ajax
     * 1.判斷 getRole 是否有值 有(團隊假單) 無(首頁)
     * 2.有 抓取登入人id 且 判斷 role 為何 再去撈資料
     */
    public function ajaxGetWorkByUserAndMonth(Request $request)
    {
        $start_time = date('Y-m-d', $request['start']);
        $end_time = date('Y-m-d', $request['end']);
        $user_id = $request['id'];

        $timesheets = Timesheet::getTimeSheetsByUserIdAndPeriod($user_id,$start_time,$end_time);

        foreach ($timesheets as $key => $timesheet) {

            $timesheets["$key"]['url'] = route("sheet/daily/edit", [ "id" => $timesheet['id']]);

        }

        return json_encode(
            $timesheets
        );
    }
}
