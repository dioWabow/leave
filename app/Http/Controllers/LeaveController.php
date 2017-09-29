<?php

namespace App\Http\Controllers;

use LeaveHelper;
use TimeHelper;
use AttachHelper;
use UserHelper;
use UrlHelper;
use ConfigHelper;
use App\User;
use App\Team;
use App\Leave;
use App\Type;
use App\UserAgent;
use App\UserTeam;
use App\LeaveDay;
use App\LeaveAgent;
use App\LeaveNotice;
use App\LeaveResponse;
use App\Http\Requests\LeaveRequest;
use App\Notifications\AgentNoticeSlack;
use App\Notifications\AgentNoticeEmail;
use App\Notifications\UserLeaveSuccessEmail;
use App\Notifications\UserLeaveSuccessSlack;
use App\Notifications\AgentLeaveSuccessEmail;
use App\Notifications\AgentLeaveSuccessSlack;
use App\Notifications\UserLeaveReturnEmail;
use App\Notifications\UserLeaveReturnSlack;
use App\Notifications\AgentLeaveCancelSlack;
use App\Notifications\UserLeaveCancelSlack;
use App\Notifications\AgentLeaveCancelEmail;
use App\Notifications\UserLeaveCancelEmail;
use SlackHelper;
use \App\Classes\EmailHelper;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    protected $file_path;
    protected $file_root_path;

    public function __construct()
    {
        parent::__construct();
        $this->file_path = 'avatar/';
        $this->file_root_path = storage_path() . '/app/public/' . $this->file_path;
    }

    /**
     *
     * 列表
     *
     */
    public function getIndex(Request $request)
    {
        $user_arr = [];

        $user_id = Auth::user()->id;

        if (Auth::hasHr()) {

            $user_arr = User::getAllUsersWithoutLeaved();

        } else {

            if (Auth::hasManageMent()) {

                //抓自己昰主管的team的所有人
                $users = UserTeam::getUserByTeams(Auth::hasManageMent());

                //抓自己底下的子team的所有人
                $miniusers = UserTeam::getMiniTeamUsers($user_id);

                $users = array_unique(array_merge($users,$miniusers), SORT_REGULAR);

                foreach ($users as $user) {

                    if (!empty(User::find($user))&&User::find($user)->status != 0) {

                        $user_arr[] = User::find($user);

                    }

                }

            }

        }

        return view('leave_form33',compact(
            'user_arr'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request,$user_id= '')
    {
        
        //判斷是否可以幫此人請假
        if (!empty($user_id) && !Auth::hasHr()) {

            if (Auth::hasManageMent() || Auth::hasMiniManageMent()) {

                //抓自己昰主管的team的所有人
                $users = UserTeam::getUserByTeams(Auth::hasManageMent());

                //抓自己底下的子team的所有人
                $miniusers = UserTeam::getMiniTeamUsers(Auth::user()->id);

                $users = array_unique(array_merge($users,$miniusers), SORT_REGULAR);

                if (!in_array($user_id, $users)) {

                    return Redirect::route('index')->withErrors(['msg' => '無法幫此人請假']);

                }

            } else {

                return Redirect::route('index')->withErrors(['msg' => '無法幫此人請假']);

            }

        }

        $user_id = (!empty($user_id)) ? $user_id : Auth::user()->id;

        $data = $request->old('leave');

        $model = new Leave;

        if (!empty($data)) {

            $model->fill($data);

        }

        //抓出所有假別，並判斷謀職假是否開啟
        $types = Type::getAllType();

        if (!User::getJobSeekByUserId($user_id)[0]) {

            $type_id_arr = Type::getTypeByException(['job_seek'])->toArray();
            foreach ($type_id_arr as $type_id) {

                foreach ($types as $key => $type) {

                    if ($type['id'] == $type_id['id']) {

                        unset($types[$key]);

                    }

                }

            }

        }

        //使用者目前所有代理人
        $user_agents = UserAgent::getUserAgentByUserId($user_id);

        //全部團隊列表
        $teams = Team::getAllTeam();

        //除了使用者本身，所有人的團隊(額外通知)
        $user_no_team = $team_users = [];
        foreach (User::getAllUsersExcludeUserId($user_id) as $users) {

            if ($users->fetchUserTeam()->first()) {

                $team_users[] = $users->fetchUserTeam()->first();

            } else {

                //沒團隊的人
                $user_no_team[] = $users;

            }

        }

        return view('leave_form2',compact(
            'user_id','model','types','user_agents','teams','team_users','user_no_team'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function postInsert(LeaveRequest $request)
    {
        $leave = $request->input('leave');
        $user = User::find($leave['user_id']);

        $start = ' 09:00';
        $end = ' 18:00';

        if (count(explode(' - ', $leave['timepicker'])) > 1) {

            $leave['start_time'] = TimeHelper::changeTimeByArriveTime(explode(' - ', $leave['timepicker'])['0'],$user->id,'-');
            $leave['end_time'] = TimeHelper::changeTimeByArriveTime(explode(' - ', $leave['timepicker'])['1'],$user->id,'-');
            $leave['date_list'] = LeaveHelper::calculateWorkingDate($leave['start_time'],$leave['end_time']);
            $leave['hours'] = LeaveHelper::calculateRangeDateHours($leave['date_list']);

        } else {

            $leave['hours'] = ($leave['dayrange'] == 'allday') ? 8 : 4;

            if ($leave['dayrange'] == 'morning') {

                $leave['start_time'] = $leave['timepicker'] . $start;
                $leave['end_time'] = TimeHelper::changeHourValue($leave['start_time'],['+,4,hour'],'Y-m-d H:i:s');

            } elseif ($leave['dayrange'] == 'afternoon') {

                $leave['end_time'] = $leave['timepicker'] . $end;
                $leave['start_time'] = TimeHelper::changeHourValue($leave['end_time'],['-,4,hour'],'Y-m-d H:i:s');

            } else {

                $leave['start_time'] = $leave['timepicker'] . $start;
                $leave['end_time'] = $leave['timepicker'] . $end;

            }

        }

        $model = new Leave;

        $response = LeaveHelper::judgeLeave($leave,$leave['user_id']);
        if (empty($response)) {

            // 一定要有代理人
            if (empty($leave['agent'])) {

                return Redirect::back()->withInput()->withErrors(['msg' => '請選擇代理人，若無代理人請洽HR']);

            }

            if(Input::hasFile('fileupload')) {
                $file_name = AttachHelper::uploadFiles('fileupload','prove');
                if (!empty($file_name)) {

                    $leave['prove'] = implode(',' , $file_name);

                } else {

                    return Redirect::back()->withInput()->withErrors(['msg' => '上傳證明失敗']);

                }
            }

            $model->fill($leave);
            if ($model->save()) {

                $leave_day = [];

                $exception = Type::find($model->type_id)->exception;

                //如果請假不是同一天就拆單成兩天(除了有薪病假與病假外)
                if (TimeHelper::changeDateFormat($model->start_time,'Y-m-d') != TimeHelper::changeDateFormat($model->end_time,'Y-m-d') && !in_array($exception, ['paid_sick','sick'])) {

                    //拆單
                    foreach ($leave['date_list'] as $date) {

                        $leave_day_model = new LeaveDay;
                        $leave_day['leave_id'] = $model->id;
                        $leave_day['type_id'] = $model->type_id;
                        $leave_day['create_user_id'] = $model->create_user_id;
                        $leave_day['user_id'] = $model->user_id;

                        $hours = LeaveHelper::calculateOneDateHours($date['start_time'],$date['end_time']);

                        $leave_day['start_time'] = $date['start_time'];
                        $leave_day['end_time'] = $date['end_time'];
                        $leave_day['hours'] = $hours;

                        $leave_day_model->fill($leave_day);
                        if (!$leave_day_model->save()) {

                            return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                        }
                    }

                //病假拆單
                } elseif (in_array($exception,['paid_sick','sick'])) {

                    $sick_type = Type::getTypeByException(['sick'])->first()['id'];
                    $paid_sick_type = Type::getTypeByException(['paid_sick'])->first()['id'];
                    $start_date = LeaveHelper::getStartDateAndEndDate($paid_sick_type,$model->start_time)['start_date'];
                    $end_date = LeaveHelper::getStartDateAndEndDate($paid_sick_type,$model->start_time)['end_date'];
                    $date_list = LeaveHelper::calculateWorkingDate($model->start_time,$model->end_time);

                    $leave_day['leave_id'] = $model->id;
                    $leave_day['create_user_id'] = $model->create_user_id;
                    $leave_day['user_id'] = $model->user_id;

                    $new_date_list = [];

                    //如果假別有期限才拆單
                    if (!empty($start_date) && !empty($end_date)) {

                        foreach ($date_list as $key => $date) {

                            if (TimeHelper::changeDateFormat($date['start_time'],'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                                $new_date_list[] = $date;
                                unset($date_list[$key]);

                            }

                        }

                    }

                    //拆單前半
                    self::createSickLeave($leave_day,$date_list,$model->user_id,$start_date,$end_date,$paid_sick_type,$sick_type);
                    //拆單後半
                    if (count($new_date_list) > 0) {
                        $start_date = LeaveHelper::getStartDateAndEndDate($paid_sick_type,$new_date_list['0']['start_time'])['start_date'];
                        $end_date = LeaveHelper::getStartDateAndEndDate($paid_sick_type,$new_date_list['0']['start_time'])['end_date'];
                        self::createSickLeave($leave_day,$new_date_list,$model->user_id,$start_date,$end_date,$paid_sick_type,$sick_type);
                    }

                //如果請假只有一天，主單直接放入子單新增一筆
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
                if (!empty($leave['agent'])){

                    $user_agents = $leave['agent'];
                    $user_agents = LeaveHelper::removeAgentByDate($user_agents,$model->start_time,$model->end_time);
                    foreach($user_agents as $agent_id){

                        $leave_agent = new LeaveAgent;
                        $leave_agent->fill([
                            'leave_id' => $model->id,
                            'agent_id' => $agent_id,
                        ]);
                        $leave_agent->save();

                    }

                }

                //新增通知人
                if (!empty($leave['notice_person'])){

                    $notice_people = $leave['notice_person'];
                    foreach($notice_people as $notice_person){

                        $leave_notice = new LeaveNotice;
                        $leave_notice->fill([
                            'leave_id' => $model->id,
                            'user_id' => $notice_person,
                        ]);
                        $leave_notice->save();

                    }

                }

                //新增審核紀錄
                $leave_response = new LeaveResponse;
                $leave_response->fill([
                    'leave_id' => $model->id,
                    'user_id' => $model->create_user_id,
                    'tag_id' => '1',
                ]);
                $leave_response->save();

                //新增職代通知
                $agent_list = LeaveAgent::getAgentByLeaveId($model->id);
                if ( count( $agent_list ) != 0 ) {

                    foreach ( $agent_list as $key => $agent) {

                        SlackHelper::notify(new AgentNoticeSlack( $model->fetchUser->nickname , $model->start_time , $agent->fetchUser->nickname )  );
                        $EmailHelper = new EmailHelper;
                        $EmailHelper->to = $agent->fetchUser->email;
                        $EmailHelper->notify(new AgentNoticeEmail( $model->fetchUser->nickname , $model->start_time ) );

                    }

                }

                return Redirect::route('index')->with('success', '新增成功 !');

            } else {

                return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

            }

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => $response]);

        }
    }

    public function getEdit(Request $request, $id)
    {
        $http_referer = $this->http_referer;
        $pre_url = $this->pre_url;

        if (empty($id)) {

            return Redirect::route('index')->withErrors(['msg' => '無此假單']);

        } 

        $model = $this->loadModel($id);

        if (empty($model)) {

            return Redirect::route('index')->withErrors(['msg' => '無此假單']);

        }

        $leave_response = LeaveResponse::getResponseByLeaveId($id);

        $leave_response_reverse = [];
        foreach($leave_response as $response) {
            $key = TimeHelper::changeDateValue($response->created_at,['+,8,hour'],'Y-m-d');

            $leave_response_reverse[$key][] = $response;

        }

        $leave_prove_process = LeaveHelper::getLeaveProveProcess($id);
        $leave_prove_tag_name = [];

        foreach ($leave_prove_process as $key => $leave_prove) {

            if ($key == 'agent') {

                $leave_prove_tag_name[$key]['id'] = 2;
                $leave_prove_tag_name[$key]['name'] = '代理人核准';

            } elseif ($key == 'minimanager') {

                $leave_prove_tag_name[$key]['id'] = 3;
                $leave_prove_tag_name[$key]['name'] = '小主管核准';

            } elseif ($key == 'manager') {

                if (empty($leave_prove_process['admin'])) {

                    $leave_prove_tag_name[$key]['id'] = 9;
                    $leave_prove_tag_name[$key]['name'] = '主管核准';

                } else {

                    $leave_prove_tag_name[$key]['id'] = 4;
                    $leave_prove_tag_name[$key]['name'] = '主管核准';

                }

            } elseif ($key == 'admin') {

                $leave_prove_tag_name[$key]['id'] = 9;
                $leave_prove_tag_name[$key]['name'] = '大ＢＯＳＳ核准';

            }

        }

        $leave_notice = LeaveNotice::getNoticeByLeaveId($id);

        $leave_agent = LeaveAgent::getAgentByLeaveId($id);
        
        return view('leave_view',compact(
            'pre_url','http_referer','model','leave_response','leave_response_reverse','leave_prove_process','leave_prove_tag_name','leave_notice','leave_agent'
        ));
    }

    public function postUpdate(Request $request)
    {
        $message = '';
        $input = $request->input('leave_response');
        $input['user_id'] = Auth::getUser()->id;

        $model = $this->loadModel($input['leave_id']);

        $leave_agent = LeaveAgent::getAgentByLeaveId($input['leave_id']);

        $leave_prove_process = LeaveHelper::getLeaveProveProcess($input['leave_id']);

        $leave_response = new LeaveResponse;

        //取消
        if (in_array($model->tag_id,['1','2']) && Auth::getUser()->id == $model->user_id) {

            //狀態=0代表取消不代理或不准假
            if (!empty($input['status'])) {

                $input['tag_id'] = '7';
                $message = '已取消';

            }
            
        //代理 
        } elseif ($model->tag_id == '1' && in_array(Auth::getUser()->id,$leave_agent->pluck('agent_id')->toArray())) {

            //狀態=0代表不代理
            if (empty($input['status'])) {

                $input['tag_id'] = '8';
                $message = '不代理';

            } else {

                $input['tag_id'] = '2';
                $message = '同意代理';

            }

        //小主管准假
        } elseif (in_array($model->tag_id,['2']) && !empty($leave_prove_process['minimanager']) && Auth::getUser()->id == $leave_prove_process['minimanager']->id) {

            //狀態=0代表不準假
            if (empty($input['status'])) {

                $input['tag_id'] = '8';
                $message = '不准該假單的申請';

            } else {

                $input['tag_id'] = '3';
                $message = '同意該假單的申請';

            }

        //主管准假
        } elseif (!empty($leave_prove_process['manager']) && Auth::getUser()->id == $leave_prove_process['manager']->id) {

            if (in_array($model->tag_id,['2','3'])) {

                //狀態=0代表不準假
                if (empty($input['status'])) {

                    $input['tag_id'] = '8';
                    $message = '不准該假單的申請';

                } else {

                        $input['tag_id'] = ($model->hours > ConfigHelper::getConfigValueByKey('boss_days')*8 ) ? '4' : '9';
                    $message = '同意該假單的申請';

                }

            } elseif($model->tag_id == '9') {

                //狀態=0代表取消
                if (!empty($input['status'])) {

                    $input['tag_id'] = '7';
                    $message = '已取消';

                }

            }
            

        //BOSS准假
        }  elseif (in_array($model->tag_id,['4']) && !empty(Auth::hasAdmin())) {

            //狀態=0代表不準假
            if (empty($input['status'])) {

                $input['tag_id'] = '8';
                $message = '不允許該假單的申請';

            } else {

                $input['tag_id'] = '9';
                $message = '允許該假單的申請';

            }


        } else  {

            return Redirect::route('leave/edit',['id' => $input['leave_id']])->withErrors(['msg' => $message.'無審核權限']);

        }

        $leave_response->fill($input);

        if ($leave_response->save()) {

            $model->fill(['tag_id' => $leave_response->tag_id]);

            if ($model->save()) {

                if (in_array($model->tag_id, ['2','3','4'])) {

                    LeaveHelper::syncCheckLeave($model->id,$input);

                }

                if ( in_array($model->tag_id, ['9']) ) {

                    //送通知給請假人
                    SlackHelper::notify(new UserLeaveSuccessSlack( $model->start_time , $model->end_time , $model->fetchUser->nickname )  );
                    $EmailHelper = new EmailHelper;
                    $EmailHelper->to = $model->fetchUser->email;
                    $EmailHelper->notify(new UserLeaveSuccessEmail( $model->start_time , $model->end_time ) );

                    //送通知給職代
                    $agent_list = LeaveAgent::getAgentByLeaveId($model->id);
                    if ( count( $agent_list ) != 0 ) {

                        foreach ( $agent_list as $key => $agent) {

                            SlackHelper::notify(new AgentLeaveSuccessSlack( $model->fetchUser->nickname , $model->start_time , $model->end_time , $agent->fetchUser->nickname )  );
                            $EmailHelper = new EmailHelper;
                            $EmailHelper->to = $agent->fetchUser->email;
                            $EmailHelper->notify(new AgentLeaveSuccessEmail( $model->fetchUser->nickname , $model->start_time , $model->end_time ) );

                        }

                    }

                }

                if ( in_array($model->tag_id, ['8']) ) {

                    //送通知給請假人
                    SlackHelper::notify(new UserLeaveReturnSlack( $model->start_time , $model->end_time , $model->fetchUser->nickname )  );
                    $EmailHelper = new EmailHelper;
                    $EmailHelper->to = $model->fetchUser->email;
                    $EmailHelper->notify(new UserLeaveReturnEmail( $model->start_time , $model->end_time ) );

                }

                if ( in_array($model->tag_id, ['7']) && $model->user_id != Auth::user()->id ) {

                    //送通知給請假人
                    SlackHelper::notify(new UserLeaveCancelSlack( $model->start_time , $model->end_time , $model->fetchUser->nickname )  );
                    $EmailHelper = new EmailHelper;
                    $EmailHelper->to =$model->fetchUser->email;
                    $EmailHelper->notify(new UserLeaveCancelEmail( $model->start_time , $model->end_time ) );

                    //送通知給職代
                    $agent_list = LeaveAgent::getAgentByLeaveId($model->id);
                    if ( count( $agent_list ) != 0 ) {

                        foreach ( $agent_list as $key => $agent) {

                            SlackHelper::notify(new AgentLeaveCancelSlack( $model->fetchUser->nickname , $model->start_time , $model->end_time , $agent->fetchUser->nickname )  );
                            $EmailHelper = new EmailHelper;
                            $EmailHelper->to = $agent->fetchUser->email;
                            $EmailHelper->notify(new AgentLeaveCancelEmail( $model->fetchUser->nickname , $model->start_time , $model->end_time ) );

                        }

                    }

                }

                return Redirect::back()->with('success', $message);

            } else {

                return Redirect::back()->withErrors(['msg' => $message.'失敗']);

            }

        } else {

            return Redirect::back()->withErrors(['msg' => $message.'失敗']);

        }

    }

    public function postUpload(Request $request)
    {
        $leave = [];
        $leave['id'] = $request->all()['id'];
        $leave['prove'] = $this->loadModel($leave['id'])->prove;

        if(Input::hasFile('fileupload')) {
            $file_name = AttachHelper::uploadFiles('fileupload','prove');

            if (!empty($file_name)) {

                if (!empty($leave['prove'])) {

                    $leave['prove'] .= ',' . implode(',' , $file_name);

                } else {

                    $leave['prove'] = implode(',' , $file_name);

                }

                $model = $this->loadModel($leave['id']);

                $model->fill($leave);
                
                if ($model->save()) {

                    $response['initialPreview'] = [UrlHelper::getLeaveProveUrl(implode(',' , $file_name))];
                    $response['initialPreviewConfig'] = [[
                        'caption' => implode(',' , $file_name),
                        'url' => route("leave/delete"),
                        'extra' => ["_token" => csrf_token(),
                          "id" => $model->id,
                          "file" => implode(',' , $file_name),
                        ]
                    ]];

                    return response()->json($response); 

                } else {

                    $response = array(
                      'message' => '更新資料庫失敗',
                    );
                    return response()->json($response); 

                }

            } else {

                $response = array(
                  'message' => '上傳證明失敗',
                );
                return response()->json($response); 

            }
        }
    }

    public function postDelete(Request $request)
    {
        $leave = [];
        $leave['id'] = $request->all()['id'];
        $prove = explode(',', $this->loadModel($leave['id'])->prove);

        $filename = $request->all()['file'];

        if (in_array($filename, $prove)) unset($prove[array_search($filename, $prove)]);

        if (AttachHelper::deleteFile($filename,'prove')) {

            $leave['prove'] = implode(',' , $prove);

            $model = $this->loadModel($leave['id']);

            $model->fill($leave);
            
            if ($model->save()) {

                $response = array(
                  'message' => '刪除成功',
                );
                return response()->json($response); 

            } else {

                $response = array(
                  'message' => '更新資料庫失敗',
                );
                return response()->json($response); 

            }

        } else {

            $response = array(
              'message' => '刪除檔案失敗',
            );
            return response()->json($response); 

        }
    }

    public function calculate_hours(Request $request)
    {
        $hours = 0;
        $date_range = $request->input('date_range');
        $start_time = explode(' - ', $date_range)['0'];
        $end_time = explode(' - ', $date_range)['1'];

        $date_list = LeaveHelper::calculateWorkingDate($start_time,$end_time);
        $hours = LeaveHelper::calculateRangeDateHours($date_list);

        $response = array(
          'hours' => $hours,
        );
        return response()->json($response);
    }

    public function createSickLeave($leave_day,$date_list,$user_id,$start_date,$end_date,$paid_sick_type,$sick_type)
    {
        //拆單前半
        $hours = LeaveHelper::calculateRangeDateHours($date_list);

        $remain_hours = LeaveHelper::getRemainHours($paid_sick_type,$hours);

        //有薪病假剩餘時數不足，拆單成一般病假與有薪病假
        if (LeaveHelper::checkLeaveTypeUsed($user_id,$start_date,$end_date,$paid_sick_type,$remain_hours)) {

            $used_paid_sick_hours = LeaveDay::getLeaveHoursByUserIdDateType($user_id,$start_date,$end_date,$paid_sick_type);

            $remain_paid_sick_hours = LeaveHelper::getRemainHours($paid_sick_type,$used_paid_sick_hours);

            //有薪病假start
            while ($remain_paid_sick_hours > 0 ) {

                $start_paid_sick_time = end($date_list)['start_time'];
                $end_paid_sick_time = TimeHelper::changeHourValue($start_paid_sick_time,['+,'.$remain_paid_sick_hours.',hour'],'Y-m-d H:i:s');

                //如果有薪假結尾時間大於當天時間，結尾改為當天時間
                if ($end_paid_sick_time > end($date_list)['end_time']) {

                    $end_paid_sick_time = end($date_list)['end_time'];

                }

                $hours = LeaveHelper::calculateOneDateHours($start_paid_sick_time,$end_paid_sick_time);

                $leave_day['type_id'] = $paid_sick_type;
                $leave_day['start_time'] = $start_paid_sick_time;
                $leave_day['end_time'] = $end_paid_sick_time;
                $leave_day['hours'] = $hours;

                $leave_day_model = new LeaveDay;
                $leave_day_model->fill($leave_day);

                if (!$leave_day_model->save()) {

                    return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                }

                //將有薪時數扣掉當天總時數，如果>=0代表當天已請完，將當天抽掉，在判斷前一天
                $the_day_hours = LeaveHelper::calculateRangeDateHours([end($date_list)]);
                $remain_paid_sick_hours -= $the_day_hours;

                if ($remain_paid_sick_hours >= 0) {

                    array_pop($date_list);

                }

            }
            //有薪病假end

            //將剛剛計算有薪病假那天剩餘的時數補上無薪病假
            if ($remain_paid_sick_hours < 0) {

                $start_sick_time = $leave_day_model->end_time;
                $end_sick_time = TimeHelper::changeHourValue($leave_day_model->end_time,['+,'.abs($remain_paid_sick_hours).',hour'],'Y-m-d H:i:s');

                $hours = LeaveHelper::calculateOneDateHours($start_sick_time,$end_sick_time);

                $leave_day['type_id'] = $sick_type;
                $leave_day['start_time'] = $start_sick_time;
                $leave_day['end_time'] = $end_sick_time;
                $leave_day['hours'] = $hours;

                $leave_day_model = new LeaveDay;
                $leave_day_model->fill($leave_day);
                if (!$leave_day_model->save()) {

                    return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                }

                array_pop($date_list);

            }

            //將剩餘的時數都補上無薪病假
            if (count($date_list) > 0) {

                foreach ($date_list as $key => $date) {

                    $hours = LeaveHelper::calculateOneDateHours($date['start_time'],$date['end_time']);

                    $leave_day['type_id'] = $sick_type;
                    $leave_day['start_time'] = $date['start_time'];
                    $leave_day['end_time'] = $date['end_time'];
                    $leave_day['hours'] = $hours;

                    $leave_day_model = new LeaveDay;
                    $leave_day_model->fill($leave_day);
                    if (!$leave_day_model->save()) {

                        return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                    }
                }

            }

        //有薪病假時數足夠，全部用有薪病假申請
        } else {

            foreach ($date_list as $date) {

                $hours = LeaveHelper::calculateOneDateHours($date['start_time'],$date['end_time']);

                $leave_day['type_id'] = $paid_sick_type;
                $leave_day['start_time'] = $date['start_time'];
                $leave_day['end_time'] = $date['end_time'];
                $leave_day['hours'] = $hours;

                $leave_day_model = new LeaveDay;
                $leave_day_model->fill($leave_day);

                if (!$leave_day_model->save()) {

                    return Redirect::back()->withInput()->withErrors(['msg' => '新增子單失敗']);

                }

            }

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
}
