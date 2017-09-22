<?php

namespace App\Console\Commands;

use LeaveHelper;
use TimeHelper;
use App\LeaveDay;
use App\User;
use App\Type;
use App\AnnualHour;

use Carbon\Carbon;

use Illuminate\Console\Command;

class MonthAnnualHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:AnnualHours';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '年末特休結算cron';

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
        $now_year = Carbon::now()->format('Y');
        $now_month = Carbon::now()->format('m');

        $users = User::getUserByEnterMonth($now_month);

        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        foreach($users as $user) {
            AnnualHour::deleteAnnualHourByUserId($user->id,$now_year);

            $AnnualHour = new AnnualHour;
            $start_time = TimeHelper::changeDateValue($now_year,['-,1,year'],'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');
            $end_time = $now_year . TimeHelper::changeDateValue($user->enter_date,['-,1,day'],'-m-d');
            
            $annual_hours = LeaveHelper::calculateAnnualDate($start_time,$user->id);
            $used_annual_hours = LeaveDay::getPassLeaveHoursByUserIdDateType($user->id,$start_time,$end_time,$leave_type_arr);
            $remain_annual_hours = $annual_hours - $used_annual_hours;

            $AnnualHour->fill([
                'user_id' => $user->id,
                'annual_hours' => $annual_hours,
                'used_annual_hours' => $used_annual_hours,
                'remain_annual_hours' => $remain_annual_hours,
                'create_time' => Carbon::now()->format('Y-m-d'),
            ]);
            $AnnualHour->save();
        }
    }
}
