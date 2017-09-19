<?php

namespace App\Http\Controllers;

use WebHelper;
use LeaveHelper;
use App\Leave;

use Auth;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesMyController extends Controller
{
   /**
     * 列表-等待核准 Prvoe tag 1,2,3,4
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);
            $search['tag_id'] = [1,2,3,4];

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');

            } else {

                $search['tag_id'] = [1,2,3,4];
                $request->session()->forget('leaves_my');

            }
        }

        $model = new Leave;
        $search['user_id'] = $user_id;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_my', compact(
            'search', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming tag 9
     *
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);
            $search['tag_id'] = [9];

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');

            } else {

                $search['tag_id'] = [9];
                $request->session()->forget('leaves_my');
                
            }
        }

        $model = new Leave;
        $search['user_id'] = $user_id;
        // 取得即將放假的假單
        $search['id'] = $model->getUpComingLeavesIdByToday(Carbon::now());
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_my', compact(
            'search', 'model', 'dataProvider'
        ));
    }

    /**
     * 列表-歷史紀錄 History tag 7,8,9 放完的假、取消的假單、未核准假單
     *
     * @return \Illuminate\Http\Response
    */
    public function getHistory(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
       
        if (!empty($search) || !empty($order_by)) {

            //有搜尋和取得order_by時，先移除session 再將 seach order 加入session 
            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);

        } else {

            // 沒有搜尋，判斷有沒有page 和 session 是不是空的
            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                //有分頁時，將session 的資料塞給$search
                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');
               
            } else {
                //沒有搜尋也分頁page時，移除session，走固定tag_id
                $search['tag_id'] = [7,8,9];
                $request->session()->forget('leaves_my');
                
            }
           
        }
        
        if (!empty($search['daterange'])) {

            $daterange = explode(" - ", $search['daterange']);
            $search['start_time'] = $daterange[0];
            $search['end_time'] = $daterange[1];
            
            $order_by['start_time'] = $daterange[0];
            $order_by['end_time'] = $daterange[1];
              
        }

        $model = new Leave;
        $search['user_id'] = $user_id;
        //傳值近來是exception，先去找該exception的id，再搜尋假單是否有該type_id
        if (!empty($search['type_id'])) {
            
            $order_by['exception'] = $search['type_id'];
            $search['type_id'] = $model->getTypeIdByException($search['type_id']);
            
            
        } else {

            $search['type_id'] = [];

        }
        // 取得已放完假的假單
        $search['id'] = $model->getfinishedLeavesIdByToday(Carbon::now());
        $dataProvider = $model->fill($order_by)->search($search);
        $leaves_totle_hours = LeaveHelper::getLeavesHoursTotal($dataProvider);

        return  view('leave_my', compact(
            'dataProvider', 'search', 'model', 'leaves_totle_hours'
        ));
    }

    /**
     * 刪除 - 在等待核准 職代2 和 小主管3 狀態 顯示刪除按鈕(前台)
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {
        $model = $this->loadModel($id)->delete();
        // 代 user_id 回到 leaves 頁面
        return Redirect::route('leaves/my/prove', [ 'user_id' => Auth::user()->id  ])->withErrors(['msg' => '刪除完畢。']);
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        return  view('leave_view');
    }

    
    private function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;

    }
}