<?php

namespace App\Http\Controllers;

use App\Leave;
use App\Type;
use App\Http\Requests\LeaveTypeRequest;

use Redirect;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;

class LeaveTypeController extends Controller
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

            $request->session()->forget('leave_type');
            $request->session()->push('leave_type.search', $search);
            $request->session()->push('leave_type.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leave_type')))) {

                $search = $request->session()->get('leave_type.search.0');
                $order_by = $request->session()->get('leave_type.order_by.0');

            } else {

                $request->session()->forget('leave_type');

            }
        }

        $model = new Type;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_type', compact(
            'search', 'model', 'dataProvider'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request)
    {

        $model = new Type;
        
        $input = $this->checkDataValue($request->old('leave_type'));
        $model->fill($input);

        return  view('leave_type_form', compact(
            'model'
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
        
        $input = $this->checkDataValue($request->old('leave_type'));
        
        $model->fill($input);

        return  view('leave_type_form', compact(
            'model'
        ));
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {
        $model = $this->loadModel($id)->delete();

        return Redirect::route('leave_type')->with('success', '刪除完畢。');
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public function postInsert(LeaveTypeRequest $request)
    {
        $input = $this->checkDataValue($request->input('leave_type'));

        //儲存資料
        $model = new Type;
        $model->fill($input);

        if ($model->save()) {

            return Redirect::route('leave_type')->with('success', '新增成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

        }
    }

    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */
    public function postUpdate(LeaveTypeRequest $request)
    {
        $input = $this->checkDataValue($request->input('leave_type'));

        //更新資料
        $model = new Type;
        $model = $this->loadModel($input['id']);
        $model->fill($input);

        if ($model->save()) {

            return Redirect::route('leave_type')->with('success', '更新成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }

    /**
     * 假別列表CheckBox更新 Ajax
     *
     * @param Request $request
     * @return Redirect
     */
    public function ajaxUpdateData(Request $request)
    {
        $id = $request['id'];
        $deductions = $request['deductions'];
        $reason = $request['reason'];
        $prove = $request['prove'];
        $available = $request['available'];
        $types = ['deductions' => $deductions,'reason' => $reason, 'prove' => $prove, 'available' => $available ];

        $model = new Type;

        $model = $this->loadModel($id);

        $model->fill($types);

        if ($model->save()) {

            $result = true;

            return json_encode(
                array(
                    'result' => $result,
                    'id' => $id
                )
            );

        } else {

            $result = false;
            return json_encode(
                array(
                    'result' => $result
                )
            );

        }
    }
    
    private function loadModel($id)
    {
        $model = Type::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;
    }

    

    private function checkDataValue($data)
    {
        $input = $data;

        // 日期區間用-分別存入
        if (!empty($input['available_date'])) {
            $available_date = explode(" - ", $input['available_date']);
            $input['start_time'] = isset($available_date[0]) ? $available_date[0]:'';
            $input['end_time'] = isset($available_date[1]) ? $available_date[1]:'';
        }
        // reason prove available 判斷 0 或 1 後存入 
        $input['deductions']  = empty($input['deductions']) || $input['deductions'] != 'on' ? 0 : 1 ;
        $input['reason']  = empty($input['reason']) || $input['reason'] != 'on' ? 0 : 1 ;
        $input['prove']  = empty($input['prove']) || $input['prove'] != 'on' ? 0 : 1 ;
        $input['available']  = empty($input['available']) || $input['available'] != 'on' ? 0 : 1 ;

        return $input;
    }

}
