<?php

namespace App\Console\Commands;

use LeaveHelper;
use TimeHelper;
use App\LeaveDay;
use App\User;
use App\Type;
use App\LeavedUser;

use Carbon\Carbon;

use Illuminate\Console\Command;

class LeavedUserAnnualHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:LeavedUserAnnualHours  {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'LeavedUserAnnualHours';

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
        $date = $this->argument('date');
        $today = (!empty($date)) ? Carbon::parse($date) : Carbon::now();
        $now_year = $today->format('Y');
        $now_month = $today->format('m');

        $users = User::getUserByLeaveYearAndMonth($now_year,$now_month);

        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        foreach($users as $user) {

            LeavedUser::deleteAnnualHourByUserId($user->id,$now_year);

            $LeavedUser = new LeavedUser;
            if (TimeHelper::changeDateFormat($user->leave_date,'m-d') > TimeHelper::changeDateFormat($user->enter_date,'m-d')) {

                $start_time = TimeHelper::changeDateFormat($now_year,'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');

            } else {

                $start_time = TimeHelper::changeDateValue($now_year,['-,1,year'],'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');

            }
            
            $end_time = $now_year . TimeHelper::changeDateFormat($user->leave_date,'-m-d');
            
            $annual_hours = LeaveHelper::calculateAnnualDate($start_time,$user->id);
            $dt_start = Carbon::parse($start_time);
            $dt_end = Carbon::parse($end_time);
            $work_days = $dt_start->diffInDays($dt_end);
            $work_rate = ($work_days/365 >1 ) ? 1 : $work_days/365;
            $real_annual_hours = number_format($annual_hours * $work_rate , 1);
            $used_annual_hours = LeaveDay::getPassLeaveHoursByUserIdDateType($user->id,$start_time,$end_time,$leave_type_arr);
            $remain_annual_hours = $real_annual_hours - $used_annual_hours;

            $LeavedUser->fill([
                'user_id' => $user->id,
                'annual_hours' => $real_annual_hours,
                'used_annual_hours' => $used_annual_hours,
                'remain_annual_hours' => $remain_annual_hours,
                'create_time' => Carbon::now()->format('Y-m-d'),
            ]);
            $LeavedUser->save();

        }
    }
}
