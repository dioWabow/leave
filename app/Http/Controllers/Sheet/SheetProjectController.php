<?php

namespace App\Http\Controllers\Sheet;

use App\Project;
use App\ProjectTeam;
use App\Team;
use Redirect;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SheetProjectController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $model = new Project;

        $project_member = $model->getAllProject();

        return  view('sheet_project', compact(
            'project_member'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate()
    {
        $model = new Team;
        $all_team = $model->getAllTeam();

        return  view('sheet_project_form', compact(
            'all_team'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request)
    {
        $model = new Team;
        $all_team = $model->getAllTeam();

        return  view('sheet_project_form', compact(
            'all_team'
        ));
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {

    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public function postInsert(Request $request)
    {
        $input = $request->input('sheet_project');

        $project_judge = false;
        $projectTeam_judge = false;

        //專案項目必填
        if (empty($input['title'])) {

            return Redirect::back()->withInput()->withErrors(['msg' => '專案項目必填']);

        }

        //團隊必填
        if (empty($input['team'])) {

            return Redirect::back()->withInput()->withErrors(['msg' => '團隊必選']);

        }

        //狀態 空 則為 off
        if (empty($input['status'])) {

            $input['status'] = 'off';

        }

        // 加入project table
        $model = new Project;
        $model->fill([
            'name' => $input['title'],
            'available' => $input['status'],
        ]);

        if ($model->save()) {
            $project_judge = true;
        }

        // 加入 projectTeam table
        $project_member = $input['team'];

        foreach($project_member as $key => $data){

            $projectTeam = new ProjectTeam;
            $projectTeam->fill([
                'team_id' => $data,
                'project_id' => $model->id,
            ]);

            if ($projectTeam->save()) {
                $projectTeam_judge = true;
            }

        }

        if ($project_judge && $projectTeam_judge) {

            return Redirect::route('sheet/project/index')->with('success', '新增成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

        }
    }

    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */
    public function postUpdate(Request $request)
    {

    }
}
