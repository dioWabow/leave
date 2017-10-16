<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RankReportController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {

        return  view('report_rank');
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getView(Request $request)
    {

        return  view('rank_report_form');
    }
}
