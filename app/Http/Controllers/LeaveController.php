<?php

namespace App\Http\Controllers;

use LeaveHelper;
use TimeHelper;
use AttachHelper;
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
        $this->file_path = 'avatar/';
        $this->file_root_path = storage_path() . '/app/public/' . $this->file_path;
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request,$user_id= '') 
    {
        $user_id = (!empty($user_id)) ? $user_id : Auth::user()->id;

        $data = $request->old('leave');

        $model = new Leave;

        if (!empty($data)) {

            $model->fill($data);

        }

        $types = Type::getAllType();

        //使用者目前所有代理人
        $user_agents = UserAgent::getUserAgentByUserId($user_id);

        //全部團隊列表
        $teams = Team::getAllTeam();

        //除了使用者本身，所有人的團隊(額外通知)
        $user_no_team = $team_users = [];
        foreach(User::getAllUsersExcludeUserId($user_id) as $users){

            if ($users->UserTeam()->first()) {

                $team_users[] = $users->UserTeam()->first();

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

        if (count(explode(' - ', $leave['timepicker']))>1) {

            $leave['start_time'] = LeaveHelper::changeTimeByArriveTime(explode(' - ', $leave['timepicker'])['0'],$user->id);
            $leave['end_time'] = LeaveHelper::changeTimeByArriveTime(explode(' - ', $leave['timepicker'])['1'],$user->id);
            $leave['date_list'] = LeaveHelper::calculateWorkingDate($leave['start_time'],$leave['end_time']);
            $leave['hours'] = LeaveHelper::calculateRangeDateHours($leave['date_list']);

        } else {
            
            $leave['hours'] = ($leave['dayrange'] == 'allday') ? 8 : 4;

            if ($leave['dayrange'] == 'morning') {

                $leave['start_time'] = $leave['timepicker'] . $start;
                $leave['end_time'] = TimeHelper::changeHourValue($leave['start_time'],['+,4,hour'],'Y-m-d H:i:s');
                
            } elseif($leave['dayrange'] == 'afternoon') {

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
                } elseif(in_array($exception,['paid_sick','sick'])) {

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
                    'memo' => '提出請假申請',
                ]);
                $leave_response->save();

                return Redirect::route('index')->withErrors(['msg' => '新增成功']);

            } else {

                return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

            }

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => $response]);

        }
    }

    public function calculate_hours(Request $request){
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

            $used_paid_sick_hours = LeaveDay::getLeaveByUserIdDateType($user_id,$start_date,$end_date,$paid_sick_type);

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
}
