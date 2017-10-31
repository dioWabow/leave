<?php

namespace App\Console\Commands;

use TimeHelper;
use App\Absence;
use App\LeaveDay;
use App\TimeSheet;
use App\User;

use Carbon\Carbon;
use Illuminate\Console\Command;

class AbsenceSheetEveryDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:AbsenceSheetEveryDay';

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
 
             /*取得所有可以登入&離值日是空的人的人*/
             $all_user_id = User::getAllUserIdWithNotLeaved()->toArray();
             /*取得今日有請假的user_id*/
             $get_leave_user_id = LeaveDay::getTodayLeave('all_day')->pluck('user_id')->toArray();
             
             foreach ($all_user_id as $user_id) {
 
                 if (!in_array($user_id, $get_leave_user_id)) {
 
                     $get_user_id_sum_hour = TimeSheet::getTimeSheetUserIdByNotLeavedUserId($user_id, $now_day);
                     
                     if ($get_user_id_sum_hour <= 0) {
 
                         $model = new Absence;
                         $model->fill([
                             'user_id' => $user_id,
                             'notfill_at' => $now_day,
                         ]);
                         $model->save();
 
                     }
 
                 }
 
             }
 
         }

    }
    
}
