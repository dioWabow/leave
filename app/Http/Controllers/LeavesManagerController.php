<?php

namespace App\Http\Controllers;

use WebHelper;
use LeaveHelper;
use App\Team;
use App\Leave;
use App\UserTeam;
use App\LeaveRespon;

use Auth;  
use Redirect; 
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesManagerController extends Controller
{
   /**
     * 列表-等待核准 Prvoe
     * 主管 =>該team下 小主管審核過的單 3
     * 小主管 => 職代審核過的單 tag 2
     * 大BOSS => 主管審核過的單 tag 4 
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request, $user_id, $role)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        //回傳值給頁面，判斷現在在哪
        $getRole =  (!empty($role)) ? $role : [];
        
        if ($role != 'boss' && $role != 'manager' && $role != 'mini_manager') {

            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);

        }
       
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);
            $search = self::getUserManagerTagAndUserId($search, $getRole);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $search = self::getUserManagerTagAndUserId($search, $getRole);
                $request->session()->forget('leaves_manager');
            }
        }

        $model = new Leave;
        $dataProvider = $model->fill($order_by)->search($search);
        
        return  view('leave_manager', compact(
            'search', 'getRole' , 'model', 'dataProvider' 
        ));
    }

     /**
     * 列表-即將放假 Upcoming 
     * 抓出該主管審核過的單 tag 9 已準假(通過)
     * 
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request, $user_id, $role)
    { 
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $getRole =  (!empty($role)) ? $role : [];
        if (empty($role) || $role != 'boss' && $role != 'manager' && $role != 'mini_manager') {
            
            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);
            
        } 

       
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);
            $search['tag_id'] = [9];

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $request->session()->forget('leaves_manager');
                $search['tag_id'] = [9];
            }
        }
         //傳入user_id,取得該user的審核單, 再回來進入search()
        $search['id'] = LeaveRespon::getLeaveIdByUserId($user_id);

        $model = new Leave;
        $dataProvider = $model->fill($order_by)->search($search);
        
        return  view('leave_manager', compact(
            'search', 'getRole' , 'model', 'dataProvider' 
        ));
    }
    /**
     * 列表-歷史紀錄 History 
     * 抓出該主管審核過的單 tag在已準假、不准假 8,9
     * 
     * @return \Illuminate\Http\Response
     */
    public function getHistory(Request $request, $user_id, $role)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $getRole =  (!empty($role)) ? $role : [];
        if ($role != 'boss' && $role != 'manager' && $role != 'mini_manager') {
            
            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);
            
        }

        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_manager');
            $request->session()->push('leaves_manager.search', $search);
            $request->session()->push('leaves_manager.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_manager')))) {

                $search = $request->session()->get('leaves_manager.search.0');
                $order_by = $request->session()->get('leaves_manager.order_by.0');

            } else {

                $search['tag_id'] = [8,9];
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

        $search['id'] = LeaveRespon::getLeaveIdByUserId($user_id);

        $model = new Leave;
        $dataProvider= $model->fill($order_by)->search($search);
        
        $leaves_totle_hours = LeaveHelper::LeavesHoursTotal($dataProvider);

        return  view('leave_manager', compact(
            'search', 'getRole', 'model', 'dataProvider', 'leaves_totle_hours'
        ));
    }
    /*
    行事曆
    */
    public function getCalendar(Request $request, $user_id, $role)
    {
        $getRole =  (!empty($role)) ? $role : [];
        return  view('leave_manager', compact(
            'getRole'
        ));
    }
     /**
     *  1. 先判斷這人是不是boss，是boss就抓主管審核過的假單
     *  2. 找出他所屬的team是不是manager
     *  3. 判斷他在team裡是主管or小主管(parent_id是否為0)
     *  4. 如果為0 代表為主管，並抓出相關的team_id,再找出teams的user
     *  3. 如果為1 代表為小主管，抓team_id 後 到 userteam找出相關的user
     */
    private static function getUserManagerTagAndUserId($search, $getRole)
    {
        if ($getRole == 'boss') {

            $search['tag_id'] = [4];

        } else {
            
            //取得主管所在團隊 team_id
            $manager_teams_id = UserTeam::getManagerTeamByUserId(Auth::user()->id);
            
            if ($getRole == 'manager') {
                //找出主管為parent_id = 0的team_id
                $team_id = Team::getManagerTeamIdByTeamId($manager_teams_id);
                //找出該主管下有幾個team
                $teams_id = Team::getIdByParentId($team_id);
                //抓出team內有哪些人
                $search['user_id'] = UserTeam::getUsersIdByTeamsId($teams_id, Auth::user()->id);
                $search['tag_id'] = [3];
            
            } elseif ($getRole == 'mini_manager') {
                //找出小主管為parent_id != 0的teams_id
                $team_id = Team::getMiniManagerTeamIdByTeamId($manager_teams_id);
                //抓出team內有哪些人
                $search['user_id'] = UserTeam::getUsersIdByTeamsId($team_id, Auth::user()->id);
                $search['tag_id'] = [2];

            }
               
        }

        return $search;
    }

}