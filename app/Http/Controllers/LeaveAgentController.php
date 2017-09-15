<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveAgent;

use Auth;
use Schema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaveAgentController extends Controller
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

        // 先取得該登入者所代理的假單
        $search['id'] = LeaveAgent::getLeaveIdByUserId(Auth::user()->id);

        $model = new Leave;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_agent', compact(
            'search', 'model', 'dataProvider'
        ));
    }


}
