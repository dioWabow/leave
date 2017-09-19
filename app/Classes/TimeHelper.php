<?php

namespace App\Classes;

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

            switch (strtolower($val1['2'])) {
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
}
