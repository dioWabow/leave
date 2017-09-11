<?php

namespace App\Classes;

use App\Holiday;
use App\Leave;
use App\LeaveDay;
use App\User;
use App\Type;
use TimeHelper;

use Session;
use Carbon\Carbon;

class LeaveHelper
{
    public static function homePageURL()
    {
      return url('/');
    }

    public static function calculateAnnualDate($start_date = "2017-08-31 00:00:00") 
    {
        $enter_date = '2014-11-07 00:00:00';
        $annual_date = 0;
        $annual_hours = 0;

        // 計算年資
        $start_date_year = ($start_date=='') ? Carbon::now()->format('Y') : TimeHelper::changeDateFormat($start_date,'Y');
        $enter_date_year = TimeHelper::changeDateFormat($enter_date,'Y');
        $service_year = intval($start_date_year - $enter_date_year );

        // 計算使否足年
        $start_date_month = ($start_date=='') ? Carbon::now()->format('m') : TimeHelper::changeDateFormat($start_date,'m');
        $enter_date_month = TimeHelper::changeDateFormat($enter_date,'m');
        $service_month = intval($start_date_month - $enter_date_month);

        // 計算是否足月
        $start_date_day = ($start_date=='') ? Carbon::now()->format('d') : TimeHelper::changeDateFormat($start_date,'d');
        $enter_date_day = TimeHelper::changeDateFormat($enter_date,'d');
        $service_day = intval($start_date_day - $enter_date_day);

        // 當不足1年時，年資-1
        if (($start_date_month - $enter_date_month) <0 ) { //月份不足年資減1

            $service_year --;

        } elseif (($start_date_month - $enter_date_month) == 0) { //月份剛好相等

            if (($start_date_day - $enter_date_day) < 0) { //天數不足年資減1

                $service_year --;

            }

        }

        // 按照年資發放特休
        switch ($service_year) {
            case 0:
                if ($start_date_year != $enter_date_year) {

                    $service_month += 12;

                    if ($service_month > 6) { // 大於六個月發3天

                        $annual_date = 3;

                    } elseif($service_month == 6 && $service_day >= 0) { // 等於六個月先判斷是否足月，才發三天

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

    //將一個區間的時間排除國定假日及放入補班之後輸出成陣列
    public static function calculateWorkingDate($start_time,$end_time)
    {
        $date_list = [];

        // 除了頭尾的日期將中間的日期取出，並判斷是否為補班或假日
        for ( $i = 1; TimeHelper::changeDateFormat($end_time,'Y-m-d') > TimeHelper::changeDateValue($start_time,['+,' . $i . ',day'],'Y-m-d'); $i++ ) {

            $date_list[] = TimeHelper::changeDateValue($start_time,['+,' . $i . ',day'],'Y-m-d');

        }

        foreach($date_list as $key => $date) {

            if (in_array(TimeHelper::getWeekNumberByDate($date),['0','6']) ) {

                if (!Holiday::checkHolidayByDateAndType($date,'work')>0) {

                    unset($date_list[$key]);

                }

            } else {

                if (Holiday::checkHolidayByDateAndType($date,'holiday')>0) {

                    unset($date_list[$key]);

                }

            }

        }

        //將頭尾日期補上
        array_unshift($date_list,$start_time);
        $date_list[] = $end_time;

        return $date_list;
    }

    //計算一個range的時間
    public static function calculateRangeDateHours($date_list) 
    {
        $user_id = 6;
        $hours = 0;
        $start_time = $date_list['0'];
        $end_time = end($date_list);

        $user = User::find($user_id);

        if (TimeHelper::changeDateFormat($start_time,'Y-m-d') == TimeHelper::changeDateFormat($end_time,'Y-m-d')) {

            $hours = self::calculateOneDateHours($start_time,$end_time);

        } else {

            if ($user->arrive_time=='0900') {

                $arrive_time = '09:00:00';
                $leave_time = '18:00:00';

                if (TimeHelper::changeDateFormat($start_time,'H') == 0) {

                    $start_time .= '09:00:00';

                }

                if (TimeHelper::changeDateFormat($end_time,'H') == 0) {

                    $end_time .= '18:00:00';

                }

            } else {

                $arrive_time = '09:30:00';
                $leave_time = '18:30:00';

                if (TimeHelper::changeDateFormat($start_time,'H') == 0) {

                    $start_time .= '09:30:00';

                }

                if (TimeHelper::changeDateFormat($end_time,'H') == 0) {

                    $end_time .= '18:30:00';

                }

            }

            $hours += self::calculateOneDateHours($start_time , $leave_time);   //開始
            $hours += self::calculateOneDateHours($arrive_time , $end_time);    //結束
            $hours += (count($date_list) - 2) * 8;                              //中間

        }

        return $hours;
    }

    //計算一天的時間
    public static function calculateOneDateHours($start_time,$end_time)
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

    public static function getFrontDateAndBackDate ($start_time,$end_time,$dayrange,$leave_date)
    {
        if ($dayrange == 'morning') {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 1) {
                
                $front_date = TimeHelper::changeDateValue($start_time,['-,2,day','-,15,hour'],'Y-m-d H:i:s');

            } else {

                $front_date = TimeHelper::changeDateValue($start_time,['-,15,hour'],'Y-m-d H:i:s');

            }

            $back_date = $end_time;

        } elseif($dayrange == 'afternoon') {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 5) {
               
                $back_date = TimeHelper::changeDateValue($end_time,['+,2,day','+,15,hour'],'Y-m-d H:i:s');

            } else {

                $back_date = TimeHelper::changeDateValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            }

            $front_date = $start_time;

        } else {

            if (TimeHelper::getWeekNumberByDate($leave_date) == 5) {
               
                $front_date = TimeHelper::changeDateValue($start_time,['-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeDateValue($end_time,['+,2,day','+,15,hour'],'Y-m-d H:i:s');


            } elseif(TimeHelper::getWeekNumberByDate($leave_date) == 1) {
               
                $front_date = TimeHelper::changeDateValue($start_time,['-,2,day','-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeDateValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            } else {

                $front_date = TimeHelper::changeDateValue($start_time,['-,15,hour'],'Y-m-d H:i:s');
                $back_date = TimeHelper::changeDateValue($end_time,['+,15,hour'],'Y-m-d H:i:s');

            }

        }

        return ['front_date' => $front_date , 'back_date' => $back_date];

    }

    public static function getFrontDateOrBackDate($date_time,$type)
    {
        if ($type == 'front') {

            if(TimeHelper::getWeekNumberByDate($date_time) == 1 && TimeHelper::changeDateFormat($date_time,'H') == "09") {

                $date = TimeHelper::changeDateValue($date_time,['-,2,day','-,15,hour'],'Y-m-d H:i:s');

            } elseif(TimeHelper::changeDateFormat($date_time,'H') == "09") {

                $date = TimeHelper::changeDateValue($date_time,['-,15,hour'],'Y-m-d H:i:s');

            } else {

                $date = $date_time;

            }

        } else {

            if(TimeHelper::getWeekNumberByDate($date_time) == 5 && TimeHelper::changeDateFormat($date_time,'H') == "18") {

                $date = TimeHelper::changeDateValue($date_time,['+,2,day','+,15,hour'],'Y-m-d H:i:s');

            } elseif(TimeHelper::changeDateFormat($date_time,'H') == "18") {

                $date = TimeHelper::changeDateValue($date_time,['+,15,hour'],'Y-m-d H:i:s');

            } else {

                $date = $date_time;

            }

        }

        return $date;

    }

    public static function getStartDateAndEndDate($type_id,$date)
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
                $start_date = $end_date = "";
        }

        return ['start_date' => $start_date , 'end_date' => $end_date];
    }

    public static function getStartDateAndEndDateByEnterDate($enter_date,$date)
    {
        $leave_year = TimeHelper::changeDateFormat($date,'Y');

        if (TimeHelper::changeDateFormat($date,'m-d') >= TimeHelper::changeDateFormat($enter_date,'m-d')) {

            $start_date = $leave_year . "-" . TimeHelper::changeDateFormat($enter_date,'m-d');
            $end_date = TimeHelper::changeDateValue($start_date,['+,1,year','-,1,day'],'Y-m-d');

        } else {

            $end_date = $leave_year . "-" . TimeHelper::changeDateValue($enter_date,['-,1,day'],'m-d');
            $start_date = TimeHelper::changeDateValue($end_date,['-,1,year','+,1,day'],'Y-m-d');

        }

        return ['start_date' => $start_date , 'end_date' => $end_date];
    }

    public static function getRemainHours($type_id,$hours)
    {
        $remain_hours = Type::find($type_id)->hours;
        return $remain_hours - $hours;
    }

    public static function getAnnulLeaveRemainHours($date,$hours)
    {
        $remain_hours = self::calculateAnnualDate($date);
        return $remain_hours - $hours;
    }

    //判斷有沒有請過某種假，時數也會判斷
    public static function checkLeaveTypeUsed($user_id,$start_time,$end_time,$leave_type,$hours)
    {
        //如果結尾沒有時分秒 補上23:59:59
        if (TimeHelper::changeDateFormat($end_time,"H") == "00") {

            $end_time .= " 23:59:59";

        }

        if (LeaveDay::checkLeaveByUserIdDateTypeHours($user_id,$start_time,$end_time,$leave_type,$hours)>0) {

            return true;

        }

        return false;
    }

    //判斷請假會不會與其他假別相連
    public static function checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)
    {
        if (LeaveDay::checkLeaveByUserIdEndTimeType($user_id,$front_date,$leave_type_arr)>0||LeaveDay::checkLeaveByUserIdStartTimeType($user_id,$back_date,$leave_type_arr)>0) {

            return true;

        }

        return false;
    }

    public static function judgeLeave($leave)
    {
        $user_id = 6;
        $birthday = '1992-11-14';
        $enter_date = '2016-11-07';
        $job_seek = 1;
        $response = '';
        $arrive_time = "0900";
        $leave_date = $leave['timepicker'];
        $start_time = $leave['start_time'];
        $end_time = $leave['end_time'];
        $date_list = (!empty($leave['date_list'])) ? $leave['date_list'] : [];
        $leave_name = Type::find($leave['type_id'])->name;

        //當天是否請過假
        if (LeaveDay::checkLeaveByUserIdDateRangeType($user_id,$start_time,$end_time,"")>0) {

            $response = '當天已經請假';
            return $response;

        } 

        switch (Type::find($leave['type_id'])->exception) {
            //善待假
            case "entertain":

                //善待假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['end_date'];

                $hours = ($leave['dayrange']=="allday") ? 8 : 4 ;
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = intval(TimeHelper::changeDateFormat($leave_date,'m')) . '月已經請過' . $leave_name;
                    break;

                }

                //善待假是否與特休、生日、久任、國定假日相連
                $leave_type_arr = [];
                foreach(Type::getTypeByException(['birthday','annual_leave','lone_stay']) as $type) {

                    $leave_type_arr[] = $type->id;

                }

                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . "不可與特定假別連著請";
                    break;

                }

                if (Holiday::checkHolidayByDateAndType(TimeHelper::changeDateFormat($front_date,'Y-m-d'),'holiday')>0 || Holiday::checkHolidayByDateAndType(TimeHelper::changeDateFormat($back_date,'Y-m-d'),'holiday')>0) {

                    $response = $leave_name . "不可與國定假日連著請";
                    break;

                }
                
                break;
            //生日假
            case 'birthday':

                //當月是否為生日月
                if (TimeHelper::changeDateFormat($birthday,'m') != TimeHelper::changeDateFormat($leave_date,'m')) {
                    
                    $response = intval(TimeHelper::changeDateFormat($leave_date,'m')) . "月不是你的生日";
                    break;

                }

                //生日假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$leave_date)['end_date'];
                $leave_year = TimeHelper::changeDateFormat($leave_date,'Y');

                $hours = ($leave['dayrange']=="allday") ? 8 : 4 ;
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = $leave_year . "已經請過" . $leave_name . "或是剩餘時數不足";
                    break;

                }

                //生日假不可與善待假連著請
                $leave_type_arr = [];
                foreach(Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }
                
                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . "不可與善待假連著請";
                    break;

                }

                break;
            //特休
            case 'annual_leave':

                //特休剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDateByEnterDate($enter_date,$start_time)['start_date'];
                $end_date = self::getStartDateAndEndDateByEnterDate($enter_date,$start_time)['end_date'];

                $new_date_list = [];

                foreach ($date_list as $key => $date) {

                    if (TimeHelper::changeDateFormat($date,'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                        $new_date_list[] = $date;
                        unset($date_list[$key]);

                    }

                }

                if (count($date_list) == 1) {

                    $start_date_origin = $date_list['0'];
                    $end = ($arrive_time == "0900") ? " 18:00" : " 18:30";
                    $end_date_origin =  TimeHelper::changeDateFormat($date_list['0'] ,'Y-m-d') . $end;

                    $hours = self::calculateOneDateHours($start_date_origin,$end_date_origin);

                } else {

                    $hours = self::calculateRangeDateHours($date_list);

                }

                $remain_hours = self::getAnnulLeaveRemainHours($start_date,$hours);

                if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response =  $leave_name . "剩餘時數不足";
                    break;

                }

                if (count($new_date_list)>0) {

                    $start_date = self::getStartDateAndEndDateByEnterDate($enter_date,$new_date_list['0'])['start_date'];
                    $end_date = self::getStartDateAndEndDateByEnterDate($enter_date,$new_date_list['0'])['end_date'];

                    if (count($new_date_list) == 1) {

                        $start = ($arrive_time == "0900") ? " 09:00" : " 09:30";
                        $start_date_new = TimeHelper::changeDateFormat($new_date_list['0'] ,'Y-m-d') . $start;
                        $end_date_new = $new_date_list['0'];

                        $hours = self::calculateOneDateHours($start_date_new,$end_date_new);

                    } else {

                        $hours = self::calculateRangeDateHours($new_date_list);

                    }
                    
                    $remain_hours = self::getAnnulLeaveRemainHours($start_date,$hours);

                    if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                        $response =  $leave_name . "剩餘時數不足";
                        break;

                    }

                }

