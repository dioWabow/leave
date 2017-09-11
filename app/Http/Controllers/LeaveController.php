<?php

namespace App\Http\Controllers;

use LeaveHelper;
use TimeHelper;
use App\User;
use App\Team;
use App\Leave;
use App\Type;
use App\UserAgent;
use App\UserTeam;
use App\LeaveDay;
use App\Http\Requests\LeaveRequest;

use Session;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LeaveController extends Controller
{
    protected $file_path;
    protected $file_root_path;

    public function __construct()
    {
        $this->file_path = 'avatar/';
        $this->file_root_path = storage_path() . '/app/public/' . $this->file_path;
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request) 
    {
        $id = 6;

        $types = Type::getAllType();

        //使用者目前所有代理人
        $user_agents = UserAgent::getUserAgentByUserId($id);

        //全部團隊列表
        $teams = Team::getAllTeam();

        //除了使用者本身，所有人的團隊(額外通知)
        $user_no_team = $team_users = [];
        foreach(User::getAllUsersExcludeUserId($id) as $users){

            if ($users->UserTeam()->first()) {

                $team_users[] = $users->UserTeam()->first();

            } else {

                //沒團隊的人
                $user_no_team[] = $users;

            }
        }

        return view('leave_form2',compact(
            'types','user_agents','teams','team_users','user_no_team'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function postInsert(LeaveRequest $request) 
    {
        $User_id = 6;
        $user = User::find($User_id);
        $leave = $request->input('leave');

        if (count(explode(" - ", $leave['timepicker']))>1) {

            $leave['start_time'] = explode(" - ", $leave['timepicker'])['0'];
            $leave['end_time'] = explode(" - ", $leave['timepicker'])['1'];
            $leave['date_list'] = LeaveHelper::calculateWorkingDate($leave['start_time'],$leave['end_time']);
            $leave['hours'] = LeaveHelper::calculateRangeDateHours($leave['date_list']);

        } else {
            
            $leave['hours'] = ($leave['dayrange'] == "allday") ? 8 : 4;

            if ($leave['dayrange'] == "morning") {

                if ($user->arrive_time=="0900") {

                    $leave['start_time'] = $leave['timepicker'] . " 09:00:00";
                    $leave['end_time'] = $leave['timepicker'] . " 14:00:00";

                } else {

                    $leave['start_time'] = $leave['timepicker'] . " 09:30:00";
                    $leave['end_time'] = $leave['timepicker'] . " 14:30:00";

                }
                
            } elseif($leave['dayrange'] == "afternoon") {

                if ($user->arrive_time=="0900") {

                    $leave['start_time'] = $leave['timepicker'] . " 14:00:00";
                    $leave['end_time'] = $leave['timepicker'] . " 18:00:00";

                } else {

                    $leave['start_time'] = $leave['timepicker'] . " 14:30:00";
                    $leave['end_time'] = $leave['timepicker'] . " 18:30:00";

                }

            } else {

                if ($user->arrive_time=="0900") {

                    $leave['start_time'] = $leave['timepicker'] . " 09:00:00";
                    $leave['end_time'] = $leave['timepicker'] . " 18:00:00";

                } else {

                    $leave['start_time'] = $leave['timepicker'] . " 09:30:00";
                    $leave['end_time'] = $leave['timepicker'] . " 18:30:00";

                }

            }
           
        }

        $model = new Leave;

        $response = LeaveHelper::judgeLeave($leave);
        if ($response == "") {

            $leave['user_id'] = $User_id;
            $leave['tag_id'] = 1;
            $leave['create_user_id'] = $User_id;

            $model->fill($leave);
            if ($model->save()) {

                $leave_day = [];

                if (TimeHelper::changeDateFormat($model->start_time,'Y-m-d') != TimeHelper::changeDateFormat($model->end_time,'Y-m-d')) {

                    //拆單
                    foreach ($leave['date_list'] as $key => $date) {

                        $leave_day_model = new LeaveDay;
                        $leave_day['leave_id'] = $model->id;
                        $leave_day['type_id'] = $model->type_id;
                        $leave_day['create_user_id'] = $model->create_user_id;
                        $leave_day['user_id'] = $model->user_id;

                        // 第一天
                        if ($key == 0) {

                            $start_time = $date;
                            $end_time = TimeHelper::changeDateFormat($date,'Y-m-d');
                            $end_time .= ($user->arrive_time=="0900") ? " 18:00" : " 18:30";
                            $hours = LeaveHelper::calculateOneDateHours($start_time,$end_time);

                        // 最後一天
                        } elseif($key == count($leave['date_list'])-1) {

                            $start_time = TimeHelper::changeDateFormat($date,'Y-m-d');
                            $start_time .=  ($user->arrive_time=="0900") ? " 09:00" : " 09:30" ;
                            $end_time = $date;
                            $hours = LeaveHelper::calculateOneDateHours($start_time,$end_time);

                        // 中間天數
                        } else {

                            $start = ($user->arrive_time=="0900") ? " 09:00" : " 09:30";
                            $end = ($user->arrive_time=="0900") ? " 18:00" : " 18:30";
                            $start_time = $date . $start ;
                            $end_time = $date . $end ;
                            $hours = LeaveHelper::calculateOneDateHours($start_time,$end_time);

                        }

                        $leave_day['start_time'] = $start_time;
                        $leave_day['end_time'] = $end_time;
                        $leave_day['hours'] = $hours;

                        $leave_day_model->fill($leave_day);
                        if (!$leave_day_model->save()) {

                            return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                        }
                    }

                } else {

                    $leave_day_model = new LeaveDay;

                    $leave_day['leave_id'] = $model->id;
                    $leave_day['type_id'] = $model->type_id;
                    $leave_day['create_user_id'] = $model->create_user_id;
                    $leave_day['user_id'] = $model->user_id;
                    $leave_day['start_time'] = $model->start_time;
                    $leave_day['end_time'] = $model->end_time;
                    $leave_day['hours'] = $model->hours;

                    $leave_day_model->fill($leave_day);
                    if (!$leave_day_model->save()) {

                        return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                    }

                }
                

                //新增假單代理人
                // UserAgent::deleteUserAgentByUserId($model->id);
                // if(!empty($leave['agent'])){

                //     $user_agents = $leave['agent'];
                //     foreach($user_agents as $agent_id){

                //         $agent = new UserAgent;
                //         $agent->fill([
                //             'user_id' => $model->id,
                //             'agent_id' => $agent_id,
                //         ]);
                //         $agent->save();

                //     }

                // }

                return Redirect::route('index')->withErrors(['msg' => '新增成功']);

            } else {

                return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

            }

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => $response]);

        }
    }


    /**
     * 編輯
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request,$id = '') 
    {

        $model = $this->loadModel($id);

        $input = $request->old('user');

        if (!empty($input)) {

            $model->fill($input);

            //使用者目前所有代理人(前台in_array)
            $user_agents = $input['agent'];

            //使用者目前的團隊(前台in_array)
            $user_teams =  $input['team'];

        } else {

            //使用者目前所有代理人(前台in_array)
            $user_agents = UserAgent::getAgentIdByUserId($id)->toArray();

            //使用者目前的團隊(前台in_array)
            $user_teams =  UserTeam::getTeamIdByUserId($id)->toArray();

        }
        
        //全部團隊列表
        $teams = Team::getAllTeam();

        //除了使用者本身，所有人的團隊(代理人使用)
        $user_no_team = $team_users = [];
        foreach(User::getAllUsersExcludeUserId($id) as $users){

            if ($users->UserTeam()->first()) {

                $team_users[] = $users->UserTeam()->first();

            } else {

                //沒團隊的人
                $user_no_team[] = $users;

            }
        }

        return view('users_form',compact(
            'model','user_agents','user_teams','teams','team_users','user_no_team'
        ));
    }

    /**
     * 修改
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(UserRequest $request) 
    {
        $input = $request->input('user');
        $input['job_seek'] = 0;
        if ($input['status'] == 2) {

            $input['job_seek'] = 1;
            $input['status'] = 1;

        }

        //user資料儲存
        $model = $this->loadModel($input['id']);

        //上傳圖片 注意：須於 public 下建立連結 - php artisan storage:link 
        $image_url = '';
        if ($request->hasFile('user') && $request->file('user')['avatar']->isValid()) {
            $input_file = Input::file('user');
            $file_extension = $input_file['avatar']->getClientOriginalExtension();
            
            $filename = $input['nickname'] . '.' . $file_extension; //命名方式依照各專案需求
            $image = $this->image_root_path . $filename;

            if (Image::make($input_file['avatar'])->save($image)) {
                $input['avatar'] = $filename;
            }
        }

        $model->fill($input);
        if ($model->save()) {

            //修改代理人
            UserAgent::deleteUserAgentByUserId($model->id);
            if(!empty($input['agent'])){

                $user_agents = $input['agent'];
                foreach($user_agents as $agent_id){

                    $agent = new UserAgent;
                    $agent->fill([
                        'user_id' => $model->id,
                        'agent_id' => $agent_id,
                    ]);
                    $agent->save();

                }

            }

            //修改團隊
            UserTeam::deleteUserTeamByUserId($model->id);
            if (!empty($input['team'])) {

                $user_teams = $input['team'];
                foreach($user_teams as $team_id){

                    $team = new UserTeam;
                    $team->fill([
                        'user_id' => $model->id,
                        'team_id' => $team_id,
                        'role' => 'user',
                    ]);
                    $team->save();

                }

            } 

            return Redirect::to('user/index')->withErrors(['msg' => '修改成功']);

        } else {

            return Redirect::back()->withInput();

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

    public function calculate_hours(Request $request){
        $hours = 0;
        $date_range = $request->input('date_range');
        $start_time = explode(" - ", $date_range)['0'];
        $end_time = explode(" - ", $date_range)['1'];

        //輸入日期不同天，需計算區間
        if (date( "Y-m-d", strtotime( "$start_time" )) != date( "Y-m-d", strtotime( "$end_time" ))) {

            $date_list = LeaveHelper::calculateWorkingDate($start_time,$end_time);
            $hours = LeaveHelper::calculateRangeDateHours($date_list);

        } else {

            $hours = LeaveHelper::calculateOneDateHours($start_time,$end_time);

        }

        $response = array(
          'hours' => $hours,
        );
        return response()->json($response); 
    }
}
