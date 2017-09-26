<?php

namespace App\Http\Controllers;

use WebHelper;
use LeaveHelper;
use App\Team;
use App\Type;
use App\Leave;
use APP\User;
use App\UserTeam;
use App\LeaveDay;
use App\LeaveResponse;
use App\Http\Requests\ManagerProveRequest;

use Auth;  
use Route;
use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesManagerController extends Controller
{
    private $role;

    public function __construct(Request $request)
    {
        //先取得從側邊欄進入的權限
        $this->role = $request->role;
    }
   /**
     * 列表-等待核准 Prvoe
     * 主管 =>該team下 小主管審核過的單 3
     * 小主管 => 職代審核過的單 tag 2
     * 大BOSS => 主管審核過的單 tag 4
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $getRole = $this->role;

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
        if ( $this->role == 'admin' && Auth::hasAdmin() == true) {
              
            $search['tag_id'] = ['4'];
            $search['hours'] = '24';
            $dataProvider = $model->fill($order_by)->searchForProveInManager($search);

        } elseif ($this->role == 'manager' && !empty(Auth::hasManagement())) {

            /* 確認從左側Manager 如果我是主管(確認我有所屬的team) */

            /*先去找子team，狀態在tag 3 (小主管審核過)的條件*/
            $search_sub_teams = self::getManagerSubTeamsLeaves();
            /*再去找自己所屬的team下，狀態在tag 2 (職代審核過)的條件*/
            $search_teams = self::getManagerTeamsLeaves();
            
            $dataProvider_sub_teams = $model->fill($order_by)->searchForProveInManager($search_sub_teams);
            $dataProvider_teams = $model->fill($order_by)->searchForProveInManager($search_teams);
            $dataProvider = $dataProvider_sub_teams->merge($dataProvider_teams);
            
        } elseif ($this->role == 'minimanager' && !empty(Auth::hasMiniManagement())) {
            
            $teams = Auth::hasMiniManagement();
            $search['user_id'] = UserTeam::getUserByTeams($teams);
            $search ['tag_id'] = ['2'];
            $dataProvider = $model->fill($order_by)->searchForProveInManager($search);

        } else {

            return Redirect::route('index')->withErrors(['msg' => '你無權限']);

        }

        return  view('leave_manager', compact(
            'search', 'getRole', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming
     * 抓出該主管審核過的單 tag 9 已準假(通過)
     *
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request)
    { 
        if (!in_array($this->role,['manager','minimanager','admin'])) {

            return Redirect::route('index')->withErrors(['msg' => '你無權限']);

        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $getRole = $this->role;

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

        //傳入user_id,取得該user的審核單, 再回來進入search()
        $tag_id = ['9'];
        $search['id'] = LeaveResponse::getLeavesIdByUserIdAndTagId(Auth::user()->id, $tag_id);
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        
        $model = new Leave;
        $dataProvider = $model->fill($order_by)->searchForUpComingInManager($search);
        return  view('leave_manager', compact(
            'search' ,'getRole', 'model', 'dataProvider'
        ));
    }
    /**
     * 列表-歷史紀錄 History
     * 抓出該主管審核過的單 tag在已準假、不准假 8,9
     *
     * @return \Illuminate\Http\Response
     */
    public function getHistory(Request $request)
    {

        if (!in_array($this->role, ['manager','minimanager','admin'])) {
            
            return Redirect::route('index')->withErrors(['msg' => '你無權限']);
        
        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $getRole = $this->role;

        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);
            
            if (!empty($search['daterange'])) {
                // 先去找子單的時間再搜尋主單
                $date_range = explode(" - ", $search['daterange']);
                $order_by['start_time'] = $date_range[0];
                $order_by['end_time'] = $date_range[1];
                $search['id'] = self::getHistoryLeaveIdForSearch($date_range[0], $date_range[1]);
                
            }  else {

                //如果日期進來為空，搜尋主管審核過 < 今天的子單 的leave_id
                $search['id'] = self::getHistoryLeaveIdForToDay();
               
            }

        } else {

            $search['id'] = self::getHistoryLeaveIdForToDay();

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $request->session()->forget('leaves_manager');

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
        
        $dataProvider = $model->fill($order_by)->searchForHistoryInManager($search);
        $leaves_totle_hours = LeaveHelper::LeavesHoursTotal($dataProvider);

        return  view('leave_manager', compact(
            'search', 'model', 'getRole', 'dataProvider', 'leaves_totle_hours'
        ));
    }

    /*
     *
     *
     *   小主管 & 主管 可看到所屬團隊的假單行事曆
     */

    public function getCalendar ()
    {
        $getRole = $this->role;
        $model = new Leave;

        return  view('leave_manager', compact(
            'getRole','model'
        ));
    }
    
    /**
    * 新增 & 修改 => leaveResponses & Leave
    *
    * @param Request $request
    * @return Redirect
    */
    public function postInsert(ManagerProveRequest $request)
    {
        $getRole = $this->role;
        
        if (!empty($request->input('leave'))) {

            $input = $request->input('leave');
            
            if ($input['agree'] == 1) {

                foreach ($input['leave_id'] as $leave_id) {

                    $model = $this->loadModel($leave_id);
                    
                    if ($this->role == 'minimanager') {
                        
                        $input['tag_id'] = '3';
    
                    } elseif ($this->role == 'manager') {
                        
                        if ($model->hours > 24) {

                            $input['tag_id'] = '4';

                        } else {

                            $input['tag_id'] = '9';

                        }

                    } elseif ($this->role == 'admin') {

                        $input['tag_id'] = '9';

                    }
                    //修改主單記錄
                    $input_update['id'] = $leave_id;
                    $input_update['tag_id'] = $input['tag_id'];
                    //新增記錄
                    $input_create['user_id'] = Auth::user()->id;
                    $input_create['leave_id'] = $leave_id;
                    $input_create['memo'] = $input['memo'];
                    $input_create['tag_id'] = $input['tag_id'];

                    $model->fill($input_update);
                    $model->save();

                    $leave_respon = new LeaveResponse;
                    $leave_respon->fill($input_create);
                    $leave_respon->save();

                }

                return Redirect::route('leaves_manager/prove' ,[ 'role' => $getRole ])->with('success', '批准成功 !');

            } else {

                foreach ($input['leave_id'] as $leave_id) {

                    // 修改主單記錄
                    $model = $this->loadModel($leave_id);
                    $input_update['id'] = $leave_id;
                    $input_update['tag_id'] = '8';

                    //新增記錄
                    $input_create['leave_id'] = $leave_id;
                    $input_create['user_id'] = Auth::user()->id;
                    $input_create['tag_id'] = '8';
                    $input_create['memo'] = $input['memo'];
                    
                    
                    $input_update['tag_id'] = '8';
                    $input_update['id'] = $leave_id;
                    $model->fill($input_update);
                    $model->save();

                    $leave_respon = new LeaveResponse;
                    $leave_respon->fill($input_create);
                    $leave_respon->save();

                }

                return Redirect::route('leaves_manager/prove' ,[ 'role' => $getRole ])->with('success', '不准假成功 !');

            }
        }
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        $model = $this->loadModel($id);

        return  view('leave_manager_view', compact(
            'model'
        ));
    }

    private function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
            
        return $model;
    }

    /**
     * 1.取得主管的team 
     * 2.取得該主管的子team
     * 3.狀態在小主管審核過的user_id
     */
    private static function getManagerSubTeamsLeaves()
    {
        $teams = Auth::hasManagement();
        $teams_id = Team::getTeamsByManagerTeam($teams);
        $search_sub_teams['user_id'] = UserTeam::getUserByTeams($teams_id);
        $search_sub_teams['tag_id'] = ['3'];
        return $search_sub_teams;
    }

    /**
     * 1.取得主管的team
     * 2.取得主管team 的user_id
     * 3.狀態在職代審核過
     */

    private static function getManagerTeamsLeaves()
    {
        $teams = Auth::hasManagement();
        $search_teams['user_id'] = UserTeam::getUserByTeams($teams);
        $search_teams['tag_id'] = ['2'];
        return $search_teams;
    }

    private static function getHistoryLeaveIdForToDay()
    {
        //取得該主管審核過的「不准假」 假單
        $not_leave_tag_id = ['8'];
        $get_not_leaves_id = LeaveResponse::getLeavesIdByUserIdAndTagId(Auth::user()->id, $not_leave_tag_id);
        
        //取得該主管審核過的「已准假」 假單
        $upcoming_tag_id = ['9'];
        $get_upcoming_leaves_id = LeaveResponse::getLeavesIdByUserIdAndTagId(Auth::user()->id, $upcoming_tag_id);
        
        //取得小於今天的子單記錄，狀態在「已準假」為該主管審核過的單
        $today = Carbon::now()->format('Y-m-d');
        $get_leaves_id_today = LeaveDay::getLeavesIdByDate($get_upcoming_leaves_id, $today);
        $result = $get_not_leaves_id->merge($get_leaves_id_today);
        return $result;
    }

    private static function getHistoryLeaveIdForSearch($start_time, $end_time)
    {
        //取得該主管審核過的「已準假、不准假」 假單
        $tag_id = ['8', '9'];
        $get_leaves_id = LeaveResponse::getLeavesIdByUserIdAndTagId(Auth::user()->id, $tag_id);

        // 取得搜尋的區間為該主管不准假、已準的子單記錄 
        $result = LeaveDay::getLeavesIdByDateRangeAndLeavesId($start_time, $end_time, $get_leaves_id);
        return $result;
    }
}