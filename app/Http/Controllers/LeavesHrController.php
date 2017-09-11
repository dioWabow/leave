<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;
use App\LeaveRespon;
use LeaveHelper;
use WebHelper;

use Carbon\Carbon;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesHrController extends Controller
{
   /**
     * 列表-等待核准 Prvoe
     * 大BOSS待核 tag 5
     * 主管待核 tag 4 
     * 小主管待核 tag 3 
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $request->session()->forget('leaves_manager');

            }
        }
        $model = new Leave;
        //大BOSS的須審核的tag_id => 5 
        $search['tag_id'] = [1,2,3,4,5,6];

        $model->fill($order_by);
        $dataProvider = $model->search($search);

        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming 
     * 所有主管的審核單 tag 9 
     * 抓出該user_id的審核單 tag在已準假(通過)
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $request->session()->forget('leaves_manager');

            }
        }

        $model = new Leave;
        //即將放假的tag_id => 9 已通過
        $search['tag_id'] = [9];
        //現在是誰的user_id,到LeaveRespon抓他審核過假單user_id, 再回來進入search()
        // $search['id'] = LeaveRespon::getUserIdByLeaveId($user_id);

        $model->fill($order_by);
        $dataProvider = $model->search($search);

        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }
    /**
     * 列表-歷史紀錄 History 
     * 抓出該user_id的審核單 tag在已準假、不准假 8,9 (通過)
     * @return \Illuminate\Http\Response
    */
    public function getHistory(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $search['type_id'] = (!empty($request->input('search'))) ?  $search['type_id'] : [];
       

        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $request->session()->forget('leaves_manager');

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
        /* 如果沒有搜尋或搜尋全部(null)時，走固定tag_id */
        if (empty($request->input('search')) || is_null($search['tag_id'])) {

            $search['tag_id'] = [8,9];
        } 
        
        $dataProvider= $model->search($search);
        // $leaves_totle_hours = LeaveHelper::LeavesHoursTotal($dataProvider);

        return  view('leave_hr', compact(
            'dataProvider', 'search', 'model', 'leaves_totle_hours'
        ));
    }

}