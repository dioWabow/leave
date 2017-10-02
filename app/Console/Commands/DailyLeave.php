<?php

namespace App\Console\Commands;

use App\Notifications\CronDailyLeave;
use SlackHelper;
use App\LeaveDay;

use File;
use Illuminate\Console\Command;

class DailyLeave extends Command
{
    // 命令名稱
    protected $signature = 'Notice:DailyLeave';

    // 說明文字
    protected $description = 'Daily Leave Notice In Channel';

    public function __construct()
    {
        parent::__construct();
    }

    // Console 執行的程式
    public function handle()
    {
        $leave_list = [];
        $leave_list["all_day"] = [];
        $leave_list["morning"] = [];
        $leave_list["afternoon"] = [];

        $all_day = LeaveDay::getTodayLeave("all_day");
        foreach ($all_day as $key => $value) {
            
            $leave_list["all_day"][] = $value->fetchUser->nickname;

        }
        $morning = LeaveDay::getTodayLeave("morning");
        foreach ($morning as $key => $value) {

            $leave_list["morning"][] = $value->fetchUser->nickname;
            foreach ($leave_list["all_day"] as $key_all_day => $value_all_day) {

                if ($value->fetchUser->nickname == $value_all_day) {

                    unset($leave_list["all_day"][$key_all_day]);

                }

            }

        }
        $afternoon = LeaveDay::getTodayLeave("afternoon");
        foreach ($afternoon as $key => $value) {

            $leave_list["afternoon"][] = $value->fetchUser->nickname;
            foreach ($leave_list["all_day"] as $key_all_day => $value_all_day) {

                if ($value->fetchUser->nickname == $value_all_day) {

                    unset($leave_list["all_day"][$key_all_day]);

                }

            }

        }

        if ( !empty($leave_list["morning"]) || !empty($leave_list["afternoon"]) || !empty($leave_list["all_day"]) ) {

            SlackHelper::notify(new CronDailyLeave($leave_list));

        }
    }
}