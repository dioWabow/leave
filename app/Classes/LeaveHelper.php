<?php

namespace App\Classes;

use TimeHelper;
use App\Holiday;
use App\Leave;
use App\User;
use App\Type;
use App\Team;
use App\LeaveDay;
use App\UserTeam;
use App\AnnualHour;
use App\LeavedUser;

use App\LeaveAgent;
use App\LeaveResponse;

use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class LeaveHelper
{

    private  $user_id;
    private  $birthday;
    private  $enter_date;
    private  $job_seek;
    private  $arrive_time;

    public function __construct($id = '')
    {
        if (!empty(Auth::user())) {

            $this->user_id = Auth::user()->id;
            $this->birthday = Auth::user()->birthday;
            $this->enter_date = Auth::user()->enter_date;
            $this->job_seek = Auth::user()->job_seek;
            $this->arrive_time = Auth::user()->arrive_time;
            $this->annual_hours = Auth::user()->annual_hours;

        } 
    }

    public function calculateAnnualDate($start_date = '',$user_id = '') 
    {
        self::updateUser($user_id);
        
        $annual_date = 0;
        $annual_hours = 0;

        //計算年資
        $start_date_year = (empty($start_date)) ? Carbon::now()->format('Y') : TimeHelper::changeDateFormat($start_date,'Y');
        $enter_date_year = TimeHelper::changeDateFormat($this->enter_date,'Y');
        $service_year = intval($start_date_year - $enter_date_year );
        
        //計算使否足年
        $start_date_month = (empty($start_date)) ? Carbon::now()->format('m') : TimeHelper::changeDateFormat($start_date,'m');
        $enter_date_month = TimeHelper::changeDateFormat($this->enter_date,'m');
        $service_month = intval($start_date_month - $enter_date_month);
        
        //計算是否足月
        $start_date_day = (empty($start_date)) ? Carbon::now()->format('d') : TimeHelper::changeDateFormat($start_date,'d');
        $enter_date_day = TimeHelper::changeDateFormat($this->enter_date,'d');
        $service_day = intval($start_date_day - $enter_date_day);
    
        //當不足1年時，年資-1
        if (($start_date_month - $enter_date_month) <0 ) { //月份不足年資減1

            $service_year --;

        } elseif (($start_date_month - $enter_date_month) == 0) { //月份剛好相等

            if (($start_date_day - $enter_date_day) < 0) { //天數不足年資減1

                $service_year --;

            }

        }

        //按照年資發放特休
        switch ($service_year) {
            case 0:
                if ($start_date_year != $enter_date_year) {

                    $service_month += 12;

                    if ($service_month > 6) { //大於六個月發3天

                        $annual_date = 3;

                    } elseif ($service_month == 6 && $service_day >= 0) { //等於六個月先判斷是否足月，才發三天

                        $annual_date = 3;

                    }

                }
                break;
            case 1:
                $annual_date = 7;
                break;
            case 2:
                $annual_date = 10;
                break;
            case 3:
            case 4:
                $annual_date = 14;
                break;
            case ($service_year >= 5 && $service_year < 10):
                $annual_date = 15;
                break;
            case ($service_year >= 10): //大於10年 每年加一天 EX:第10年16天 11年17天...
                $annual_date = ($service_year + 6 < 30) ? $service_year + 6 : 30;
                break;
        }

        $annual_hours = $annual_date*8;

        return $annual_hours;
    }

    // 計算特休待審核時數
    public function calculateAuunalUsedHours($date = '',$user_id = '')
    {
        $user_id = (empty($date)) ? Auth::getUser()->id : $user_id;
        $date = (empty($date)) ? Carbon::now()->format('Y-m-d') : $date;

        self::updateUser($user_id);

        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        if (TimeHelper::changeDateFormat($date,'m-d') > TimeHelper::changeDateFormat($this->enter_date,'m-d')) {

            $start_time = TimeHelper::changeDateFormat($date,'Y') . TimeHelper::changeDateFormat($this->enter_date,'-m-d');
            $end_time = TimeHelper::changeDateValue($date,['+,1,year'],'Y') . TimeHelper::changeDateValue($this->enter_date,['-,1,day'],'-m-d');

        } else {

            $start_time = TimeHelper::changeDateValue($date,['-,1,year'],'Y') . TimeHelper::changeDateFormat($this->enter_date,'-m-d');
            $end_time = TimeHelper::changeDateFormat($date,'Y') . TimeHelper::changeDateValue($this->enter_date,['-,1,day'],'-m-d');

        }

        $in_check_annual_hours = LeaveDay::getLeaveInCheckHoursByUserIdDateType($user_id,$start_time,$end_time,$leave_type_arr);

        return $in_check_annual_hours;

    }

    // 算出可用特休時數
    public function calculateRemainAnnualHours($date = '',$user_id = '')
    {
        $user_id = (empty($date)) ? Auth::getUser()->id : $user_id;
        $date = (empty($date)) ? Carbon::now()->format('Y-m-d') : $date;

        self::updateUser($user_id);

        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        if (TimeHelper::changeDateFormat($date,'m-d') > TimeHelper::changeDateFormat($this->enter_date,'m-d')) {

            $start_time = TimeHelper::changeDateFormat($date,'Y') . TimeHelper::changeDateFormat($this->enter_date,'-m-d');
            $end_time = TimeHelper::changeDateValue($date,['+,1,year'],'Y') . TimeHelper::changeDateValue($this->enter_date,['-,1,day'],'-m-d');

        } else {

            $start_time = TimeHelper::changeDateValue($date,['-,1,year'],'Y') . TimeHelper::changeDateFormat($this->enter_date,'-m-d');
            $end_time = TimeHelper::changeDateFormat($date,'Y') . TimeHelper::changeDateValue($this->enter_date,['-,1,day'],'-m-d');

        }

        $remain_annual_hours = $this->annual_hours - LeaveDay::getPassLeaveHoursByUserIdDateType($user_id,$start_time,$end_time,$leave_type_arr) - self::calculateAuunalUsedHours($date , $user_id);

        return $remain_annual_hours;

    }

    //將一個區間的時間排除國定假日及放入補班之後輸出成陣列
    public function calculateWorkingDate($start_time,$end_time)
    {
        $date_list = [];

        //如果start_time跟end_time同一天 則直接輸出陣列
        if (TimeHelper::changeDateFormat($start_time,'Y-m-d') == TimeHelper::changeDateFormat($end_time,'Y-m-d')) {

            $date_list[0]['start_time'] = $start_time;
            $date_list[0]['end_time'] = $end_time;

        } else {

            //除了頭尾的日期將中間的日期取出，並判斷是否為補班或假日
            for ( $i = 1; TimeHelper::changeDateFormat($end_time,'Y-m-d') > TimeHelper::changeDateValue($start_time,['+,' . $i . ',day'],'Y-m-d'); $i++ ) {

                $date_list[$i-1]['start_time'] = TimeHelper::changeDateValue($start_time,['+,' . $i . ',day'],'Y-m-d') . ' 09:00';
                $date_list[$i-1]['end_time'] = TimeHelper::changeDateValue($start_time,['+,' . $i . ',day'],'Y-m-d') . ' 18:00';

            }

            foreach ($date_list as $key => $date) {

                if (in_array(TimeHelper::getWeekNumberByDate($date['start_time']),['0','6']) ) {

                    if (!Holiday::checkHolidayByDateAndType($date['start_time'],'work') > 0) {

                        unset($date_list[$key]);

                    }

                } else {

                    if (Holiday::checkHolidayByDateAndType($date['start_time'],'holiday') > 0) {

                        unset($date_list[$key]);

                    }

                }

            }

            //將頭尾日期補上
            $date_start['start_time'] = $start_time;
            $date_start['end_time'] = TimeHelper::changeDateFormat($start_time,'Y-m-d') . ' 18:00';
            $date_end['start_time'] = TimeHelper::changeDateFormat($end_time,'Y-m-d') . ' 09:00';
            $date_end['end_time'] = $end_time;

            array_unshift($date_list,$date_start);
            $date_list[] = $date_end;

        }

        return $date_list;

    }

    //計算一個range的時間
    public function calculateRangeDateHours($date_list) 
    {
        $hours = 0;

        foreach ($date_list as $date) {

            $hours += self::calculateOneDateHours($date['start_time'] , $date['end_time']);

        }

        return $hours;

    }

    //計算一天的時間
    public function calculateOneDateHours($start_time,$end_time)
    {
        $hours = 0;

        for ($i = intval(TimeHelper::changeDateFormat($start_time,'H'))+1 ; $i<= intval(TimeHelper::changeDateFormat($end_time,'H')) ; $i++ ) {

            if ($i != 13) {

                $hours ++;

            }

        }

        //如果開始時間為0分、結束時間為30分則加上一小時
        if (TimeHelper::changeDateFormat($start_time,'i') == 0 && TimeHelper::changeDateFormat($end_time,'i') == 30 ) {

            $hours ++;

        }

        return $hours;
    }

    public function getFrontDateAndBackDate ($start_time,$end_time,$dayrange,$leave_date)
    {
        if ($dayrange == 'morning') {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 1) {
                
                $front_date = TimeHelper::changeDateValue($start_time,['-,2,day'],'Y-m-d H:i:s');

            }

            $front_date = TimeHelper::changeHourValue($start_time,['-,15,hour'],'Y-m-d H:i:s');

            $back_date = $end_time;

        } elseif ($dayrange == 'afternoon') {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 5) {
               
                $back_date = TimeHelper::changeDateValue($end_time,['+,2,day'],'Y-m-d H:i:s');

            }

            $back_date = TimeHelper::changeHourValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            $front_date = $start_time;

        } else {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 5) {
               
                $front_date = TimeHelper::changeHourValue($start_time,['-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeDateValue($end_time,['+,2,day'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeHourValue($back_date,['+,15,hour'],'Y-m-d H:i:s');

            } elseif (TimeHelper::getWeekNumberByDate($leave_date) == 1) {
               
                $front_date = TimeHelper::changeDateValue($start_time,['-,2,day'],'Y-m-d H:i:s');
                $front_date = TimeHelper::changeHourValue($front_date,['-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeHourValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            } else {

                $front_date = TimeHelper::changeHourValue($start_time,['-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeHourValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            }

        }

        return ['front_date' => $front_date , 'back_date' => $back_date];

    }

    public function getFrontDateOrBackDate($date_time,$type)
    {
        if ($type == 'front') {

            if(TimeHelper::getWeekNumberByDate($date_time) == 1 && TimeHelper::changeDateFormat($date_time,'H') == '09') {

                $date = TimeHelper::changeDateValue($date_time,['-,2,day'],'Y-m-d H:i:s');
                $date = TimeHelper::changeHourValue($date,['-,15,hour'],'Y-m-d H:i:s');

            } elseif (TimeHelper::changeDateFormat($date_time,'H') == '09') {

                $date = TimeHelper::changeHourValue($date_time,['-,15,hour'],'Y-m-d H:i:s');

            } else {

                $date = $date_time;

            }

        } else {

            if(TimeHelper::getWeekNumberByDate($date_time) == 5 && TimeHelper::changeDateFormat($date_time,'H') == '18') {

                $date = TimeHelper::changeDateValue($date_time,['+,2,day'],'Y-m-d H:i:s');
                $date = TimeHelper::changeHourValue($date,['+,15,hour'],'Y-m-d H:i:s');

            } elseif (TimeHelper::changeDateFormat($date_time,'H') == '18') {

                $date = TimeHelper::changeHourValue($date_time,['+,15,hour'],'Y-m-d H:i:s');

            } else {

                $date = $date_time;

            }

        }

        return $date;

    }
            
    public function getStartDateAndEndDate($type_id,$date)
    {
        $reset_time = Type::find($type_id)->reset_time;

        $dt = Carbon::parse($date);
        switch ($reset_time) {

            case 'week':
                $start_date = $dt->startOfWeek()->format('Y-m-d H:i:s');
                $end_date = $dt->endOfWeek()->format('Y-m-d H:i:s');
                break;

            case 'month':
                $start_date = $dt->startOfMonth()->format('Y-m-d H:i:s');
                $end_date = $dt->endOfMonth()->format('Y-m-d H:i:s');
                break;

            case 'year':
                $start_date = $dt->startOfYear()->format('Y-m-d H:i:s');
                $end_date = $dt->endOfYear()->format('Y-m-d H:i:s');
                break;

            case 'none':
            case 'other':
                $start_date = $end_date = '';
                break;

            case 'season':
                if (in_array(TimeHelper::changeDateFormat($date,'m'),['1','2','3'])) {

                    $start_date = TimeHelper::changeDateFormat($date,'Y') . '-01-01 00:00:00';
                    $end_date = TimeHelper::changeDateFormat($date,'Y') . '-03-31 23:59:59';

                } elseif (in_array(TimeHelper::changeDateFormat($date,'m'),['4','5','6'])) {

                    $start_date = TimeHelper::changeDateFormat($date,'Y') . '-04-01 00:00:00';
                    $end_date = TimeHelper::changeDateFormat($date,'Y') . '-06-30 23:59:59';

                } elseif (in_array(TimeHelper::changeDateFormat($date,'m'),['7','8','9'])) {

                    $start_date = TimeHelper::changeDateFormat($date,'Y') . '-07-01 00:00:00';
                    $end_date = TimeHelper::changeDateFormat($date,'Y') . '-09-30 23:59:59';

                } elseif (in_array(TimeHelper::changeDateFormat($date,'m'),['10','11','12'])) {

                    $start_date = TimeHelper::changeDateFormat($date,'Y') . '-10-01 00:00:00';
                    $end_date = TimeHelper::changeDateFormat($date,'Y') . '-12-31 23:59:59';

                }
                break;

        }

        return ['start_date' => $start_date , 'end_date' => $end_date];
    }

    public function getStartDateAndEndDateByEnterDate($enter_date,$date)
    {
        $leave_year = TimeHelper::changeDateFormat($date,'Y');

        if (TimeHelper::changeDateFormat($date,'m-d') >= TimeHelper::changeDateFormat($enter_date,'m-d')) {

            $start_date = $leave_year . '-' . TimeHelper::changeDateFormat($enter_date,'m-d');
            $end_date = TimeHelper::changeDateValue($start_date,['+,1,year','-,1,day'],'Y-m-d');

        } else {

            $end_date = $leave_year . '-' . TimeHelper::changeDateValue($enter_date,['-,1,day'],'m-d');
            $start_date = TimeHelper::changeDateValue($end_date,['-,1,year','+,1,day'],'Y-m-d');

        }

        return ['start_date' => $start_date , 'end_date' => $end_date];
    }

    public function getRemainHours($type_id,$hours)
    {
        $remain_hours = Type::find($type_id)->hours;
        return $remain_hours - $hours;
    }

    public function getAnnulLeaveRemainHours($date,$hours,$user_id)
    {
        $remain_hours = self::calculateAnnualDate($date,$user_id);
        return $remain_hours - $hours;
    }

    //判斷有沒有請過某種假，時數也會判斷
    public function checkLeaveTypeUsed($user_id,$start_time,$end_time,$leave_type,$hours)
    {
        //如果結尾沒有時分秒 補上23:59:59
        if (!empty($end_time) &&TimeHelper::changeDateFormat($end_time,'H') == '00') {

            $end_time .= ' 23:59:59';

        }

        if (LeaveDay::getLeaveHoursByUserIdDateType($user_id,$start_time,$end_time,$leave_type)>$hours) {

            return true;

        }

        return false;
    }

    //判斷請假會不會與其他假別相連
    public function checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)
    {
        if (LeaveDay::getLeaveByUserIdEndTimeType($user_id,$front_date,$leave_type_arr)>0||LeaveDay::getLeaveByUserIdStartTimeType($user_id,$back_date,$leave_type_arr)>0) {

            return true;

        }

        return false;
    }

    //刪除請假時段沒空的代理人
    public function removeAgentByDate($agent_arr,$start_time,$end_time)
    {
        foreach ($agent_arr as $key => $agent_id) {

            if (LeaveDay::getLeaveByUserIdDateRangeType($agent_id,$start_time,$end_time,'') > 0) {

                unset($agent_arr[$key]);

            } 

        }

        return $agent_arr;
    }

    //更新判斷人資料
    public function updateUser($user_id)
    {
        if (!empty($user_id)) {

            $user = User::find($user_id);
            $this->user_id = $user->id;
            $this->birthday = $user->birthday;
            $this->enter_date = $user->enter_date;
            $this->job_seek = $user->job_seek;
            $this->arrive_time = $user->arrive_time;
            $this->annual_hours = $user->annual_hours;

        }
    }


    public function judgeLeave($leave,$user_id = '')
    {
        self::updateUser($user_id);

        $start = ' 09:00';
        $end = ' 18:00';

        $agent_arr = (!empty($leave['agent'])) ? $leave['agent'] : [];
        $leave_date = $leave['timepicker'];
        $start_time = $leave['start_time'];
        $end_time = $leave['end_time'];
        $date_list = (!empty($leave['date_list'])) ? $leave['date_list'] : [];
        $leave_type = Type::find($leave['type_id']);
        $leave_name = $leave_type->name;

        $response = '';

        //請假不得往前請
        if (TimeHelper::changeDateFormat($start_time,'Y-m-d') < Carbon::now()->format('Y-m-d')) {

            $response = '不得請以前的假';
            return $response;

        }

        //當天是否請過假
        if (LeaveDay::getLeaveByUserIdDateRangeType($this->user_id,$start_time,$end_time,'') > 0) {

            $response = '該時段已經請假';
            return $response;

        }

        //假是否有設定使用區間
        if (!empty($leave_type->start_time) && !empty($leave_type->end_time)) {

            if ($leave_type->start_time > $start_time) {

                $response = '請確認該假別請假區間';
                return $response;

            }

            if ($leave_type->end_time < $end_time) {

                $response = '請確認該假別請假區間';
                return $response;

            }

        }

        switch ($leave_type->exception) {

            //善待假
            case 'entertain':
                //善待假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['end_date'];

                $hours = ($leave['dayrange']=='allday') ? 8 : 4 ;
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = intval(TimeHelper::changeDateFormat($leave_date,'m')) . '月已經請過' . $leave_name;
                    return $response;
                    break;

                }

                //善待假是否與特休、生日、久任、國定假日相連
                $leave_type_arr = [];
                foreach (Type::getTypeByException(['birthday','annual_leave','lone_stay']) as $type) {

                    $leave_type_arr[] = $type->id;

                }

                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($this->user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . '不可與特定假別連著請';
                    return $response;
                    break;

                }

                if (Holiday::checkHolidayByDateAndType(TimeHelper::changeDateFormat($front_date,'Y-m-d'),'holiday')>0 || Holiday::checkHolidayByDateAndType(TimeHelper::changeDateFormat($back_date,'Y-m-d'),'holiday')>0) {

                    $response = $leave_name . '不可與國定假日連著請';
                    return $response;
                    break;

                }
                
                break;

            //生日假
            case 'birthday':
                //是否有設定生日
                if (empty($this->birthday) || $this->birthday == '0000-00-00') {

                    $response = '尚未設定生日，請洽公司HR';
                    return $response;
                    break;

                }

                //當月是否為生日月
                if (TimeHelper::changeDateFormat($this->birthday,'m') != TimeHelper::changeDateFormat($leave_date,'m')) {
                    
                    $response = intval(TimeHelper::changeDateFormat($leave_date,'m')) . '月不是你的生日';
                    return $response;
                    break;

                }

                //生日假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['end_date'];
                $leave_year = TimeHelper::changeDateFormat($leave_date,'Y');

                $hours = 8; //生日假半天全天都用八小帶入
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = $leave_year . '已經請過' . $leave_name;
                    return $response;
                    break;

                }

                //生日假不可與善待假連著請
                $leave_type_arr = [];
                foreach (Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }
                
                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($this->user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . '不可與善待假連著請';
                    return $response;
                    break;

                }

                break;

            //特休
            case 'annual_leave':
                //特休剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$start_time)['start_date'];
                $end_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$start_time)['end_date'];

                $new_date_list = [];

                foreach ($date_list as $key => $date) {

                    if (TimeHelper::changeDateFormat($date['start_time'],'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                        $new_date_list[] = $date;
                        unset($date_list[$key]);

                    }

                }

                $hours = self::calculateRangeDateHours($date_list);
                $remain_hours = self::getAnnulLeaveRemainHours($start_date,$hours,$user_id);

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response =  $leave_name . '剩餘時數不足';
                    return $response;
                    break;

                }

                if (count($new_date_list)>0) {

                    $start_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$new_date_list['0']['start_time'])['start_date'];
                    $end_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$new_date_list['0']['start_time'])['end_date'];

                    $hours = self::calculateRangeDateHours($new_date_list);
                    $remain_hours = self::getAnnulLeaveRemainHours($start_date,$hours,$user_id);

                    if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                        $response =  $leave_name . '剩餘時數不足';
                        return $response;
                        break;

                    }

                }

                //特休不可與善待假連著請
                $leave_type_arr = [];
                foreach (Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }

                $front_date = self::getFrontDateOrBackDate($start_time,'front');
                $back_date = self::getFrontDateOrBackDate($end_time,'back');

                if (self::checkLeaveByType($this->user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . '不可與善待假連著請';
                    return $response;
                    break;

                }

                break;

            //久任
            case 'lone_stay':    
                //請假當月年資是否滿兩年
                if (self::calculateAnnualDate($leave_date,$user_id) < 80) {

                    $response = '年資未滿兩年，無法使用' . $leave_name;
                    return $response;
                    break;

                }

                //久任假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDateByEnterDate($this->enter_date,$leave_date)['end_date'];

                $hours = 8; //久任假半天或全天都用8小時帶入
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = $start_date . '~' . $end_date . '間已經請過' . $leave_name;
                    return $response;
                    break;

                }

                //久任不可與善待假連著請
                $leave_type_arr = [];
                foreach (Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }
                
                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($this->user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . '不可與善待假連著請';
                    return $response;
                    break;

                }

                break;

            //謀職假
            case 'job_seek':
                //謀職假開關是否打開
                if ($this->job_seek == 0) {

                    $response = $leave_name . '尚未開啟';
                    break;

                }

                //謀職假剩餘時數是否足夠
                $response = self::checkLeaveEnough($leave['type_id'],$start_time,$date_list,$leave_name);

                break;

            //有薪病假、病假無需判斷
            case 'paid_sick':
            case 'sick':
                $response = '';
                break;

            default:
                //時數是否足夠
                $response = self::checkLeaveEnough($leave['type_id'],$start_time,$date_list,$leave_name);
        }

        //檢查理由是否必填
        if ($leave_type->reason) {

            if (empty($leave['reason'])) {

                $response = '請填請假理由';
                return $response;

            }

        }

        //檢查證明是否需要
        if ($leave_type->prove) {

            if (!Input::hasFile('fileupload')) {

                $response = '請上傳請假證明';
                return $response;

            }

        }

        //檢查代理人時間是否有衝突
        if (count($agent_arr) != 0 && count(self::removeAgentByDate($agent_arr,$start_time,$end_time)) == 0 ){

            $response = '代理人都已請假';
            return $response;

        }

        return $response;
    }

    public function checkLeaveEnough ($leave_type_id,$start_time,$date_list,$leave_name) 
    {

        $start_date = self::getStartDateAndEndDate($leave_type_id,$start_time)['start_date'];
        $end_date = self::getStartDateAndEndDate($leave_type_id,$start_time)['end_date'];

        if (empty($start_date) && empty($end_date)) {

            $hours = self::calculateRangeDateHours($date_list);
            $remain_hours = self::getRemainHours($leave_type_id,$hours);

            //當重製時間為none，時數上限為0代表不限制請假時數，不需判斷
            if (($hours + $remain_hours) != 0) {

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave_type_id,$remain_hours)) {

                    $response =  $leave_name . '剩餘時數不足';
                    return $response;

                }

            } else {

                $response = '';
                return $response;

            }

        } else {

            $new_date_list = [];

            foreach ($date_list as $key => $date) {

                if (TimeHelper::changeDateFormat($date['start_time'],'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                    $new_date_list[] = $date;
                    unset($date_list[$key]);

                }

            }

            $hours = self::calculateRangeDateHours($date_list);
            $remain_hours = self::getRemainHours($leave_type_id,$hours);

            if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave_type_id,$remain_hours)) {

                $response =  $leave_name . '剩餘時數不足';
                return $response;

            }

            if (count($new_date_list) > 0) {

                $start_date = self::getStartDateAndEndDate($leave_type_id,$new_date_list['0']['start_time'])['start_date'];
                $end_date = self::getStartDateAndEndDate($leave_type_id,$new_date_list['0']['start_time'])['end_date'];

                $hours = self::calculateRangeDateHours($new_date_list);
                $remain_hours = self::getRemainHours($leave_type_id,$hours);

                if (self::checkLeaveTypeUsed($this->user_id,$start_date,$end_date,$leave_type_id,$remain_hours)) {

                    $response =  $leave_name . '剩餘時數不足';
                    return $response;

                }

            } 

        }

    }

    /**
    * 1. 取得登入者
    * 2. boss tag 4 total leaves
    * 3. manager tag 3 & 主管team下的user total leaves
    * 3. mini_manager tag 2 & 小主管team下的user total leaves
    * 
    */
    public static function getProveManagerLeavesTabLable($role)
    {
        if ($role == 'admin' && !empty(Auth::hasAdmin())) {

            return self::getAdminLeavesTotal();

        } elseif ($role == 'manager' && !empty(Auth::hasManagement())) {

            return self::getManagerAllLeavesTotal();

        } elseif ($role == 'minimanager' && !empty(Auth::hasMiniManagement())) {

            return self::getMiniManagerLeavesTotal();

        } 
    }

    /**
    * 取得大BOSS的待審核假單
    * 
    */
    private static function getAdminLeavesTotal()
    {
        $model = new Leave;
        $search['tag_id'] = ['4'];
        $search['hours'] = '24';
        $result = $model->searchForProveInManager($search)->count();
        return $result;
    }

    /**
    * 取得主管子團隊以及所屬團隊的待審核假單總數量
    * 
    */
    private static function getManagerAllLeavesTotal() 
    {
        $result = self::getManagerSubTeamLeavesTotal() + self::getManagerTeamsLeavesTotal();
        return $result;
    }

    /**
    * 取得主管子團隊待審核假單數量
    * 
    */
    private static function getManagerSubTeamLeavesTotal()
    {
        $teams = Auth::hasManagement();
        $teams_id = Team::getTeamsByManagerTeam($teams);
        $user_id = UserTeam::getUserByTeams($teams_id);
        $tag_id = ['3'];
        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    /**
    * 取得主管所屬團隊待審核假單數量
    * 
    */
    private static function getManagerTeamsLeavesTotal()
    {
        $teams = Auth::hasManagement();
        $user_id = UserTeam::getUserByTeams($teams);
        $tag_id = ['2'];
        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }

    /**
    * 取得小主管所屬團隊下的假單數量
    * 
    */
    private static function getMiniManagerLeavesTotal()
    {
        $teams = Auth::hasMiniManagement();
        $user_id = UserTeam::getUserByTeams($teams);
        $tag_id = ['2'];

        $result = Leave::where('tag_id', $tag_id)->whereIn('user_id', $user_id)->count();
        return $result;
    }
 
    /**
    * 傳入該代理人的agent_id(Auth::user()->id)
    * 
    * 取得該代理人所代理的的假單數量
    * 
    */
    public static function getAgentLeavesTotal()
    {
        $id = Auth::user()->id;
        $today = Carbon::now();
        $leave_id = LeaveAgent::getLeaveIdByUserId($id);
        $result = Leave::whereIn('id', $leave_id)->where('start_time', '>=' ,$today)->count();
        return $result;
    }
    

/**
    * 我的假單
    * 取得 user的等待核准假單數量
    * tag 狀態 1,2,3,4
    * 
    */
    public static function getProveMyLeavesTotalByUserId()
    {
        $model = new Leave;
        $search['user_id'] = Auth::user()->id;
        $search['tag_id'] = ['1','2','3','4'];
        $result = $model->searchForProveAndUpComInMy($search)->count();
        return $result;
    }

/**
    * 我的假單
    * 取得 user的即將放假假單數量
    * tag 狀態 9
    * 
    */
    public static function getUpComingMyLeavesTotalByUserId()
    {
        $model = new Leave;
        $search['user_id'] = Auth::user()->id;
        $search['tag_id'] = ['9'];
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        $result = $model->searchForProveAndUpComInMy($search)->count();
        return $result;
    }

    /**
        * 計算HR可查看等待審核的假單
        * tag 狀態 1,2,3,4
        * 
        */
    public static function getHrProveLeavesTotal()
    {
        $tag_id = ['1','2','3','4'];
        $result = Leave::whereIn('tag_id', $tag_id)->count();
        return $result;
    }
    
    /*
        * 計算HR可查看即將放假的假單
        * tag 狀態 9
        * 
        */
    public static function getHrUpComingLeavesTotal()
    {
        $model = new Leave;
        $search['tag_id'] = ['9'];
        $search['start_time'] = Carbon::now()->format('Y-m-d');
        $result = $model->searchForProveAndUpComInHr($search)->count();
        return $result;
    }

    /**
     * 取得該主管
     * 找到審核通過的假單
     * tag 狀態 9
     */
    public static function getUpComingManagerLeavesTotal()
    {
        $tag_id = ['9'];
        $search['id'] = LeaveResponse::getLeavesIdByUserIdAndTagId(Auth::user()->id, $tag_id);
        $search['start_time'] = Carbon::now()->format('Y-m-d');

        $model = new Leave;
        $result = $model->searchForUpComingInManager($search)->count();
        return $result;
    }
    
    /**
     * 傳入start_time 取得 倒數天數
     * 
     * 
     */
    public function getDiffDaysLabel($data)
    {
        $today = Carbon::now();
        $start_time = Carbon::parse($data);
        $result = '';

        if ($start_time->gte($today))  {

            $result = $today->diffInDays(Carbon::parse($start_time));

        } 

        return $result;
    }

    /**
     * 傳入 dataProvider 取得 假單排除狀態 tag 7(取消) 的時數總和
     * 
     */
    public static function getLeavesHoursTotal($data)
    {
        return $data->whereNotIn('tag_id','7')->sum('hours');
    }
    
    /**
     * 傳入該代理人的user_id
     * 找到該代理人的所代理的假單
     * 確認假單在 tag 1 (代理人待核)
     * 取得代理假單的總數
     */
    public static function getAgentApproveLeavesTotal()
    {
        $id = Auth::user()->id;
        $tag_id = '1';
        
        $leave_id = LeaveAgent::getLeaveIdByUserId($id);
        $result = Leave::whereIn('id', $leave_id)->where('tag_id', $tag_id)->count();
        return $result;
    }
    
    public function getLeaveProveProcess($id)
    {
        $leave_prove_process = [];

        $leave_user_id = Leave::find($id)->user_id;

        // 判斷有沒有代理人審核
        $leave_response = LeaveResponse::getResponseByLeaveIdAndTagId($id , '2');
        if (count($leave_response) > 0) {

            //如果有就走該代理人後續的審核流程顯示
            $agent_user_id = $leave_response->first()->user_id;

        } else {

            //如果沒有找尋其中一個代理人顯示
            if (count(LeaveAgent::getAgentByLeaveId($id)) > 0) {

                $agent_user_id = LeaveAgent::getAgentByLeaveId($id)->first()->agent_id;

            }

        }

        if (!empty($agent_user_id)) {

            $leave_prove_process['agent'] = User::find($agent_user_id);

        }

        //請假人team id
        if (count(UserTeam::getTeamIdByUserIdAndRole($leave_user_id,'user')) > 0) {

            $leave_user_team_id = UserTeam::getTeamIdByUserIdAndRole($leave_user_id,'user')->first()->team_id;

            //請假人team裡的主管id
            if (count(UserTeam::getUserIdByTeamIdAndRole($leave_user_team_id,'manager')) > 0 ) {
                $team_manger_id = UserTeam::getUserIdByTeamIdAndRole($leave_user_team_id,'manager')->first()->user_id;

                //請假人的parent_team id
                $team_parent_id = Team::find($leave_user_team_id)->parent_id;

                if (empty($team_parent_id)) {

                    $leave_prove_process['manager'] = User::find($team_manger_id);

                } else {

                    $leave_prove_process['minimanager'] = User::find($team_manger_id);

                    $leave_prove_process['manager'] = User::find(UserTeam::getUserIdByTeamIdAndRole($team_parent_id,'manager')->first()->user_id);

                }

            }

        }

        if (Leave::find($id)->hours > 24 && count(User::getUserByRole('admin')) > 0 ) {

            $leave_prove_process['admin'] = User::getUserByRole('admin')->first();

        }

        return $leave_prove_process;

    }

    //同步向上審核
    public function syncCheckLeave($leave_id,$input)
    {
        $leave_prove = self::getLeaveProveProcess($leave_id);
        $agent_user_id = Auth::getUser()->id;

        while(true){

            $leave = Leave::find($leave_id);

            $leave_response = new LeaveResponse;

            if ($leave->tag_id == '2') {

                if (!empty($leave_prove['minimanager'])) {

                    if ($leave_prove['minimanager']->id == $agent_user_id) {

                        $input['tag_id'] = '3';

                        $leave_response->fill($input);
                        if ($leave_response->save()) {

                            $leave->fill(['tag_id' => $leave_response->tag_id]);
                            $leave->save();

                        }

                    } else {

                        break;

                    }

                } else {

                    if ($leave_prove['manager']->id == $agent_user_id) {

                        $input['tag_id'] = ($leave->hours < 24) ?'9' : '4';

                        $leave_response->fill($input);
                        if ($leave_response->save()) {

                            $leave->fill(['tag_id' => $leave_response->tag_id]);
                            $leave->save();

                        }

                    } else {

                        break;

                    }

                }

            } elseif ($leave->tag_id == '3') {

                if ($leave_prove['manager']->id == $agent_user_id) {

                    $input['tag_id'] = ($leave->hours < 24) ?'9' : '4';

                    $leave_response->fill($input);
                    if ($leave_response->save()) {

                        $leave->fill(['tag_id' => $leave_response->tag_id]);
                        $leave->save();

                    }

                } else {

                    break;

                }

            } elseif ($leave->tag_id == '4') {

                if ($leave_prove['admin']->id == $agent_user_id) {

                    $input['tag_id'] = '9';

                    $leave_response->fill($input);
                    if ($leave_response->save()) {

                        $leave->fill(['tag_id' => $leave_response->tag_id]);
                        $leave->save();

                    }

                }

                break;

            } else {

                break;

            }

        }
    }
}
