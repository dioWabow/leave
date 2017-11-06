<?php

namespace App\Console\Commands;

use App\Notifications\CronDailyLeave;
use SlackHelper;
use App\LeaveDay;

use Carbon\Carbon;
use File;
use Illuminate\Console\Command;

class CronJobTest extends Command
{
    // 命令名稱
    protected $signature = 'Notice:CronJobTest';

    // 說明文字
    protected $description = 'Daily Leave Notice In Channel';

    public function __construct()
    {
        parent::__construct();
    }

    // Console 執行的程式
    public function handle()
    {
        $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
        $txt = Carbon::now()->format('Y-m-d H:i:s'."\n");

        fwrite($myfile, $txt);
        fclose($myfile);
    }
}