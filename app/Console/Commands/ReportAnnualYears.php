<?php

namespace App\Console\Commands;

use LeaveHelper;
use TimeHelper;
use App\AnnualYear;
use App\LeaveDay;
use App\User;
use App\Type;
use App\Leave;

use Carbon\Carbon;

use Illuminate\Console\Command;

class ReportAnnualYears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:AnnualYears {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annual Years cron';

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

        $start_year = Carbon::create($now_year, 1, 1)->format('Y-m-d');
        $end_year = Carbon::create($now_year, 12, 31)->format('Y-m-d');
        
        //抓出特休的type_id
        $leave_type_arr = [];
        foreach (Type::getTypeByException(['annual_leave']) as $type) {

            $leave_type_arr[] = $type->id;

        }

        $users = new User;
        $search = [];
        $data = $users->search($search);
        foreach( $data as $user) {
            
            AnnualYear::deleteAnnualYearByUserId($user->id, $now_year);

            $start_this_year = TimeHelper::changeDateFormat($now_year, 'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');
            $start_next_year = TimeHelper::changeDateValue($now_year,['+,1,year'], 'Y') . TimeHelper::changeDateFormat($user->enter_date,'-m-d');
            
            $annual_this_years = LeaveHelper::calculateAnnualDate($start_this_year, $user->id);
            $annual_next_years = LeaveHelper::calculateAnnualDate($start_next_year, $user->id);
            
            $used_annual_hours = LeaveDay::getPassLeaveHoursByUserIdDateType($user->id, $start_year, $end_year, $leave_type_arr);
            $remain_annual_hours = ($annual_this_years + $annual_next_years) - $used_annual_hours;

            $model = new AnnualYear;
            $model->fill([
                'user_id' => $user->id,
                'annual_this_years' => $annual_this_years,
                'annual_next_years' => $annual_next_years,
                'used_annual_hours' => $used_annual_hours,
                'remain_annual_hours' => $remain_annual_hours,
                'create_time' => Carbon::now()->format('Y-m-d'),
            ]);
            $model->save();
        }
    }
}
