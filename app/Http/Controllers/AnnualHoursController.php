<?php

namespace App\Http\Controllers;

use App\AnnualHour;

use Redirect;
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

        $dataProvider = AnnualHour::search();
        return view('calculate_annual_leave',compact(
            'dataProvider'
        ));
    }

}
