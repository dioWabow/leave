<?php

namespace App\Http\Controllers\sheet;

use TimeHelper;
use App\TimeSheet;
use App\UserTeam;
use App\Project;
use App\TimesheetPermission;
use App\ProjectTeam;
use App\Http\Requests\DailyRequest;

use Auth;
use Redirect;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyController extends Controller
{
    private $current_user;

    public function __construct(Request $request)
    {
        //先取得現在的使用者
        $this->current_user = $request->current_user;
        
    }

    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex (Request $request)
    {
        /* 判斷傳過來的copy_date */
        if (!empty($request->old('time_sheet'))){

            $time_sheet = $request->old('time_sheet');
            $copy_date = $time_sheet['copy_date'];
            
        }
        
        $permission = new TimesheetPermission;
        $get_permission_user = $permission->getAllowUserIdByUserId(Auth::user()->id);
        
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        $current_user = (!empty($this->current_user) && $this->current_user != Auth::user()->id) ? $this->current_user : Auth::user()->id;
        
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('time_sheet');
            $request->session()->push('time_sheet.search', $search);
            $request->session()->push('time_sheet.order_by', $order_by);

            if (!empty($search['work_day'])) {
                
                $search['working_day'] = $search['work_day'];

            }
           
            $search['user_id'] =  $current_user;

        } else {
            
            /** 判斷是不是複製過來的日期 */
            if (!empty($copy_date)) {
                
                $search['working_day'] = $copy_date;
                
            } else {

                $search['working_day'] = Carbon::now()->format('Y-m-d');

            }
            
            $search['user_id'] =  $current_user;

            if (!empty($request->input('page') && !empty($request->session()->get('time_sheet')))) {

                $search = $request->session()->get('time_sheet.search.0');
                $order_by = $request->session()->get('time_sheet.order_by.0');

            } else {

                $request->session()->forget('time_sheet');

            }
            
        }
        
        $model = new TimeSheet;
        $dataProvider = $model->fill($order_by)->search($search);
        
        return view('daily_list', compact(
            'current_user', 'get_permission_user', 'search', 'model', 'dataProvider'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public function getCreate(Request $request)
    {
        /*先取得填寫人的所在的team*/
        $get_team_id = UserTeam::getTeamIdByUserId(Auth::user()->id);
        
        /*再取得該team可使用的project*/ 
        $project = ProjectTeam::getProjectIdByTeamId($get_team_id);

        $model = new TimeSheet;

        if (!empty($request->old('daily'))) {

            $input = $request->old('daily');
            $model->fill($input);

        }

        return  view('daily_list_form', compact(
            'confirm_date', 'model', 'project'
        ));
    }

    /**
     * 檢視
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit(Request $request, $id='')
    {
        /*先取得填寫人的所在的team*/
        $get_team_id = UserTeam::getTeamIdByUserId(Auth::user()->id);
        
        /*再取得該team可使用的project*/ 
        $project = ProjectTeam::getProjectIdByTeamId($get_team_id);
        
        $model = $this->loadModel($id);

        
        if (!empty($request->old('daily'))) {
            
            $input = $request->old('daily');
            $model->fill($input);

        }
       
        return view('daily_list_form', compact(
         'model','project'
        ));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public function postInsert(DailyRequest $request)
    {
        $input = $request->input('daily');
        $input = self::checkDataValue($input);

        if (!TimeHelper::checkEditSheetDate($input['working_day'])){

            return Redirect::back()->withInput()->withErrors(['msg' => '不可以新增小於七天前，大於一天後']);

        }

        //儲存資料
        $model = new TimeSheet;
        $model->fill($input);
        if ($model->save()) {

            return Redirect::route('sheet/daily/index')->with('success', '新增成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

        }
    }

    /**
     * 複製資料
     *
     * @param Request $request
     * @return Redirect
     */
    public function postCopy(Request $request)
    {
        $time_sheet = $request->input('time_sheet');
        $get_sheet = TimeSheet::getTimeSheetById($time_sheet['id']);
        
        if (TimeHelper::checkEditSheetDate($time_sheet['copy_date'])) {

            foreach ($get_sheet as $value) {

                //如果要先往前新增日誌，小時必須是0
                $hour = (Carbon::parse($time_sheet['copy_date'])->gt(Carbon::parse())) ? '0' : $value->hour ;

                $model = new TimeSheet;
                $model->fill([
                    'project_id' => $value->project_id,
                    'tag' => $value->tag,
                    'user_id' => $value->user_id,
                    'items' => $value->items,
                    'description' => $value->description,
                    'hour' =>  $hour,
                    'working_day' => $time_sheet['copy_date'],
                    'url' => $value->url,
                    'remark' => $value->remark,
                ]);

                if (!$model->save()) {
                     
                     return Redirect::back()->withInput()->withErrors(['msg' => '複製失敗']);

                }  

            }
            
            return Redirect::route( 'sheet/daily/index' )->withInput()->with('success', '複製成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '不可以複製小於七天前，大於一天後']);

        }
        
    }

    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */
    public function postUpdate(DailyRequest $request)
    {
        $input = $request->input('daily');
        $input = self::checkDataValue($input);
        
        //更新資料
        $model = new TimeSheet;
        $model = $this->loadModel($input['id']);
        $model->fill($input);
        
        if ($model->save()) {

            return Redirect::route('sheet/daily/index')->with('success', '更新成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public function postDelete(Request $request, $id)
    {
        $model = $this->loadModel($id)->delete();

        return Redirect::route('sheet/daily/index')->with('success', '刪除完畢。');
    }

    private function loadModel($id)
    {
        $model = TimeSheet::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }

        return $model;
    }

    private function checkDataValue($data)
    {
        if (!empty($data)) {

            $str_transfer = '';
            $str_transfer = e($data['items']);
            $data['items'] = $str_transfer;
            
            return $data;
        }
    }
}
