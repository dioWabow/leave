<?php

namespace App\Console\Commands;

use App\Notifications\CronDailyWaitProve;
use SlackHelper;
use LeaveHelper;
use App\LeaveDay;
use App\Leave;
use App\LeaveAgent;

use File;
use Illuminate\Console\Command;

class DailyWaitProve extends Command
{
    // 命令名稱
    protected $signature = 'Notice:DailyWaitProve';

    // 說明文字
    protected $description = 'Daily Wait Prove Notice In Channel';

    public function __construct()
    {
        parent::__construct();
    }

    // Console 執行的程式
    public function handle()
    {
        $leave_wait_prove_list = Leave::getWaitProveLeave();
        $leave_wait_prove_user_list = [];
        foreach ($leave_wait_prove_list as $key => $leave_wait_prove_leave) {

            $leave_wait_prove_process =  LeaveHelper::getLeaveProveProcess( $leave_wait_prove_leave->id );

            if ( $leave_wait_prove_leave->tag_id == "1" ) {

                $agent_user_list = LeaveAgent::getAgentByLeaveId( $leave_wait_prove_leave->id );
                if (!empty( $agent_user_list )) {
                    
                    foreach ($agent_user_list as $key => $agent_user) {

                        $leave_wait_prove_user_list[ $agent_user->fetchUser->nickname ]['agent'] = true;

                    }

                }

            }elseif ( $leave_wait_prove_leave->tag_id == "2" ) {

                if ( !empty($leave_wait_prove_process["minimanager"] ) ) {

                    $leave_wait_prove_user_list[ $leave_wait_prove_process["minimanager"]->nickname ]['minimanager'] = true;

                }elseif ( !empty($leave_wait_prove_process["manager"] ) ) {

                    $leave_wait_prove_user_list[ $leave_wait_prove_process["manager"]->nickname ]['manager'] = true;

                }

            }elseif ( $leave_wait_prove_leave->tag_id == "3" ) {

                if ( !empty($leave_wait_prove_process["manager"] ) ) {

                    $leave_wait_prove_user_list[ $leave_wait_prove_process["manager"]->nickname ]['manager'] = true;

                }

            }elseif ( $leave_wait_prove_leave->tag_id == "4" ) {

                if ( !empty($leave_wait_prove_process["admin"] ) ) {

                    $leave_wait_prove_user_list[ $leave_wait_prove_process["admin"]->nickname ]['admin'] = true;

                }

            }elseif ( $leave_wait_prove_leave->tag_id == "5" ) {
                //目前不會有
            }

        }

        if (!empty( $leave_wait_prove_user_list )) {

            foreach ($leave_wait_prove_user_list as $key => $leave_wait_prove_user) {

                SlackHelper::notify(new CronDailyWaitProve( $leave_wait_prove_user , $key));

            }

        }

    }
}