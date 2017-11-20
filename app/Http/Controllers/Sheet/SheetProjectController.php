<?php

namespace App\Http\Controllers\Sheet;

use App\Project;
use App\ProjectTeam;
use App\Team;
use Redirect;
use App\Http\Requests\SheetProjectRequest;

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

            $request->session()->forget('sheet_project');
            $request->session()->push('sheet_project.search', $search);

        } else {

            if ( !empty($request->input('page')) && !empty($request->session()->get('sheet_project')) ) {

                $search = $request->session()->get('sheet_project.search.0');

            } else {

                $request->session()->forget('sheet_project');

            }
        }

        $model = new Project;

        $model->fill($search);

        $project = $model->search();

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
    public function getCreate(Request $request)
    {
        $data = $request->old('sheet_project');

        $team = new Team;
        $main_team = $team->getMainTeam();
        $sub_team = $team->getSubTeam();

        $model = new Project;

        $project_team = [];


        if (!empty($data)) {

            $input['name'] = (empty($data['title'])) ? " " : $data['title'];
            $input['available'] = (empty($data['available'])) ? "0" : "1";

            $project_team = (empty($data['team'])) ? [] : $data['team'];


            $model->fill($input);

        }

        return  view('sheet_project_form', compact(
            'main_team', 'sub_team', 'model', 'project_team'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id)
    {
        $data = $request->old('sheet_project');

        // 專案名稱 團隊 狀態
        $team = new Team;
        $main_team = $team->getMainTeam();
        $sub_team = $team->getSubTeam();

        $model = new Project;
        $project_data = $model->whichProject($id);

        $input = [];

        // 正常情況要跑的
        foreach ($project_data as $key => $value) {

            $input['id'] = $value['id'];
            $input['name'] = $value['name'];
            $input['available'] = $value['available'];

        }

        // 輸入有問題要跑的
        if (!empty($data)) {

            $input['id'] = (empty($data['id'])) ? " " : $data['id'];
            $input['name'] = (empty($data['title'])) ? " " : $data['title'];
            $input['available'] = (empty($data['available'])) ? "0" : "1";

        }

        $model->fill($input);

        $projectTeamModel = new ProjectTeam;
        $project_team = $projectTeamModel->getProjectTeamByProjectId($id)->pluck('team_id')->toArray();

        return  view('sheet_project_form', compact(
            'main_team', 'sub_team','model', 'project_team'
        ));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public function postInsert(SheetProjectRequest $request)
    {
        $input = $request->input('sheet_project');
        
        $project_judge = false;
        $projectTeam_judge = false;

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
    public function postUpdate(SheetProjectRequest $request)
    {
        $input = $request->input('sheet_project');

        $project_judge = false;
        $projectTeam_judge = false;

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

            return Redirect::route('sheet/project/index')->with('success', '修改成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '修改失敗']);

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
        $model = Project::where('id',$id)->remember(0.2)->get()->first();

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
        return $model;
    }
}
