<?php

namespace App\Http\Controllers;

use App\User;
use App\UserAgent;
use App\Team;
use App\UserTeam;

use Session;
use Image;
use Redirect;
use Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    public function __construct()
    {
        $this->image_path = 'avatar/';
        $this->image_root_path = storage_path() . '/app/public/' . $this->image_path;
    }
    /**
     * 
     *
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request) 
    {
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];

        if (!empty($search)||!empty($order_by)) {
            $request->session()->forget('users');
            $request->session()->push('users.search', $search);
            $request->session()->push('users.order_by', $order_by);
        } else {
            if (!empty($request->input('page')) && !empty($request->session()->get('users'))) {
                $search = $request->session()->get('users.search.0');
                $order_by = $request->session()->get('users.order_by.0');
            } else {
                $request->session()->forget('users');
            }
        }
        
        $model = New User;
        $dataProvider = $model->fill($order_by)->search($search);

        //全部團隊列表
        $teams = Team::getAllTeam();

        return view('users',compact(
            'search','model','dataProvider','teams'
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
        
        //全部團隊列表
        $teams = Team::getAllTeam();

        $user_no_team = [];
        //除了使用者本身，所有人的團隊(代理人使用)
        foreach(User::getAllUsersExcludeUserId($id) as $users){
            if ($users->UserTeam()->first()) {
                $team_users[] = $users->UserTeam()->first();  
            } else {
                //沒團隊的人
                $user_no_team[] = $users;
            }
        }

        //使用者目前所有代理人(前台in_array)
        $user_agents = UserAgent::getAgentIdByUserId($id);

        //使用者目前的團隊(前台in_array)
        $user_teams =  UserTeam::getTeamIdByUserId($id);

        if($request->isMethod('post')) {
           $input = $request->input('user');

            $input['job_seek'] = 0;
            if ($input['status'] == 2) {
                $input['job_seek'] = 1;
                $input['status'] = 1;
            }

            //user資料儲存
            $model = $this->loadModel($id);

            //上傳圖片
            //注意：須於 public 下建立連結 - php artisan storage:link 
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
                if(!empty($input['team'])){
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
                return Redirect::to('user/edit/'.$model->id)->withErrors(['msg' => '更新成功']);
            }else{
                // $validator->addMessage(['msg' => '更新失敗']);
            } 
        }

        return view('users_form',compact(
            'model','teams','team_users','user_no_team','user_agents','user_teams'
        ));
    }

    /**
     * 修改
     *
     * @return \Illuminate\Http\Response
     */
     public function postUpdate(UserRequest $request) 
     {
        
    }

    private function loadModel($id) 
    {
        $model = User::find($id);
        if($model===false)
            throw new CHttpException(404,'資料不存在');
            
        return $model;
    }
}
