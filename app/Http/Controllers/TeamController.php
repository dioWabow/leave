<?php

namespace App\Http\Controllers;

use App\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function getAllTeam()
    {
    	$model = new Team;

    	$result = $model->getAllTeam();

    	return view('teams', compact(
    		'result'
    	));
    }

    public function ajaxCreateData(Request $request)
    {
        // 抓request中所需要的值 name ccolor
        $name = $request['team_name'];
        $color = $request['team_color'];
        $team = array('name' => $name, 'color' => $color);

        // rule 判斷資料型態

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
