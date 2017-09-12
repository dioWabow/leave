<?php

namespace App\Http\Controllers;

use App\Leave;
use WebHelper;
use LeaveHelper;

use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesController extends Controller
{
   /**
     * 列表-等待核准 Prvoe tag 2,3,4,5
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
            $search['tag_id'] = [2,3,4,5];

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');

            } else {

                $search['tag_id'] = [2,3,4,5];
                $request->session()->forget('leaves_my');

            }
        }

        $model = new Leave;
        // TODO 取登入者
        $search['user_id'] = $user_id;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave', compact(
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
        // TODO 取登入者
        $search['user_id'] = $user_id;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave', compact(
            'search', 'model', 'dataProvider'
        ));
    }
    /**
     * 列表-歷史紀錄 History tag 7,8,9
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
        // TODO 取登入者
        $search['user_id'] = $user_id;

        $dataProvider = $model->fill($order_by)->search($search);
        $leaves_totle_hours = LeaveHelper::getLeavesHoursTotal($dataProvider);

        return  view('leave', compact(
            'dataProvider', 'search', 'model', 'leaves_totle_hours'
        ));
    }

    /**
     * 刪除 - 在等待核准 職代2 和 小主管3 狀態 顯示刪除按鈕
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {
        $model = $this->loadModel($id)->delete();
        // id 必須代 user_id 回到 leaves 頁面
        return Redirect::route('leaves_my_prove', [ 'id' => 1 ])->withErrors(['msg' => '刪除完畢。']);
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