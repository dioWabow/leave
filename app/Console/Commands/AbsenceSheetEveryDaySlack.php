<?php

namespace App\Console\Commands;

use TimeHelper;
use SlackHelper;
use App\Absence;
use App\LeaveDay;
use App\TimeSheet;
use App\User;
use App\Notifications\AbsenceSheetSlack;

use Carbon\Carbon;
use Illuminate\Console\Command;

class AbsenceSheetEveryDaySlack extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Slack:AbsenceSheetEveryDaySlack';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Absence Sheet cron every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /* 確認今天是不是補班日 */
        $now_day = Carbon::now()->format('Y-m-d');
        $checkHolidayDate = TimeHelper::checkHolidayDate($now_day, 'holiday');
        /* 確認今天是不是假日 */
        $checkWeekendDate = TimeHelper::checkWeekendDate();

        if (!$checkHolidayDate && !$checkWeekendDate) {

           /*取得所有可以發送通知 & 離值日是空的人的人*/
           $all_not_leaved_user = User::getAllUserIdWithSheetNotice();
            
            /*取得今日有請假的user_id*/
            $get_leave_user_id = LeaveDay::getTodayLeave('all_day')->pluck('user_id')->toArray();
            
            foreach ($all_not_leaved_user as $value) {
                
                if (!in_array($value->id, $get_leave_user_id)) {

                    $get_user_id_sum_hour = TimeSheet::getTimeSheetUserIdByNotLeavedUserId($value->id, $now_day);
                    
                    if ($get_user_id_sum_hour <= 0) {

                        SlackHelper::notify(new AbsenceSheetSlack( $value->nickname ));

                    }

                }

            }

        }
    }
}
