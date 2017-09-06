<?php

namespace App\Http\Controllers;

use App\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function getAllTeam()
    {
    	$model = new Team;

    	$result = $model->getAllTeam();

    	return view('teams', compact(
    		'result'
    	));
    }

    public function ajaxCreateData(Request $request)
    {
    	$model = new Team;

    	// 抓request中所需要的值 name ccolor

    	// rule 判斷資料型態 

    	// fill

    	// 把要吐回的html 做好

    	// save

    	// return view with json 做好的html

    }
}
