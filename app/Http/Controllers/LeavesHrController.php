<?php

namespace App\Http\Controllers;

use Auth;
use WebHelper;
use App\Leave;
use App\Type;
use App\LeaveDay;

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
        if (Auth::user()->role != 'hr') {

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
        $dataProvider = $model->fill($order_by)->searchForProveAndUpComInHr($search);

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
        if (Auth::user()->role != 'hr') {
            
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
        $dataProvider = $model->fill($order_by)->searchForProveAndUpComInHr($search);

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
        if (Auth::user()->role != 'hr') {
            
            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);
            
        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {
            
            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);

            if (!empty($search['daterange'])) {
                
                $date_range = $this->checkDateExpload($search['daterange']);
                // 先去找子單的時間再搜尋主單
                $search['id'] = LeaveDay::getLeavesIdByDateRange($date_range[0], $date_range[1]);
                $order_by['start_time'] = $date_range[0];
                $order_by['end_time'] = $date_range[1];
                            
            } else {

                 //如果日期進來為空，start_time < 今天 搜尋
                 $search['start_time'] = Carbon::now()->format('Y-m-d');

            }
            
        } else {

            $search['tag_id'] = ['8','9'];
            $search['start_time'] = Carbon::now()->format('Y-m-d');

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
        $dataProvider = $model->fill($order_by)->searchForHistoryInHr($search);
        
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
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;

    }

    /*
    * 把傳進來的日期RANGE分解
    *
    */
   private static function checkDateExpload($data)
   {
       $data = explode(" - ", $data);
       return $data;
   }
}