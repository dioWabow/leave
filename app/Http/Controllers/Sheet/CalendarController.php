<?php

namespace App\Http\Controllers\Sheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Timesheet;
use App\User;
use Auth;
use Redirect;

class CalendarController extends Controller
{
    public function getCalendar(Request $request)
    {
        $user_id = intval($request->user_id);
        $user_id = $user_id ?: Auth::user()->id;
        $timesheet_eloquent = new Timesheet();
        $timesheets = $timesheet_eloquent->fetchByUserIdAndPeriod($user_id);
        if ( $timesheets->isEmpty() && $user_id != Auth::user()->id) {
            return Redirect::route('index');
        }
        $user_eloquent = new User();
        $users = $user_eloquent->getAllUsersExcludeUserId(Auth::user()->id);
    	return view('timesheet_claendar',[
            'timesheets' => $timesheets,
            'this_page_user_id' => $user_id,
            'users' => $users,
        ]);
    }
}
