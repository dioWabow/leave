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
    protected $signature = 'Report:LeavedUserAnnualHours';

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
        
    }
}
