<?php

namespace App\Http\Controllers;

use LeaveHelper;
use TimeHelper;
use App\AnnualHour;
use App\LeaveDay;
use App\User;
use App\Type;
use App\Leave;

use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnualHoursController extends Controller
{
    public function getIndex(Request $request)
    {
        if (!Auth::hasAdmin()) {

            return Redirect::route('index')->withErrors(['msg' => '無權限觀看']);

        }

        $search = (!empty($request->input('search'))) ? $request->input('search') : ['year' => Carbon::now()->format('Y')];
        $dataAll = ['annual_hours' => 0 , 'used_annual_hours' => 0  , 'remain_annual_hours' => 0 ];

        $model = New AnnualHour;
        $dataProvider = $model->search($search);

        foreach ( $dataProvider as $data) {

            $dataAll['annual_hours'] += $data->annual_hours;
            $dataAll['used_annual_hours'] += $data->used_annual_hours;
            $dataAll['remain_annual_hours'] += $data->remain_annual_hours;

        }

        return view('calculate_annual_leave',compact(
            'search','model','dataProvider','dataAll'
        ));
    }

    public function getView(Request $request,$id,$year)
    {
        if (!Auth::hasAdmin()) {

            return Redirect::route('index')->withErrors(['msg' => '無權限觀看']);

        }

        $user = $this->loadUser($id);

        $leaveday = New LeaveDay;
        $start_time = TimeHelper::changeDateValue($year,['-,1,year'],'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');
        $end_time = $year . TimeHelper::changeDateValue($user->enter_date,['-,1,day'],'-m-d');

        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        $leave_arr = [];

        foreach ($leaveday->getPassLeaveByUserIdDateType($id,$start_time,$end_time,$leave_type_arr) as $leave_day) {

            $leave_arr[] = $leave_day->leave_id;

        }

        $dataProvider = Leave::getLeaveByIdArr($leave_arr);

        return view('annual_leave_form',compact(
            'id','year','dataProvider'
        ));
    }

    private function loadUser($id)
    {
        $model = User::find($id);
        if ($model===false) {
            throw new CHttpException(404,'資料不存在');
        }

        return $model;
    }

}
