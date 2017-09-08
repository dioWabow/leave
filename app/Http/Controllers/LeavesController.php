<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;
use LeaveHelper;
use WebHelper;

use Carbon\Carbon;
use Redirect;
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

            $request->session()->forget('leaves');
            $request->session()->push('leaves.search', $search);
            $request->session()->push('leaves.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves')))) {

                $search = $request->session()->get('leaves.search.0');
                $order_by = $request->session()->get('leaves.order_by.0');

            } else {

                $request->session()->forget('leaves');

            }
        }

        $model = new Leave;
        $search['tag_id'] = [2,3,4,5];
        $search['user_id'] = $user_id;
        
        $model->fill($order_by);
        $dataProvider = $model->search($search);

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

            $request->session()->forget('leaves');
            $request->session()->push('leaves.search', $search);
            $request->session()->push('leaves.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves')))) {

                $search = $request->session()->get('leaves.search.0');
                $order_by = $request->session()->get('leaves.order_by.0');

            } else {

                $request->session()->forget('leaves');

            }
        }

        $model = new Leave;
        $search['tag_id'] = [9];
        $search['user_id'] = $user_id;

        $model->fill($order_by);
        $dataProvider = $model->search($search);

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
        $search['type_id'] = (!empty($request->input('search'))) ?  $search['type_id'] : [];
       

        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves');
            $request->session()->push('leaves.search', $search);
            $request->session()->push('leaves.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves')))) {

                $search = $request->session()->get('leaves.search.0');
                $order_by = $request->session()->get('leaves.order_by.0');

            } else {

                $request->session()->forget('leaves');

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

        $model->fill($order_by);
        $search['user_id'] = $user_id;
        /* 如果沒有搜尋或搜尋全部(null)時，走固定tag_id */
        if (empty($request->input('search')) || is_null($search['tag_id'])) {

            $search['tag_id'] = [7,8,9];
        } 

        $dataProvider = $model->search($search);
        $leaves_totle_hours = $model->getLeavesHoursTotal($dataProvider);

        return  view('leave', compact(
            'dataProvider', 'search', 'model', 'leaves_totle_hours'
        ));
    }

    /**
     * 刪除 - 在等待核准 職代2 和 小主管3 狀態 可刪除
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