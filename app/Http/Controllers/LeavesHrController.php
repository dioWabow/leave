<?php

namespace App\Http\Controllers;

use WebHelper;
use TimeHelper;
use App\Leave;
use App\Type;
use App\LeaveDay;

use Auth;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesHrController extends Controller
{
    /**
     * 列表-等待核准 Prvoe
     * HR可以看所有待核准的假單 tag 1,2,3,4
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request)
    {
        if (Auth::hasHr() != true) {

            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);

        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {

                $request->session()->forget('leaves_hr');

            }
        }

        $model = new Leave;
        $search['tag_id'] = ['1','2','3','4'];
        $dataProvider = $model->fill($order_by)->HrProveAndUpComingSearch($search);

        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming
     * HR可以看所有準假的假單 tag 9 (已準假)
     *
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request)
    {
        if (Auth::hasHr() != true) {

            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);

        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {
                
                $request->session()->forget('leaves_hr');

            }
        }
        
        $model = new Leave;
        $search['tag_id'] = ['9'];
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        
        $dataProvider = $model->fill($order_by)->HrProveAndUpComingSearch($search);
        
        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }
    /**
     * 列表-歷史紀錄 History
     * HR可以看所有的假單 tag 8,9
     *
     * @return \Illuminate\Http\Response
    */
    public function getHistory(Request $request)
    {
        if (Auth::hasHr() != true) {

            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);

        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);

            if (!empty($search['daterange'])) {

                $date_range = explode(" - ", ($search['daterange']));
                $order_by['start_time'] = $date_range[0];
                $order_by['end_time'] = $date_range[1];
                $search['id'] = self::getHistoryLeaveIdByDate($date_range[0], $date_range[1]);
                            
            } else {

                 //如果日期進來為空，搜尋所有 < 今天以子單日期為主 的leave_id
                 $search['id'] = self::getHistoryLeaveIdByToDay();
                 
            }
            
        } else {

            $search['id'] = self::getHistoryLeaveIdByToDay();

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {

                $request->session()->forget('leaves_hr');

            }

        }
        
        //傳值近來是exception，先去找該exception的id，再搜尋假單是否有該type_id
        if (!empty($search['exception'])) {
            
            $order_by['exception'] = $search['exception'];
            $search['type_id'] = Type::getTypeIdByException($search['exception']);
            
        } else {

            $search['type_id'] = [];

        }
        
        $model = new Leave;
        $dataProvider = $model->fill($order_by)->HrHistorySearch($search);
        
        return  view('leave_hr', compact(
            'dataProvider', 'search', 'model'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        return  view('leave_manager_view');
    }

    private function loadModel($id)
    {
        $model = Leave::where('id',$id)->remember(0.2)->get()->first();

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;

    }

    private static function getHistoryLeaveIdByToDay()
    {
        $model = new Leave;
        //取得所有「不准假」的 假單id
        $not_leaves_tag_id = ['8'];
        $get_not_leaves_id = $model->getLeaveByTagId($not_leaves_tag_id)->pluck('id');

        //取得所有「已准假」 的 假單id
        $upcoming_tag_id = ['9'];
        $get_upcoming_leaves_id = $model->getLeaveByTagId($upcoming_tag_id)->pluck('id');
        //取得所有小於今天的子單記錄，狀態在「已準假」
        $today = Carbon::now()->format('Y-m-d');
        $get_leaves_id_today = LeaveDay::getLeavesIdByDate($get_upcoming_leaves_id, $today);
        $result = $get_not_leaves_id->merge($get_leaves_id_today);
        return $result;
    }

    private static function getHistoryLeaveIdByDate($start_time, $end_time)
    {
        $model = new Leave;
        $tag_id = ['8', '9'];
        //取得所有「不准假、已准假」的 假單id
        $get_leaves_id = $model->getLeaveByTagId($tag_id)->pluck('id');
        
        //先將日期轉換成正確的搜尋條件，09:00 ~ 18:00 
        $reange = TimeHelper::changeDateTimeFormat($start_time, $end_time);

        // 取得搜尋區間的子單記錄 
        $result = LeaveDay::getLeavesIdByDateRangeAndLeavesId($reange[0], $reange[1], $get_leaves_id);
        return $result;
    }
}