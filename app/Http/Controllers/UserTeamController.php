<?php

namespace App\Http\Controllers;

use Redirect;
use App\User;
use App\Team;
use App\UserTeam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserTeamController extends Controller
{
    public function postMemberSet(Request $request)
    {
        $teams = $request->teams;
        $managers = $request->managers;

        $model = new UserTeam;

        $user_list = [];
        $manager_list = [];

        foreach ($teams as $key => $value) {
            foreach ($value as $member) {
                $user_list[] = ['role' => 'user', 'user_id' => $member, 'team_id' => $key];
            }
        }

        foreach ($managers as $key => $value) {
            foreach ($value as $member) {
                $manager_list[] = ['role' => 'manager', 'user_id' => $member, 'team_id' => $key];
            }
        }

        $model->fill($user_list);

        if ($model->save()) {

            return Redirect::route('teams/index')->withErrors(['msg' => '更新成功']);

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }
}
