<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveAgent;

use Auth;
use Carbon\Carbon;
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
        
        $model = new Leave;
        // 先取得該登入者所代理的假單
        $search['id'] = LeaveAgent::getLeaveByUserId(Auth::user()->id)->pluck('leave_id');
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        $search['tag_id'] = '9';
        $dataProvider = $model->fill($order_by)->searchForLeaveAgent($search);
        
        return  view('leave_agent', compact(
            'search', 'model', 'dataProvider'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        return  view('leave_agent_finish_view');
    }

    /**
     * 找id
     *
     * @return \Illuminate\Http\Response
     */
    private static function loadModel($id)
    {
        $model = Leave::where('id',$id)->remember(0.2)->get()->first();

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
        return $model;
    }
}
