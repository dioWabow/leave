<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveAgent;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentApproveController extends Controller
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
        //取得假單在送出的狀態(代理人待核)
        $search['tag_id'] = ['1'];
        $model = new Leave;
        $dataProvider = $model->fill($order_by)->searchForAgentApprove($search);

        return  view('leave_agent_prove', compact(
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
        $model = $this->loadModel($id);

        return  view('leave_agent_view', compact(
            'model'
        ));
    }

    /**
     * 找id
     *
     * @return \Illuminate\Http\Response
     */
    private static function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;
    }
}
