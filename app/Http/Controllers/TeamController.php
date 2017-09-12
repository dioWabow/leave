<?php

namespace App\Http\Controllers;

use App\Team;
use App\User;
use App\UserTeam;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function getAllTeamAndUser()
    {
        // Team User UserTeam
        $model = new Team;

        $userModel = new User;

        $userTeamModel = new UserTeam;

        // 抓全部組別 抓全部人員 抓已被分配的user及manager名單
        $team_result = $model->getAllTeam();
        foreach ($team_result as $key => $value) {
            $team_result[$key]->has_children = Team::getHasChildrenTeam($value->id);
        }

        $user_result = $userModel->getAllUsers();

        $team_user_result = $userTeamModel->getAllTeamUser()->toArray();

        $team_manager_result = $userTeamModel->getAllTeamManager()->toArray();

        // 將被分配的user及manager名單 轉成array
        // 前台用inarray方式判斷
        $team_user_list = [];
        $team_manager_list = [];

        foreach ($team_user_result as $value) {
            $team_user_list[$value['team_id']][] = $value['user_id'];
        }

        foreach ($team_manager_result as $value) {
            $team_manager_list[$value['team_id']][] = $value['user_id'];
        }

        return view('teams', compact(
            'team_result', 'user_result', 'team_user_list', 'team_manager_list'
        ));
    }

    public function ajaxCreateData(Request $request)
    {
        // 抓request中所需要的值 name ccolor
        $name = $request['team_name'];
        $color = $request['team_color'];
        $team = array('name' => $name, 'color' => $color);

        // fill
        $model = new Team;

        $model->fill($team);

        $html = array();

        // save return 做好的html
        if ($model->save()) {

            $result = true;
            // 如果新增後要直接刪除 需要取id 類似php getInsertId
            $id = $model->id;

            $html = 
                "<li class='dd-item' data-id='".$id."' data-name='".$name."' data-new='0' data-deleted='0'>".
                "<div class='dd-handle'>".$name."</div>".
                "<span class='button-delete btn btn-default btn-xs pull-right' data-owner-id='".$id."'>".
                "<i class='fa fa-times-circle-o' aria-hidden='true'></i>".
                "</sapn>".
                "<span class='button-edit btn btn-default btn-xs pull-right' data-owner-id='".$id."'>".
                "<i class='fa fa-pencil' aria-hidden='true'></i>".
                "</sapn>".
                "</li>";

            return json_encode(
                array(
                    'result' => $result,
                    'html' => $html
                )
            );

        } else {

            $result = false;
            return json_encode(
                array(
                    'result' => $result
                )
            );

        }
    }

    public function ajaxUpdateData(Request $request)
    {
        $id = $request['id'];
        $name = $request['team_name'];
        $color = $request['team_color'];
        $team = array('name' => $name, 'color' => $color);

        $model = new Team;

        $model = $this->loadModel($id);

        $model->fill($team);

        if ($model->save()) {

            $result = true;

            return json_encode(
                array(
                    'result' => $result,
                    'id' => $id
                )
            );

        } else {

            $result = false;
            return json_encode(
                array(
                    'result' => $result
                )
            );

        }
    }

    public function ajaxUpdateDrop(Request $request)
    {
        $team = json_decode($request["team_json"]);

        foreach ($team as $key => $value) {

            if ( !empty($value->children) ) {
                foreach ( $value->children as $key_children => $value_children) {

                    Team::UpdateTeamParentId($value_children->id,$value->id);

                }
            }

            Team::UpdateTeamParentId($value->id,0);

        }
        //return $team;
    }

    public function ajaxDeleteData(Request $request)
    {
        $id = $request['id'];

        $result = $this->loadModel($id)->delete();

        return json_encode(
            array(
                'result' => $result
            )
        );
    }

    /**
     * 找id
     *
     * @return \Illuminate\Http\Response
     */
    private static function loadModel($id)
    {
        $model = Team::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
        return $model;
    }
}
