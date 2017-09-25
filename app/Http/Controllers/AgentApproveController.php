<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveAgent;
use App\LeaveRespon;
use App\Http\Requests\AgentApproveRequest;

use Auth;
use Redirect;
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
    * 新增 & 修改 => leaveResponses & Leave
    *
    * @param Request $request
    * @return Redirect
    */
    public function postInsert(AgentApproveRequest $request)
    {

        if (!empty($request->input('leave'))) {

            $input = $request->input('leave');
            
            if ($input['agree'] == 1) {

                foreach ($input['leave_id'] as $leave_id) {
                    
                    $input_create['tag_id'] = '2';
                    $input_create['user_id'] = Auth::user()->id;
                    $input_create['leave_id'] = $leave_id;
                    $input_create['memo'] = $input['memo'];
                    
                     //新增記錄
                    $leaveRespon = new LeaveRespon;
                    $leaveRespon->fill($input_create);
                    $leaveRespon->save();
                    //修改主單記錄
                    $leave = new Leave;
                    $leave = $this->loadModel($leave_id);
                    $input_update['id'] = $leave_id;
                    $input_update['tag_id'] = '2';
                    $leave->fill($input_update);
                    $leave->save();

                }

            } else {

                foreach ($input['leave_id'] as $leave_id) {
                    
                    $input_create['tag_id'] = '8';
                    $input_create['user_id'] = Auth::user()->id;
                    $input_create['leave_id'] = $leave_id;
                    $input_create['memo'] = $input['memo'];
                      //新增記錄
                    $leaveRespon= new LeaveRespon;
                    $leaveRespon->fill($input_create);
                    $leaveRespon->save();
                     //修改主單記錄
                    $leave = new Leave;
                    $leave = $this->loadModel($leave_id);
                    $input_update['tag_id'] = '8';
                    $input_update['id'] = $leave_id;
                    $leave->fill($input_update);
                    $leave->save();

                }

            }
            
            return Redirect::route('approve/index')->with('success', '批准成功 !');

        }
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
