<?php

namespace App\Http\Controllers;

use WebHelper;
use LeaveHelper;
use App\Team;
use App\Leave;
use APP\User;
use App\UserTeam;
use App\LeaveRespon;

use Auth;
use Redirect;
use Route;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesManagerController extends Controller
{
    private $role;

    public function __construct(Request $request)
    {
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
            $dataProvider = $model->fill($order_by)->search($search);

        } elseif ($this->role == 'Manager' && !empty(Auth::hasManagement())) {

            $search_sub_teams = self::getManagerSubTeamsLeaves();
            $search_teams = self::getManagerTeamsLeaves();

            $dataProvider_sub_teams = $model->fill($order_by)->search($search_sub_teams);
            $dataProvider_teams = $model->fill($order_by)->search($search_teams);
            $dataProvider = $dataProvider_sub_teams->merge($dataProvider_teams);

        } elseif ($this->role == 'Mini_Manager' && !empty(Auth::hasMiniManagement())) {

            $teams = Auth::hasMiniManagement();
            $search['user_id'] = UserTeam::getUserByTeams($teams);
            $search ['tag_id'] = ['2'];
            $dataProvider = $model->fill($order_by)->search($search);

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
        $leave_id = LeaveRespon::getLeaveIdByUserId(Auth::user()->id);
        $serach['id'] = Leave::getUpComingLeavesIdByTodayForManager(Carbon::now(),$leave_id);
        $search['tag_id'] = [9];

        $model = new Leave;
        $dataProvider = $model->fill($order_by)->search($search);

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
        //傳值近來是exception，先去找該exception的id，再搜尋假單是否有該type_id
        if (!empty($search['type_id'])) {

            $order_by['exception'] = $search['type_id'];
            $search['type_id'] = $model->getTypeIdByException($search['type_id']);


        } else {

            $search['type_id'] = [];

        }

        $search['tag_id'] = [8,9];
        $search['id'] = LeaveRespon::getLeaveIdByUserId(Auth::user()->id);

        $model = new Leave;
        $dataProvider= $model->fill($order_by)->search($search);

        $leaves_totle_hours = LeaveHelper::LeavesHoursTotal($dataProvider);

        return  view('leave_manager', compact(
            'search', 'model','getRole', 'dataProvider', 'leaves_totle_hours'
        ));
    }

    public function getCalendar()
    {
        $getRole = $this->role;

        return  view('leave_manager', compact(
            'getRole'
        ));
    }

    /*
    行事曆
    * 抓出 該主管 所以有的 team 成員
    */
    /**
     * 1.判斷權限是主還是子 抓不同資料
     * 2.抓出 team 的 所有 user_id
     * 3.抓出主單有 相同 user_id 的部分
     */
    public function ajaxGetManagerAvailableLeaveListByDateRange(Request $request)
    {
        $start_time = date('Y-m-d', $request['start']);
        $end_time = date('Y-m-d', $request['end']);
        $getRole = $request['role'];

        $user_id = Auth::user()->id;

        $teams = [];

        if ($this->role == 'Manager' && !empty(Auth::hasManagement())) {

            $teams = Auth::hasManagement();
            $teams_id = Team::getTeamsByManagerTeam($teams);

        } elseif ($this->role == 'Mini_Manager' && !empty(Auth::hasMiniManagement()) ) {

            $teams = Auth::hasMiniManagement();

        } else {

            return Redirect::route('index')->withErrors(['msg' => '你無權限']);

        }

        $model = new UserTeam;
        $all_member = $model->getUserByTeams($teams);

        // 撈出全部假單
        $leaveModel = new Leave;
        $leave_list = $leaveModel->leaveManagerDataRange($all_member, $start_time, $end_time);

        $result = [];
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
    public static function getManagerSubTeamsLeaves()
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

    public static function getManagerTeamsLeaves()
    {
        $teams = Auth::hasManagement();
        $search_teams['user_id'] = UserTeam::getUserByTeams($teams);
        $search_teams['tag_id'] = ['2'];
        return $search_teams;

    }
}