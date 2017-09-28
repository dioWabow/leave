<?php

namespace App\Http\Controllers;

use LeaveHelper;
use TimeHelper;
use App\User;
use App\Type;
use App\Leave;
use App\LeaveDay;
use App\AnnualYear;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AnnualReportController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
    */
    public function getIndex(Request $request)
    {
        $search = (!empty($request->input('search'))) ? $request->input('search') : ['year' => Carbon::now()->format('Y')];
        $dataAll = ['annual_this_years' => 0 ,'annual_next_years' => 0 , 'used_annual_hours' => 0  , 'remain_annual_hours' => 0 ];
        
        $model = new AnnualYear;
        $dataProvider = $model->search($search);
        foreach ( $dataProvider as $data) {
            
                $dataAll['annual_this_years'] += $data->annual_this_years;
                $dataAll['annual_next_years'] += $data->annual_next_years;
                $dataAll['used_annual_hours'] += $data->used_annual_hours;
                $dataAll['remain_annual_hours'] += $data->remain_annual_hours;
                
        }

        return  view('report-annual-leave', compact(
            'search', 'model', 'dataProvider', 'dataAll'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getView(Request $request, $id, $year)
    {
        $user = $this->loadUser($id);

        $model = New LeaveDay;
        $now_year = Carbon::now()->format('Y');
        $start_year = Carbon::create($now_year, 1, 1)->format('Y-m-d');
        $end_year = Carbon::create($now_year, 12, 31)->format('Y-m-d');
        
        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        $leave_arr = [];

        foreach ($model->getPassLeaveByUserIdDateType($id,$start_year,$end_year,$leave_type_arr) as $leave_day) {

            $leave_arr[] = $leave_day->leave_id;

        }

        $dataProvider = Leave::getLeaveByIdArr($leave_arr);
        
        return view('annual_report_form',compact(
            'id','year','model','dataProvider'
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
