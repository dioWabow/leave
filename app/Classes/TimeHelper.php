<?php

namespace App\Classes;

use App\User;

use Carbon\Carbon;

class TimeHelper
{
    public static function changeDateFormat($date,$format)
    {
        $dt = Carbon::parse($date);
        return $dt->format($format);
    }

    public static function changeDateValue($date,$value,$format)
    {
        $dt = Carbon::parse($date);
        foreach($value as $val) {

            $val1 = explode(",", $val);

            switch (trim(strtolower($val1['2']))) {
                case 'year':
                    
                    if ($val1['0'] == '+') {

                        $dt->addYears($val1['1']);

                    } else {

                        $dt->subYears($val1['1']);

                    }

                    break;

                case 'month':

                    if ($val1['0'] == '+') {

                        $dt->addMonths($val1['1']);

                    } else {

                        $dt->subMonths($val1['1']);

                    }
                    
                    break;
                
                case 'day':

                    if ($val1['0'] == '+') {

                        $dt->addDays($val1['1']);

                    } else {

                        $dt->subDays($val1['1']);

                    }
                    
                    break;
                
                case 'hour':

                    if ($val1['0'] == '+') {

                        $dt->addHours($val1['1']);

                    } else {

                        $dt->subHours($val1['1']);

                    }
                    
                    break;
                
                case 'minute':

                    if ($val1['0'] == '+') {

                        $dt->addMinutes($val1['1']);

                    } else {

                        $dt->subMinutes($val1['1']);

                    }
                    
                    break;
            }

        }

        return $dt->format($format);
    }

    //跳過中午休息時間
    public static function changeHourValue($date,$value,$format)
    {
        $dt = Carbon::parse($date);
        
        foreach($value as $val) {

            $val1 = explode(",", $val);

            if ($val1['0'] == '+') {

                if ($dt->hour < 13 && ($dt->hour+$val1['1']) >= 13) {

                    $dt->addHours($val1['1']+1);

                } else {

                    $dt->addHours($val1['1']);

                }

            } else {

                if ($dt->hour > 12 && ($dt->hour-$val1['1']) <= 12) {

                    $dt->subHours($val1['1']+1);

                } else {

                    $dt->subHours($val1['1']);

                }

            }

        }

        return $dt->format($format);
    }


    public static function getWeekNumberByDate($date)
    {
        $dt = Carbon::parse($date);
        return $dt->dayOfWeek;
    }

    public static function checkHours($date)
    {
        $dt = Carbon::parse($date);
        return $dt->hour;
    }

    public function changeViewTime($start_time,$end_time,$user_id)
    {
        $reverse_time = '';

        if (self::changeDateFormat($start_time,'m-d') != self::changeDateFormat($end_time,'m-d')) {

            if (self::changeDateFormat($start_time,'H:i') == '09:00') {

                $reverse_time = self::changeDateFormat($start_time,'Y-m-d');

            } else {

                $reverse_time = self::changeDateFormat(self::changeTimeByArriveTime($start_time , $user_id , '+'),'Y-m-d H:i');

            }

            $reverse_time .= ' ~ ';

            if (self::changeDateFormat($end_time,'H:i') == '18:00') {

                $reverse_time .= self::changeDateFormat($end_time,'Y-m-d');

            } else {

                $reverse_time .= self::changeDateFormat(self::changeTimeByArriveTime($end_time , $user_id , '+'),'Y-m-d H:i');

            }

        } else {

            if (self::changeDateFormat($start_time,'H:i') == '09:00' && self::changeDateFormat($end_time,'H:i') == '14:00') {

                $reverse_time = self::changeDateFormat($start_time,'Y-m-d') . '(早上)';

            } elseif(self::changeDateFormat($start_time,'H:i') == '14:00' && self::changeDateFormat($end_time,'H:i') == '18:00') {

                $reverse_time = self::changeDateFormat($start_time,'Y-m-d') . '(下午)';

            } elseif(self::changeDateFormat($start_time,'H:i') == '09:00' && self::changeDateFormat($end_time,'H:i') == '18:00') {

                $reverse_time = self::changeDateFormat($start_time,'Y-m-d') . '(整天)';

            } else {

                $reverse_time = self::changeDateFormat(self::changeTimeByArriveTime($start_time , $user_id , '+'),'Y-m-d H:i') . ' ~ ' . self::changeDateFormat(self::changeTimeByArriveTime($end_time , $user_id , '+'),'Y-m-d H:i');

            }

        }

        return $reverse_time;
    }

    //時間是否需要+-30分鐘
    public function changeTimeByArriveTime($date,$user_id,$operator)
    {
        $user = User::find($user_id);
        $date_new = ($user->arrive_time == '0900') ? $date : TimeHelper::changeDateValue($date,[$operator . ',30,minute'],'Y-m-d H:i:s');
        return $date_new;
    }

    /* 轉換日期加上時間 */
    public function changeDateTimeFormat($start_time, $end_time)
    {
        $start_time = Carbon::createFromFormat('Y-m-d H', $start_time . '09')->toDateTimeString();
        $end_time = Carbon::createFromFormat('Y-m-d H', $end_time . '18')->toDateTimeString();
        return [$start_time, $end_time];
    }

    public function getNowDate($type = "Y-m-d")
    {
        $result = date($type);
        return $result;
    }

}
