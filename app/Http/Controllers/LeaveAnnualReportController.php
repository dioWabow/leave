<?php

namespace App\Http\Controllers;

use App\User;
use LeaveHelper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveAnnualReportController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
    */
    public function getIndex(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leave_agent');
            $request->session()->push('leave_agent.search', $search);
            $request->session()->push('leave_agent.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leave_agent')))) {

                $search = $request->session()->get('leave_agent.search.0');
                $order_by = $request->session()->get('leave_agent.order_by.0');

            } else {

                $request->session()->forget('leave_agent');

            }
        }
        // dd(LeaveHelper::calculateAnnualDate());
        $model = new User;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('report-annual-leave', compact(
            'search', 'model', 'dataProvider'
        ));
    }
}
