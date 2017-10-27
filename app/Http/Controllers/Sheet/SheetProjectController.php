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
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];

        if(!empty($search)) {

            $request->session()->forget('project');
            $request->session()->push('project.search', $search);

        } else {

            if ( !empty($request->input('page')) && !empty($request->session()->get('project')) ) {

                $search = $request->session()->get('project.search.0');

            } else {

                $request->session()->forget('project');

            }
        }

        $model = new Project;

        $model->fill($search);

        $project = $model->search();

        // dd($project);

        $teamModel = new Team;
        $all_team = $teamModel->getAllTeam();

        return  view('sheet_project', compact(
            'model', 'project', 'all_team'
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
        $main_team = $model->getMainTeam();
        $sub_team = $model->getSubTeam();

        $projectModel = new Project;

        $project_team = [];

        return  view('sheet_project_form', compact(
            'main_team', 'sub_team', 'projectModel', 'project_team'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        // 專案名稱 團隊 狀態
        $team = new Team;
        $main_team = $team->getMainTeam();
        $sub_team = $team->getSubTeam();

        $projectModel = new Project;
        $project_data = $projectModel->whichProject($id);

        $input = [];

        foreach ($project_data as $key => $value) {
            $input['id'] = $value['id'];
            $input['name'] = $value['name'];
            $input['available'] = $value['available'];
        }

        $projectModel->fill($input);

        $projectTeamModel = new ProjectTeam;
        $project_team = $projectTeamModel->getProjectTeamByProjectId($id)->pluck('team_id')->toArray();

        return  view('sheet_project_form', compact(
            'main_team', 'sub_team','projectModel', 'project_team'
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

        //狀態 空 則為 0
        $input['available'] = (empty($input['available'])) ? "0" : "1";

        // 加入project table
        $model = new Project;
        $model->fill([
            'name' => $input['title'],
            'available' => $input['available'],
        ]);

        if ($model->save()) {
            $project_judge = true;
        }

        // 加入 projectTeam table
        $project_member = $input['team'];

        foreach($project_member as $key => $data){

            $projectTeamModel = new ProjectTeam;
            $projectTeamModel->fill([
                'team_id' => $data,
                'project_id' => $model->id,
            ]);

            if ($projectTeamModel->save()) {
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

        //狀態 空 則為 0
        $input['available'] = (empty($input['available'])) ? "0" : "1";

        // update project id name available
        // 加入project table
        $model = self::loadModel($input['id']);
        $model->fill([
            'name' => $input['title'],
            'available' => $input['available'],
        ]);

        if ($model->save()) {
            $project_judge = true;
        }

        // update projectTeam delete old data add new team_id project_id
        $project_member = $input['team'];
        ProjectTeam::deleteProjectTeamByProjectId($input['id']);

        foreach($project_member as $key => $data){

            $projectTeamModel = new ProjectTeam;
            $projectTeamModel->fill([
                'team_id' => $data,
                'project_id' => $model->id,
            ]);

            if ($projectTeamModel->save()) {
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
     * ajax更新
     *
     * @param Request $request
     * @return Redirect
     */
    public function ajaxUpdateData(Request $request)
    {
        // id available
        $id = $request['id'];
        $available = $request['available'];
        $input = ['available' => $available];

        $model = new Project;

        $model = $this->loadModel($id);

        $model->fill($input);

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

    /**
     * 找id
     *
     * @return \Illuminate\Http\Response
     */
    private static function loadModel($id)
    {
        $model = Project::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
        return $model;
    }
}
