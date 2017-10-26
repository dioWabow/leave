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
    public function getCalendar(Request $request)
    {
        $chosed_user_id = intval($request->user_id);
        $chosed_user_id = $chosed_user_id ?: Auth::user()->id;

        $timesheets = Timesheet::getTimeSheetsByUserIdAndPeriod($chosed_user_id);

        $timesheetpermissions = TimesheetPermission::getTimeSheetPermissionByUserId(Auth::user()->id);
        
        if ($chosed_user_id != Auth::user()->id && !in_array($chosed_user_id, $timesheetpermissions->pluck('allow_user_id')->toArray())) {

            return Redirect::route('index');

        }

    	return view('timesheet_calendar',compact(
            'timesheets','chosed_user_id','timesheetpermissions'
        ));
    }
}
