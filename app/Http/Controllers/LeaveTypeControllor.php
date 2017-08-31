<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Config;
use Session;
use App\Type;


use Redirect;
use Illuminate\Support\Facades\Input;


use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Requests\LeaveTypeRequest;
use App\Http\Controllers\Controller;


class LeaveTypeControllor extends Controller
{
    public function _contstruct() {
        
    }

    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
    */
    
    public function getIndex(Request $request)
    {
        
        $model = new Type();
        $order_by = $model->order_by;
        $order_way = $model->order_way;

        // 是否有取得每頁幾筆資訊
        if(!empty($request->input('pageSize'))) {
            $pageSize = $request->input('pageSize');
        } else {
            $pageSize = $model->pagesize;
        }

        $search = $request->input('search');
        if (!empty($search)) {

            $types_list = $model->search( $search );
                        
        } else {
            
            // 取得全部假別資訊 分頁
            $types_list = $model->get();
            $types_list = $model->orderBy($model->order_by, $model->order_way)
                        ->paginate($pageSize)
                        ->appends(['pageSize' => $pageSize]);
                        
        }

        $view =  view('leave_type', compact('types_list', 'pageSize' , 'search', 'order_by', 'order_way'));
        return $view;
    }


    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
     public function getCreate()
    {
        $model = new Type();
        $viewinfo = '';

        $view = view('leave_type_form', compact('model','viewinfo'));

        return  $view;
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
     public function getView(Request $request, $id = "")
    {

        $viewinfo = $this->loadModel($id);
        
        $view = view('leave_type_form', compact('viewinfo'));

        return  $view;
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
     public function postDelete(Request $request, $id = "")
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

        $leave_type = $request->input('leave_type');

        $leave_type['reason']  = empty($leave_type['reason']) || $leave_type['reason'] != 'on' ? 0 : 1 ;
        $leave_type['prove']  = empty($leave_type['prove']) || $leave_type['prove'] != 'on' ? 0 : 1 ;
        $leave_type['available']  = empty($leave_type['available']) || $leave_type['available'] != 'on' ? 0 : 1 ;
        
        //儲存資料
        $model = new Type();
        $model->fill($leave_type);

        if($model->save()) {
            return Redirect::to(route('leave_type'))->withErrors(['msg' => '新增成功']);
        }else{
            return Redirect::to(route('add'))->withErrors(['msg' => '新增失敗']);
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
        $leave_type = $request->input('leave_type');

        $leave_type['reason']  = empty($leave_type['reason']) || $leave_type['reason'] != 'on' ? 0 : 1 ;
        $leave_type['prove']  = empty($leave_type['prove']) || $leave_type['prove'] != 'on' ? 0 : 1 ;
        $leave_type['available']  = empty($leave_type['available']) || $leave_type['available'] != 'on' ? 0 : 1 ;

        //儲存資料
        $model = new Type();
        $model = $this->loadModel($leave_type['id']);
        $model->fill($leave_type);
        
        if($model->save()) {
            return Redirect::to(route('leave_type_form', [ 'id' => $leave_type['id'] ]))->withErrors(['msg' => '更新成功']);
        }else{
            return Redirect::to(route('leave_type_form', [ 'id' => $leave_type['id']] ))->withErrors(['msg' => '更新失敗']);
        }
    }


    private function loadModel($id) {

        $model = Type::find($id);

        if($model===false)
            throw new CHttpException(404,'資料不存在');
        return $model;
    }

    function getArticleSortLinks($sortField) {
        $model = new Type();
        $resule = $query->orderBy($sortField, 'DESC');
        $view =  view('leave_type', compact('resule'));
        return $view;
    }
}


