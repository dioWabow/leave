<?php

namespace App\Http\Controllers;

use App\User;
use App\Team;
use App\UserAgent;
use App\UserTeam;
use App\Http\Requests\UserRequest;

use Session;
use Image;
use Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class LeaveController extends Controller
{
    protected $file_path;
    protected $file_root_path;

    public function __construct()
    {
        $this->file_path = 'avatar/';
        $this->file_root_path = storage_path() . '/app/public/' . $this->file_path;
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request) 
    {

        return view('leave_form2');
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function postInsert(UserRequest $request) 
    {
        return view('users_form',compact(
            'model','user_agents','user_teams','teams','team_users','user_no_team'
        ));
    }


    /**
     * 編輯
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request,$id = '') 
    {

        $model = $this->loadModel($id);

        $input = $request->old('user');

        if (!empty($input)) {

            $model->fill($input);

            //使用者目前所有代理人(前台in_array)
            $user_agents = $input['agent'];

            //使用者目前的團隊(前台in_array)
            $user_teams =  $input['team'];

        } else {

            //使用者目前所有代理人(前台in_array)
            $user_agents = UserAgent::getAgentIdByUserId($id)->toArray();

            //使用者目前的團隊(前台in_array)
            $user_teams =  UserTeam::getTeamIdByUserId($id)->toArray();

        }
        
        //全部團隊列表
        $teams = Team::getAllTeam();

        //除了使用者本身，所有人的團隊(代理人使用)
        $user_no_team = $team_users = [];
        foreach(User::getAllUsersExcludeUserId($id) as $users){

            if ($users->UserTeam()->first()) {

                $team_users[] = $users->UserTeam()->first();

            } else {

                //沒團隊的人
                $user_no_team[] = $users;

            }
        }

        return view('users_form',compact(
            'model','user_agents','user_teams','teams','team_users','user_no_team'
        ));
    }

    /**
     * 修改
     *
     * @return \Illuminate\Http\Response
     */
    public function postUpdate(UserRequest $request) 
    {
        $input = $request->input('user');
        $input['job_seek'] = 0;
        if ($input['status'] == 2) {

            $input['job_seek'] = 1;
            $input['status'] = 1;

        }

        //user資料儲存
        $model = $this->loadModel($input['id']);

        //上傳圖片 注意：須於 public 下建立連結 - php artisan storage:link 
        $image_url = '';
        if ($request->hasFile('user') && $request->file('user')['avatar']->isValid()) {
            $input_file = Input::file('user');
            $file_extension = $input_file['avatar']->getClientOriginalExtension();
            
            $filename = $input['nickname'] . '.' . $file_extension; //命名方式依照各專案需求
            $image = $this->image_root_path . $filename;

            if (Image::make($input_file['avatar'])->save($image)) {
                $input['avatar'] = $filename;
            }
        }

        $model->fill($input);
        if ($model->save()) {

            //修改代理人
            UserAgent::deleteUserAgentByUserId($model->id);
            if(!empty($input['agent'])){

                $user_agents = $input['agent'];
                foreach($user_agents as $agent_id){

                    $agent = new UserAgent;
                    $agent->fill([
                        'user_id' => $model->id,
                        'agent_id' => $agent_id,
                    ]);
                    $agent->save();

                }

            }

            //修改團隊
            UserTeam::deleteUserTeamByUserId($model->id);
            if (!empty($input['team'])) {

                $user_teams = $input['team'];
                foreach($user_teams as $team_id){

                    $team = new UserTeam;
                    $team->fill([
                        'user_id' => $model->id,
                        'team_id' => $team_id,
                        'role' => 'user',
                    ]);
                    $team->save();

                }

            } 

            return Redirect::to('user/index')->withErrors(['msg' => '修改成功']);

        } else {

            return Redirect::back()->withInput();

        }
    }

    private function loadModel($id) 
    {
        $model = User::find($id);
        if ($model===false) {
            throw new CHttpException(404,'資料不存在');
        }
            
        return $model;
    }
}
