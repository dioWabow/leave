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

class EveryDayAnnualHours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Report:AnnualHoursEveryDay {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Annual Hours cron every day';

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

        $users = User::getUserByEnterMonthAndDayOrAnnualHoursNull($today->format('m'),$today->format('d'));

        foreach($users as $user) {

            if (!empty($user->status)) {

                $model = User::find($user->id);
                $annual_hours = LeaveHelper::calculateAnnualDate($today->format('Y-m-d'),$user->id);

                $model->fill(['annual_hours' => $annual_hours]);
                $model->save();

            }
            
        }

        $no_annual_hours_user = User::getUserByAnnualHoursZero();

        foreach($no_annual_hours_user as $user) {
            
            if (!empty($user->status) && TimeHelper::changeDateValue($user->enter_date,['+,6,month'],'Y-m-d') == $today->format('Y-m-d')) {

                $model = User::find($user->id);

                $annual_hours = LeaveHelper::calculateAnnualDate($today->format('Y-m-d'),$user->id);

                $model->fill(['annual_hours' => $annual_hours]);
                $model->save();

            }

        }
    }
}
