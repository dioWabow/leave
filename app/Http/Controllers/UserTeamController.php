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

        // dd($teams);
        $managers = $request->managers;

        // dd($teams);
        $type = false;

        // 每次送出post 都會清空userTeam 的db 用新的資料蓋過
        $model = new UserTeam;
        $model->truncate();

        if(!empty($teams)) {
            foreach ($teams as $key => $value) {
                foreach ($value as $member) {
                    $user_list = ['role' => 'user', 'user_id' => $member, 'team_id' => $key];
                    $model = new UserTeam;
                    $model->fill($user_list);

                    if ($model->save()) {
                        $type = true;
                    }
                }
            }
        }

        foreach ($managers as $key => $value) {
            foreach ($value as $member) {
                if (!empty($member)) {

                    $manager_list = ['role' => 'manager', 'user_id' => $member, 'team_id' => $key];
                    $model = new UserTeam;
                    $model->fill($manager_list);

                    if ($model->save()) {
                        $type = true;
                    }

                }
            }
        }

        if ($type) {

            return Redirect::route('teams/index')->with('success', '更新成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }
}
