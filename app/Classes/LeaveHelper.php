<?php

namespace App\Classes;

use App\Holiday;

class LeaveHelper
{
    public static function homePageURL()
    {
      return url('/');
    }

    public static function calculateAnnualDate() 
    {
      $start_date = "2017-08-31 00:00:00";
        $enter_date = "2016-11-07 00:00:00";
        $hours = "";
        $annual_date = 0;

        $start_date_year = ($start_date=="") ? date('Y', strtotime(Carbon::now())) : date('Y', strtotime($start_date));
        $enter_date_year = date('Y', strtotime($enter_date));
        $service_year = intval($start_date_year - $enter_date_year );

        $start_date_month = ($start_date=="") ? date('m', strtotime(Carbon::now())) : date('m', strtotime($start_date));
        $enter_date_month = date('m', strtotime($enter_date));
        $service_month = intval($start_date_month - $enter_date_month);

        $start_date_day = ($start_date=="") ? date('d', strtotime(Carbon::now())) : date('d', strtotime($start_date));
        $enter_date_day = date('d', strtotime($enter_date));
        $service_day = intval($start_date_day - $enter_date_day);

        if (($start_date_month - $enter_date_month) <0 ) {

            $service_year --;

        }

        switch ($service_year) {
            case 0:
                if ($start_date_year != $enter_date_year) {

                    $service_month += 12;
                    if ($service_month > 6) {

                        $annual_date = 3;

                    } elseif($service_month == 6 && $service_day >= 0) {

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
            case ($service_year >= 10):
                $annual_date = ($service_year + 6 < 30) ? $service_year + 6 : 30;
                break;
        }

        $annual_date = $annual_date*8;

        return $annual_date;
    }

    public static function calculateWorkingDate($start_time,$end_time)
    {
        $date_list = [];

        // 除了頭尾的日期將中間的日期取出，並判斷是否為補班或假日
        for ( $i = 1; date("Y-m-d",strtotime("$end_time")) > date("Y-m-d",strtotime("$start_time +$i day")); $i++ ) {
            $date_list[] = date( "Y-m-d", strtotime( "$start_time +$i day" ));
        }

        foreach($date_list as $key => $date) {

            if (in_array( date('w',strtotime($date)),['0','6']) ) {

                if (!Holiday::getHolidayByDateAndType($date,'work')>0) {

                    unset($date_list[$key]);

                }

            } else {

                if (Holiday::getHolidayByDateAndType($date,'holiday')>0) {

                    unset($date_list[$key]);

                }

            }

        }

        //將頭尾日期補上
        array_unshift($date_list,$start_time);
        $date_list[] = $end_time;

        return $date_list;
    }

    public static function calculateRangeDateHours($date_list) {
        $start_time = $date_list['0'];
        $end_time = end($date_list);
        $arrive_time = "09:00:00";
        $leave_time = "18:00:00";
        $hours = 0;

        $hours = self::calculateOneDateHours($start_time , $leave_time) + self::calculateOneDateHours($arrive_time , $end_time) + (count($date_list) - 2) * 8;
        return $hours;
    }

    public static function calculateOneDateHours($start_time,$end_time)
    {
        $hours = 0;

        for ($i = intval(date( "H", strtotime( "$start_time" )))+1 ; $i<= intval(date( "H", strtotime( "$end_time" ))) ; $i++ ) {

            if ($i != 13) {

                $hours ++;

            }

        }

        //如果開始時間為0分、結束時間為30分則加上一小時
        if (date( "i", strtotime( "$start_time" )) == 0 && date( "i", strtotime( "$end_time" )) == 30 ) {

            $hours += 1;

        }


        return $hours;
    }
}
