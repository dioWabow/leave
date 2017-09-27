<?php

namespace App\Http\Controllers;

use App\Type;
use App\Leave;
use App\LeaveDay;
use App\LeaveResponse;
use App\User;
use ImageHelper;
use ConfigHelper;
use UrlHelper;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class NaturalController extends Controller
{


    public function getIndex()
    {
        $natural_disasters = [];
        $natural_add = [];
        $natural_cancel = [];
        $input = [
            'type_id' => '',
            'date' => '',
            'range' => '',
        ];

        $natural_disasters = Type::getTypeInNaturalDisaster();

        $input['date'] = date("Y-m-d");

        return view('natural_disaster',compact(
            'natural_disasters', 'natural_add', 'natural_cancel', 'input'
        ));
    }

    public function getEdit(Request $request)
    {
        $natural_disasters = [];
        $natural_add = [];
        $natural_cancel = [];
        $natural_start_time = '';
        $natural_end_time = '';
        $natural_cancel_total = [
            'start_time' => '',
            'end_time' => '',
            'hours' => '',
        ];
        $natural_add_total = [
            'leave_hour_before' => 0,
            'natural_hour' => 0,
            'leave_hour_after' => 0,
        ];


        $input = $request->input('natural');
        if ( !empty($input['type_id']) && Type::checkTypeIdNaturalDisaster($input['type_id']) ) {

            if (!empty($input['date']) && !empty($input['range']) ) {

                switch ($input['range']) {
                    case 'all_day':
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        break;
                    case 'morning':
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('14:00'));
                        break;   
                    case 'afternoon':
                        $natural_start_time = date("H:i:s",strtotime('14:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        break;                        
                    default:
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        break;
                }

                $natural_disasters = Type::getTypeInNaturalDisaster();
                $natural_disasters_id = $natural_disasters->pluck('id')->ToArray();
                $natural_disasters_in_date = LeaveDay::getNaturalDisasterInDate($natural_disasters_id,$input['date']);

                //如果已有天災假,出現進行取消分頁
                if (!empty($natural_disasters_in_date->ToArray())) {

                    $natural_cancel_total['start_time'] = $natural_disasters_in_date->first()->start_time;
                    $natural_cancel_total['end_time'] = $natural_disasters_in_date->first()->end_time;
                    $natural_cancel_total['hours'] = $natural_disasters_in_date->first()->hours;


                    $not_natural_disasters_in_date = LeaveDay::getNotNaturalDisasterInDate($natural_disasters_id,$input['date']);

                    if (!empty($not_natural_disasters_in_date->ToArray())) {

                        foreach ($not_natural_disasters_in_date as $key => $not_natural_disaster_in_date) {

                            $natural_hours = $this->compute_natural_hours(
                                $not_natural_disaster_in_date->start_time,
                                $not_natural_disaster_in_date->end_time,
                                $natural_start_time,
                                $natural_end_time
                            );

                            $not_natural_disasters_in_date[$key]->natural_hours = $natural_hours;
                        }

                    }

                    $natural_cancel = $not_natural_disasters_in_date;

                //如果沒有天災假,出現進行新增分頁
                }else{

                    //找出是否有該天請假的假單
                    $not_natural_disasters_in_date = LeaveDay::getNotNaturalDisasterInDate($natural_disasters_id,$input['date']);

                    if (!empty($not_natural_disasters_in_date->ToArray())) {

                        foreach ($not_natural_disasters_in_date as $key => $not_natural_disaster_in_date) {

                            $natural_hours = $this->compute_natural_hours(
                                $not_natural_disaster_in_date->start_time,
                                $not_natural_disaster_in_date->end_time,
                                $natural_start_time,
                                $natural_end_time
                            );

                            $not_natural_disasters_in_date[$key]->natural_hours = $natural_hours;
                            $natural_add_total['leave_hour_before'] += $not_natural_disasters_in_date[$key]->hours;
                            $natural_add_total['natural_hour'] += $natural_hours;
                            $natural_add_total['leave_hour_after'] += ( $not_natural_disasters_in_date[$key]->hours - $natural_hours);
                        }

                    }

                    $natural_add = $not_natural_disasters_in_date;

                }

            }else{

                return Redirect::route('natural/index')->withErrors(['msg' => '請填寫完整資訊']);

            }

        }else{

            return Redirect::route('index')->withErrors(['msg' => '無此天災假別，請至假別設定']);

        }

        return view('natural_disaster',compact(
            'natural_disasters', 'natural_add', 'natural_cancel', 'natural_add_total', 'natural_cancel_total', 'input'
        ));
    }

     public function postUpdate(Request $request)
     {
        $natural_disasters = [];
        $natural_add = [];
        $natural_cancel = [];
        $natural_start_time = '';
        $natural_end_time = '';
        $natural_add_total = [
            'leave_hour_before' => 0,
            'natural_hour' => 0,
            'leave_hour_after' => 0,
        ];
        $natural_cancel_total = [
            'leave_hour_before' => 0,
            'natural_hour' => 0,
            'leave_hour_after' => 0,
        ];
        $natural_hours = 0;

        $input = $request->input('natural');
        if ( !empty($input['type_id']) && Type::checkTypeIdNaturalDisaster($input['type_id']) ) {

            if (!empty($input['date']) && !empty($input['range']) ) {

                switch ($input['range']) {
                    case 'all_day':
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        $natural_hours = 8;
                        break;
                    case 'morning':
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('14:00'));
                        $natural_hours = 4;
                        break;   
                    case 'afternoon':
                        $natural_start_time = date("H:i:s",strtotime('14:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        $natural_hours = 4;
                        break;                        
                    default:
                        $natural_start_time = date("H:i:s",strtotime('09:00'));
                        $natural_end_time = date("H:i:s",strtotime('18:00'));
                        $natural_hours = 8;
                        break;
                }

                $natural_disasters = Type::getTypeInNaturalDisaster();
                $natural_disasters_id = $natural_disasters->pluck('id')->ToArray();
                $natural_disasters_in_date = LeaveDay::getNaturalDisasterInDate($natural_disasters_id,$input['date']);

                //如果已有天災假,進行取消
                if ($input['update'] == 'cancel') {

                    $not_natural_disasters_in_date = LeaveDay::getNotNaturalDisasterInDate($natural_disasters_id,$input['date']);

                    if (!empty($not_natural_disasters_in_date->ToArray())) {

                        foreach ($not_natural_disasters_in_date as $key => $not_natural_disaster_in_date) {

                            $natural_hours_one = $this->compute_natural_hours(
                                $not_natural_disaster_in_date->start_time,
                                $not_natural_disaster_in_date->end_time,
                                $natural_start_time,
                                $natural_end_time
                            );

                            $not_natural_disasters_in_date[$key]->natural_hours = $natural_hours_one;
                        }

                    }

                    $error = $this->cancel_natural_leaves($natural_disasters_in_date, $not_natural_disasters_in_date);

                    if ($error) {
                        return Redirect::route('natural/index')->withErrors(['msg' => '新增異常']);
                    }else{
                        return Redirect::route('natural/index')->withErrors(['msg' => '取消成功']);
                    }

                //如果沒有天災假,進行新增
                }elseif ($input['update'] == 'add') {

                    //找出是否有該天請假的假單
                    $not_natural_disasters_in_date = LeaveDay::getNotNaturalDisasterInDate($natural_disasters_id,$input['date']);

                    if (!empty($not_natural_disasters_in_date->ToArray())) {

                        foreach ($not_natural_disasters_in_date as $key => $not_natural_disaster_in_date) {

                            $natural_hours_one = $this->compute_natural_hours(
                                $not_natural_disaster_in_date->start_time,
                                $not_natural_disaster_in_date->end_time,
                                $natural_start_time,
                                $natural_end_time
                            );

                            $not_natural_disasters_in_date[$key]->natural_hours = $natural_hours_one;
                        }

                    }

                    $error = $this->add_natural_leaves(
                        $input['date'],
                        $natural_start_time,
                        $natural_end_time,
                        $natural_hours,
                        $not_natural_disasters_in_date,
                        $input['type_id']
                    );

                    if ($error) {
                        return Redirect::route('natural/index')->withErrors(['msg' => '新增異常']);
                    }else{
                        return Redirect::route('natural/index')->withErrors(['msg' => '新增成功']);
                    }
                }

                

            }else{

                return Redirect::route('natural/index')->withErrors(['msg' => '請填寫完整資訊']);

            }

        }else{

            return Redirect::route('index')->withErrors(['msg' => '無此天災假別']);

        }
    }

    //計算拆單與天災假重疊的時間
    protected function compute_natural_hours($leave_start,$leave_end,$natural_start,$natural_end)
    {
        //將時間化為僅小時方便計算
        $leave_start_hour = date("G" , strtotime($leave_start) );
        $leave_end_hour = date("G" , strtotime($leave_end) );
        $natural_start_hour = date("G" , strtotime($natural_start) );
        $natural_end_hour = date("G" , strtotime($natural_end) );

        $compute_hours = 0;//假單中的天災假時間

        for (; $leave_start_hour < $leave_end_hour; $leave_start_hour++) { 
            
            if ( $leave_start_hour != 12 
                && $leave_start_hour >= $natural_start_hour 
                && $leave_start_hour < $natural_end_hour) {

                $compute_hours++;

            }

        }

        return $compute_hours;

    }

    protected function add_natural_leaves( $date , $natural_start_time , $natural_end_time , $natural_hour , $leave_list = [] , $type_id )
    {
        $user_list = User::getAllUsersWithoutLeaved();

        //為每個使用者新增天災假單
        $error = false;
        foreach ($user_list as $key => $user) {

            $leave['user_id'] = $user->id;
            $leave['type_id'] = $type_id;
            $leave['tag_id'] = 9;
            $leave['start_time'] = date( "Y-m-d H:i:s" , strtotime( $date .' '. $natural_start_time ) );
            $leave['end_time'] = date( "Y-m-d H:i:s" , strtotime( $date .' '. $natural_end_time ) );
            $leave['hours'] = $natural_hour;
            $leave['reason'] = '天災假新增';
            $leave['create_user_id'] = Auth::user()->id;

            $leave_model = new Leave;

            $leave_model->fill($leave);

            if ($leave_model->save()) {

                $leave_day_model = new LeaveDay;

                $leave_day['leave_id'] = $leave_model->id;
                $leave_day['type_id'] = $leave_model->type_id;
                $leave_day['create_user_id'] = $leave_model->create_user_id;
                $leave_day['user_id'] = $leave_model->user_id;
                $leave_day['start_time'] = $leave_model->start_time;
                $leave_day['end_time'] = $leave_model->end_time;
                $leave_day['hours'] = $leave_model->hours;

                $leave_day_model->fill($leave_day);
                if (!$leave_day_model->save()) {

                    $error = true;

                }

                //新增審核紀錄
                $leave_response = new LeaveResponse;
                $leave_response->fill([
                    'leave_id' => $leave_model->id,
                    'user_id' => $leave_model->create_user_id,
                    'tag_id' => '9',
                    'memo' => '天災假新增',
                ]);
                $leave_response->save();

            } else {

                $error = true;

            }
        }

        foreach ($leave_list as $key => $leave) {

            $this->leave_natural_hour($leave,'minus');
        }

        return $error;

    }

    protected function cancel_natural_leaves( $natural_leave_list ,$leave_list)
    {

        $error = false;
        foreach ($natural_leave_list as $key => $natural_leave) {

            $natural_leave_after['tag_id'] = 7;
            $leave_model = Leave::find( $natural_leave->id );
            $leave_model->fill( $natural_leave_after );
            $leave_model->save();

        }

        foreach ($leave_list as $key => $leave) {

            $this->leave_natural_hour($leave,'add');

        }
        return $error;
    }

    protected function leave_natural_hour($leave_day_before,$type)
    {
        if ($type == 'minus') {
            $leave_day_after['hours'] = ($leave_day_before->leave_hours - $leave_day_before->natural_hours);

            $leave_day_model = LeaveDay::find($leave_day_before->id);
            $leave_day_model->fill($leave_day_after);
            $leave_day_model->save();

            $leave_before = LeaveDay::getLeaveByLeaveDayId( $leave_day_before->id );

            $leave_day_after['hours'] = ( $leave_before->hours - $leave_day_before->natural_hours );

            $leave_model = Leave::find($leave_before->id);
            $leave_model->fill($leave_day_after);
            $leave_model->save();

        }elseif ($type == 'add') {
            $leave_day_after['hours'] = ($leave_day_before->leave_hours + $leave_day_before->natural_hours);

            $leave_day_model = LeaveDay::find($leave_day_before->id);
            $leave_day_model->fill($leave_day_after);
            $leave_day_model->save();

            $leave_before = LeaveDay::getLeaveByLeaveDayId( $leave_day_before->id );

            $leave_day_after['hours'] = ( $leave_before->hours + $leave_day_before->natural_hours );

            $leave_model = Leave::find($leave_before->id);
            $leave_model->fill($leave_day_after);
            $leave_model->save();

        }

    }
   
}
