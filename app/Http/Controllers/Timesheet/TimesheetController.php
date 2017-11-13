<?php

namespace App\Http\Controllers\Timesheet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimesheetController extends Controller
{
    public function getCalendar()
    {
    	return view('timesheet_claendar');
    }
}
