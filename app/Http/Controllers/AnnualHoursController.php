<?php

namespace App\Http\Controllers;

use App\AnnualHour;
use LeaveHelper;

use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AnnualHoursController extends Controller
{
    public function getView(Request $request)
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

}
