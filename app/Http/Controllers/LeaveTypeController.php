<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Type;

use Redirect;
use Illuminate\Support\Facades\Input;

use Illuminate\Http\Request;
use App\Http\Requests\LeaveTypeRequest;
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

        $model->fill($order_by);
        
        $dataProvider = $model->search($search);

        return  view('leave_type', compact(
            'dataProvider', 'search', 'model'
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

        $input = $request->old('leave_type');

        if ($input) {
            
            $input['reason']  = empty($input['reason']) || $input['reason'] != 'on' ? 0 : 1;
            $input['prove']  = empty($input['prove']) || $input['prove'] != 'on' ? 0 : 1;
            $input['available']  = empty($input['available']) || $input['available'] != 'on' ? 0 : 1;
            $model->fill($input);

        }

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
        
        $input = $request->old('leave_type');

        if ($input) {
            
            $input['reason']  = empty($input['reason']) || $input['reason'] != 'on' ? 0 : 1;
            $input['prove']  = empty($input['prove']) || $input['prove'] != 'on' ? 0 : 1;
            $input['available']  = empty($input['available']) || $input['available'] != 'on' ? 0 : 1;
            $model->fill($input);

        }
        
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
        
        return Redirect::to(route('leave_type'))->withErrors(['msg'=>'刪除完畢。']);
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
     public function postInsert(LeaveTypeRequest $request)
     {

        $input = $request->input('leave_type');

        $input['reason']  = empty($input['reason']) || $input['reason'] != 'on' ? 0 : 1 ;
        $input['prove']  = empty($input['prove']) || $input['prove'] != 'on' ? 0 : 1 ;
        $input['available']  = empty($input['available']) || $input['available'] != 'on' ? 0 : 1 ;

        //儲存資料
        $model = new Type;
        $model->fill($input);

        if ($model->saveOriginalOnly()) {
            return Redirect::to(route('leave_type'))->withErrors(['msg' => '新增成功']);
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
        
        $input = $request->input('leave_type');
        
        $input['reason']  = empty($input['reason']) || $input['reason'] != 'on' ? 0 : 1;
        $input['prove']  = empty($input['prove']) || $input['prove'] != 'on' ? 0 : 1;
        $input['available']  = empty($input['available']) || $input['available'] != 'on' ? 0 : 1;

        //更新資料
        $model = new Type;
        $model = $this->loadModel($input['id']);
        $model->fill($input);
        
        if ($model->save()) {
            return Redirect::to(route('leave_type_edit', [ 'id' => $input['id']]))->withErrors(['msg' => '更新成功']);
        } else {
            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);;
        }
    }


    private function loadModel($id)
    {
        $model = Type::find($id);

        if ($model===false)
            throw new CHttpException(404,'資料不存在');
        return $model;
    }
}
