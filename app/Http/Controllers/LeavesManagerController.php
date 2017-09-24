<?php

namespace App\Http\Controllers;

use WebHelper;
use LeaveHelper;
use App\Team;
use App\Type;
use App\Leave;
use App\UserTeam;
use App\LeaveDay;
use App\LeaveRespon;

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
        if ( $this->role == 'Admin' && Auth::hasAdmin() == true) {
              
            $search['tag_id'] = ['4'];
            $search['hours'] = '24';
            $dataProvider = $model->fill($order_by)->searchForProveInManager($search);

        } elseif ($this->role == 'Manager' && !empty(Auth::hasManagement())) {

            /* 確認從左側Manager 如果我是主管(確認我有所屬的team) */

            /*先去找子team，狀態在tag 3 (小主管審核過)的條件*/
            $search_sub_teams = self::getManagerSubTeamsLeaves();
            /*再去找自己所屬的team下，狀態在tag 2 (職代審核過)的條件*/
            $search_teams = self::getManagerTeamsLeaves();
            
            $dataProvider_sub_teams = $model->fill($order_by)->searchForProveInManager($search_sub_teams);
            $dataProvider_teams = $model->fill($order_by)->searchForProveInManager($search_teams);
            $dataProvider = $dataProvider_sub_teams->merge($dataProvider_teams);
                
        } elseif ($this->role == 'Mini_Manager' && !empty(Auth::hasMiniManagement())) {
            
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
        $search['id'] = LeaveRespon::getLeavesIdByUserIdForUpComing(Auth::user()->id);
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
        行事曆
    */

    public function getCalendar ()
    {
        $getRole = $this->role;
        $model = new Leave;

        return  view('leave_manager', compact(
            'getRole','model'
        ));
    }
    
   
    public function ajaxGetAllAvailableLeaveListByDateRange(Request $request)
    {
        $start_time = date('Y-m-d', $request['start']);
        $end_time = date('Y-m-d', $request['end']);

        $result = [];

        $model = new Leave;

        // 撈出全部假單
        $leave_list = $model->leaveDataRange($start_time, $end_time);

        foreach ($leave_list as $key => $value) {
            // 判斷如果有user 被移除的情況
            if ($value->fetchUser != null) {
                // 用關聯方式取值
                $user_name = $value->fetchUser->nickname;
                $vacation_name = $value->fetchType->name;
                $team_color = $value->fetchUserTeam->fetchTeam->color;

                $result[$key]['title'] = addslashes($user_name . ' / ' .  $vacation_name);
                $result[$key]['start'] = $value['start_time'];
                $result[$key]['end'] = $value['end_time'];
                $result[$key]['backgroundColor'] = $team_color;
                $result[$key]['borderColor'] = $team_color;

            }
        }

        return json_encode(
            $result
        );

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
        $tag_id = '8';
        $get_not_leaves_id = LeaveRespon::getLeavesIdByUserIdAndTagIdForNotLeave(Auth::user()->id, $tag_id);
        //取得該主管審核過的「已准假」 假單
        $get_upcoming_leaves_id = LeaveRespon::getLeavesIdByUserIdForUpComing(Auth::user()->id);
        
        //取得小於今天的子單記錄，狀態在「已準假」為該主管審核過的單
        $get_leaves_id_today = LeaveDay::getLeavesIdByToDay($get_upcoming_leaves_id);
        
        $result = $get_not_leaves_id->merge($get_leaves_id_today);
        return $result;
    }

    private static function getHistoryLeaveIdForSearch($start_time, $end_time)
    {
        //取得該主管審核過的「不准假」 假單
        $tag_id = '8';
        $get_not_leaves_id = LeaveRespon::getLeavesIdByUserIdAndTagIdForNotLeave(Auth::user()->id, $tag_id);
        //取得該主管審核過的「已准假」 假單
        $get_upcoming_leaves_id = LeaveRespon::getLeavesIdByUserIdForUpComing(Auth::user()->id);
        
        // 取得搜尋的區間為該主管不准假的子單記錄 
        $get_unallowed_id = LeaveDay::getLeavesIdByDateRangeAndLeavesId($start_time,$end_time,$get_not_leaves_id);
        // 取得搜尋的區間為該主管已準假的子單記錄 
        $get_allowed_id = LeaveDay::getLeavesIdByDateRangeAndLeavesId($start_time,$end_time,$get_upcoming_leaves_id);
        
        $result = $get_unallowed_id->merge($get_allowed_id);
        
        return $result;
    }
}