                //特休不可與善待假連著請
                $leave_type_arr = [];
                foreach(Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }

                $front_date = self::getFrontDateOrBackDate($start_time,'front');
                $back_date = self::getFrontDateOrBackDate($end_time,'back');

                if (self::checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . "不可與善待假連著請";
                    break;

                }

                break;
            //久任
            case 'lone_stay':    

                //請假當月年資是否滿兩年
                if (self::calculateAnnualDate($leave_date) < 80) {

                    $response = "年資未滿兩年，無法使用" . $leave_name;
                    break;

                }

                //久任假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDateByEnterDate($enter_date,$leave_date)['start_date'];
                $end_date = self::getStartDateAndEndDateByEnterDate($enter_date,$leave_date)['end_date'];

                $hours = ($leave['dayrange']=="allday") ? 8 : 4 ;
                $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                    $response = $start_date . "~" . $end_date . "間已經請過" . $leave_name . "或是剩餘時數不足";
                    break;

                }

                //久任不可與善待假連著請
                $leave_type_arr = [];
                foreach(Type::getTypeByException(['entertain']) as $type) {

                    $leave_type_arr[] = $type->id;

                }
                
                $front_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['front_date'];
                $back_date = self::getFrontDateAndBackDate($start_time,$end_time,$leave['dayrange'],$leave_date)['back_date'];

                if (self::checkLeaveByType($user_id,$front_date,$back_date,$leave_type_arr)) {

                    $response = $leave_name . "不可與善待假連著請";
                    break;

                }

                break;
            //謀職假
            case 'job_seek':

                //謀職假開關是否打開
                if ($job_seek == 0) {

                    $response = $leave_name . "尚未開啟";
                    break;

                }

                //謀職假剩餘時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$start_time)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$start_time)['end_date'];
                
                if ($start_date == '' && $end_date == '') {

                    $date_list = self::calculateWorkingDate($start_time,$end_time);
                    $hours = self::calculateRangeDateHours($date_list);
                    $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                    if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                        $response =  $leave_name . "剩餘時數不足";
                        break;

                    }

                } else {

                    $new_date_list = [];

                    foreach ($date_list as $key => $date) {

                        if (TimeHelper::changeDateFormat($date,'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                            $new_date_list[] = $date;
                            unset($date_list[$key]);

                        }

                    }

                    if (count($date_list) == 1) {

                        $start_date_origin = $date_list['0'];
                        $end = ($arrive_time == "0900") ? " 18:00" : " 18:30";
                        $end_date_origin =  TimeHelper::changeDateFormat($date_list['0'] ,'Y-m-d') . $end;

                        $hours = self::calculateOneDateHours($start_date_origin,$end_date_origin);

                    } else {

                        $hours = self::calculateRangeDateHours($date_list);

                    }
                    
                    $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                    if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                        $response =  $leave_name . "剩餘時數不足";
                        break;

                    }

                    if (count($new_date_list)>0) {

                        $start_date = self::getStartDateAndEndDate($leave['type_id'],$new_date_list['0'])['start_date'];
                        $end_date = self::getStartDateAndEndDate($leave['type_id'],$new_date_list['0'])['end_date'];

                        if(count($new_date_list) == 1) {

                            $start = ($arrive_time == "0900") ? " 09:00" : " 09:30";
                            $start_date_new = TimeHelper::changeDateFormat($new_date_list['0'] ,'Y-m-d') . $start;
                            $end_date_new = $new_date_list['0'];

                            $hours = self::calculateOneDateHours($start_date_new,$end_date_new);

                        } else {

                            $hours = self::calculateRangeDateHours($new_date_list);

                        }
                        
                        $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                        if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                            $response =  $leave_name . "剩餘時數不足";
                            break;

                        }

                    } 

                }

                break;
            default:
                // 時數是否足夠
                $start_date = self::getStartDateAndEndDate($leave['type_id'],$start_time)['start_date'];
                $end_date = self::getStartDateAndEndDate($leave['type_id'],$start_time)['end_date'];
                
                if ($start_date == '' && $end_date == '') {

                    $date_list = self::calculateWorkingDate($start_time,$end_time);
                    $hours = self::calculateRangeDateHours($date_list);
                    $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                    //當重至時間為none，時數上限為0代表不限制請假時數，不需判斷
                    if (($hours + $remain_hours) != 0) {

                        if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                            $response =  $leave_name . "剩餘時數不足";
                            break;

                        }

                    } else {

                        $response = "";
                        break;

                    }
                    

                } else {

                    $new_date_list = [];

                    foreach ($date_list as $key => $date) {

                        if (TimeHelper::changeDateFormat($date,'Y-m-d') > TimeHelper::changeDateFormat($end_date,'Y-m-d')) {

                            $new_date_list[] = $date;
                            unset($date_list[$key]);

                        }

                    }

                    if (count($date_list) == 1) {

                        $start_date_origin = $date_list['0'];
                        $end = ($arrive_time == "0900") ? " 18:00" : " 18:30";
                        $end_date_origin =  TimeHelper::changeDateFormat($date_list['0'] ,'Y-m-d') . $end;

                        $hours = self::calculateOneDateHours($start_date_origin,$end_date_origin);

                    } else {

                        $hours = self::calculateRangeDateHours($date_list);

                    }
                    
                    $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                    if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                        $response =  $leave_name . "剩餘時數不足";
                        break;

                    }

                    if (count($new_date_list)>0) {

                        $start_date = self::getStartDateAndEndDate($leave['type_id'],$new_date_list['0'])['start_date'];
                        $end_date = self::getStartDateAndEndDate($leave['type_id'],$new_date_list['0'])['end_date'];

                        if(count($new_date_list) == 1) {

                            $start = ($arrive_time == "0900") ? " 09:00" : " 09:30";
                            $start_date_new = TimeHelper::changeDateFormat($new_date_list['0'] ,'Y-m-d') . $start;
                            $end_date_new = $new_date_list['0'];

                            $hours = self::calculateOneDateHours($start_date_new,$end_date_new);

                        } else {

                            $hours = self::calculateRangeDateHours($new_date_list);

                        }
                        
                        $remain_hours = self::getRemainHours($leave['type_id'],$hours);

                        if (self::checkLeaveTypeUsed($user_id,$start_date,$end_date,$leave['type_id'],$remain_hours)) {

                            $response =  $leave_name . "剩餘時數不足";
                            break;

                        }

                    } 

                }

                break;
        }

        // 檢查理由是否必填
        if (Type::find($leave['type_id'])->reason) {

            if (empty($leave['reason'])) {

                $response = "請填請假理由";

            }

        }

        // 檢查證明是否必填

        // 檢查代理人時間是否有衝突

        return $response;
    }
}
