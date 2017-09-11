<?php

namespace App\Http\Controllers;

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

        dd($request);
        $model = new UserTeam;

        $model->fill($teams);

        $model->fill($managers);

        if ($model->save()) {

            return Redirect::route('teams')->withErrors(['msg' => '更新成功']);

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }
}
