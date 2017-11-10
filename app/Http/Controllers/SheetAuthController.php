<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\TimesheetPermission;
use App\UserTeam;

use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SheetAuthController extends Controller
{
    /**
     * 首頁
     *
     */
    public static function getIndex(Request $request)
    {
        // Team User UserTeam
        $model = new Team;
        $team_result = [];

        $timesheet_permission_model = new TimesheetPermission;
        $timesheet_permission_result = [];

        $user_team_model = new UserTeam;
        $user_team_result = [];

        $user_model = new User;
        $user_result = [];

        $team_result = $model->getAllTeam();
        $user_result_tmp = User::getAllUsers();

        if ( !empty($user_result_tmp) ) {
            
            foreach ($user_result_tmp as $user) {

                $user_result[$user->id] = $user;

            }

        }


        foreach ($team_result as $team) {

            $user_team_result[$team->id] = UserTeam::getNotManagerUsersIdByTeamsId($team->id);

            if (!empty($user_team_result[$team->id])) {

                foreach ($user_team_result as $user_team) {

                    foreach ($user_team as $key => $user) {

                        $timesheet_permission_result[ $user ] = TimesheetPermission::getAllowUserIdByUserId($user);

                    }
                    
                }

            }

        }

        return view('sheet_auth', compact(
            'team_result' , 'timesheet_permission_result' , 'user_team_result' , 'user_result'
        ));
    }

    public static function postUpdate(Request $request)
    {
        $error = false;
        $delmodel = new TimesheetPermission;
        $delmodel->truncate();


        if ( $request->input("teams") ) {

            foreach ( $request->input("teams") as $user_id => $allow_id_list) {

                foreach ($allow_id_list as $allow_id) {

                    $model = new TimesheetPermission;
                    $allow_list = ['user_id' => $user_id, 'allow_user_id' => $allow_id];
                    $model->fill($allow_list);

                    if (!$model->save()) {

                        $error = true;

                    }

                }

            }
        }

        if (!$error) {

            return Redirect::route('sheet/auth/index');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }
}
