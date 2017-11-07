<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\TimesheetPermission;
use App\UserTeam;

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
        foreach ($team_result as $key => $value) {
            $user_team_result[$value->id] = UserTeam::getNotManagerUsersIdByTeamsId($value->id);
        }

        dd($user_team_result);

        $model = (object)[];
        return view('sheet_auth', compact('model'));
    }

}
