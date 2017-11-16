<?php

namespace App\Http\Controllers;

use WebHelper;
use TimeHelper;
use LeaveHelper;
use App\Type;
use App\Leave;
use App\LeaveDay;
use App\LeaveResponse;

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
    public function getProve(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);

        } else {   
            
            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');

            } else {

                
                $request->session()->forget('leaves_my');

            }
        }

        $model = new Leave;
        $search['tag_id'] = ['1','2','3','4'];
        $search['user_id'] = Auth::user()->id;
        $dataProvider = $model->fill($order_by)->searchForProveAndUpComInMy($search);
        
        return  view('leave_my', compact(
            'search', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming tag 9
     *
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {

                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');

            } else {

                $request->session()->forget('leaves_my');
                
            }
        }

        $model = new Leave;
        $search['tag_id'] = ['9'];
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        $search['user_id'] = Auth::user()->id;
        $dataProvider = $model->fill($order_by)->searchForProveAndUpComInMy($search);
        
        return  view('leave_my', compact(
            'search', 'model', 'dataProvider'
        ));
    }

    /**
     * 列表-歷史紀錄 History tag 7,8,9 放完的假、取消的假單、未核准假單
     *
     * @return \Illuminate\Http\Response
    */
    public function getHistory(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
       
        if (!empty($search) || !empty($order_by)) {

            //有搜尋和取得order_by時，先移除session 再將 seach order 加入session 
            $request->session()->forget('leaves_my');
            $request->session()->push('leaves_my.search', $search);
            $request->session()->push('leaves_my.order_by', $order_by);

            if (!empty($search['daterange'])) {
                
                $date_range = explode(" - ", $search['daterange']);
                // 先去找子單的時間再搜尋主單
                $search['id'] = self::getHistoryLeaveIdForSearch($date_range[0], $date_range[1]);
                $order_by['start_time'] = $date_range[0];
                $order_by['end_time'] = $date_range[1];
                            
            }  else {

                 //如果日期進來為空，搜尋該user < 今天的子單 的leave_id
                $search['id'] = $this->getHistoryLeaveIdForDate();

            }

        } else {

            $search['id'] = $this->getHistoryLeaveIdForDate();

            // 沒有搜尋，判斷有沒有page 和 session 是不是空的
            if (!empty($request->input('page') && !empty($request->session()->get('leaves_my')))) {
                
                //有分頁時，將session 的資料塞給$search
                $search = $request->session()->get('leaves_my.search.0');
                $order_by = $request->session()->get('leaves_my.order_by.0');
               
            } else {
                
                $request->session()->forget('leaves_my');
                
            }
           
        }
        
        $model = new Leave;
        //傳值近來是exception，先去找該exception的id，再搜尋假單是否有該type_id
        if (!empty($search['exception'])) {
            
            $order_by['exception'] = $search['exception'];
            $search['type_id'] = Type::getTypeIdByException($search['exception']);
            
        } else {

            $search['type_id'] = [];

        }
        
        $dataProvider = $model->fill($order_by)->searchForHistoryInMy($search);
        $leaves_totle_hours = LeaveHelper::getLeavesHoursTotal($dataProvider);
        
        return  view('leave_my', compact(
            'dataProvider', 'search', 'model', 'leaves_totle_hours'
        ));
    }

    /**
     * 取消假單 - 在等待核准 代理人待核1 和 小主管代和2狀態才可取消
     * 前台會顯示刪除按鈕
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(Request $request, $id)
    {

        $model = $this->loadModel($id);

        if (!in_array($model->tag_id, ['1','2'])) {

            return Redirect::route('leaves_my/prove')->withErrors(['msg' => '您的假單狀態不可取消']);

        }
        
        $model->fill(['tag_id' => '7']);
        if ($model->save()) {

            $leave_respon = new LeaveResponse;
            $leave_respon->fill(['leave_id' => $id,
                'user_id' => Auth::user()->id,
                'tag_id' => '7',
                'memo' => '假單取消'
            ]);
            if ($leave_respon->save()) {
                
                return Redirect::route('leaves_my/prove')->with('success', '假單取消成功。');

            } else {

                return Redirect::route('leaves_my/prove')->withErrors(['msg' => '假單取消失敗。']);

            } 

        } else {

            return Redirect::route('leaves_my/prove')->withErrors(['msg' => '假單取消失敗。']);

        }
    }

    private function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;

    }

    private static function getHistoryLeaveIdForDate()
    {
        $model = new Leave;
        
        //取得該user 的「已取消、不准假」 假單
        $not_leaves['tag_id'] = ['7','8'];
        $not_leaves['user_id'] = Auth::user()->id;
        $get_not_leaves_id = $model->getLeaveIdByTagIdAndUserId($not_leaves);

        //取得該user 的「已准假」 假單
        $upcoming['tag_id'] = ['9'];
        $upcoming['user_id'] = Auth::user()->id;
        $get_upcoming_leaves_id = $model->getLeaveIdByTagIdAndUserId($upcoming);

        //取得小於今天的子單記錄，狀態在「已準假」為該主管審核過的單
        $today = Carbon::now()->format('Y-m-d');
        $get_leaves_id_today = LeaveDay::getLeavesIdByDate($get_upcoming_leaves_id, $today);
        $result = $get_not_leaves_id->merge($get_leaves_id_today);
        
        return $result;
    }

    private static function getHistoryLeaveIdForSearch($start_time, $end_time)
    {
        $model = new Leave;
        $search['tag_id'] = ['7','8','9'];
        $search['user_id'] = Auth::user()->id;
        //取得user「不准假、已取消、已準假」 假單
        $get_leaves_id = $model->getLeaveIdByTagIdAndUserId($search);
        
        //先將日期轉換成正確的搜尋條件，09:00 ~ 18:00
        $range = TimeHelper::changeDateTimeFormat($start_time, $end_time);
        
        // 取得搜尋的區間為該user的子單記錄 
        $result = LeaveDay::getLeavesIdByDateRangeAndLeavesId($range[0], $range[1], $get_leaves_id);
        
        return $result;
    }

}