<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [
    'as' => 'root_path',
    'uses' => 'Auth\LoginController@getIndex',
]);

Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('login_google');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    # dashboard
    Route::get('index', ['uses' => 'SiteController@getIndex'])->name('index');
    Route::post('index', [
        'as' => 'index/ajax',
        'uses' => 'SiteController@ajaxGetAllAvailableLeaveListByDateRange',
    ]);

    // 主管協助申請請假
    Route::group(['prefix'=>'leave_assist'], function(){
        Route::get('getIndex', [
            'as' => 'leave_assist/getIndex',
            'uses' => 'LeaveController@getIndex',
        ]);

        Route::get('create/{id}', [
            'as' => 'leave_assist/create',
            'uses' => 'LeaveController@getCreate',
        ]);

        Route::post('insert', [
            'as' => 'leave_assist/insert',
            'uses' => 'LeaveController@postInsert',
        ]);

        Route::post('calculate_hours',[
            'as' => 'leave_assist/calculate_hours',
            'uses' => 'LeaveController@calculate_hours',
        ]);
    });

    # 我是代理人
    Route::group(['prefix'=>'agent'], function(){
        Route::any('index',[
            'as'=>'agent/index',
            'uses'=> 'LeaveAgentController@getIndex',
        ]);

        Route::get('edit/{id}',[
            'as'=>'agent/edit',
            'uses'=> 'LeaveAgentController@getEdit',
        ]);

        Route::any('leave_detail/{id}', [
            'as' => 'agent/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    // 系統設定
    Route::group(['prefix'=>'config'], function(){
        Route::get('edit',[
            'as'=>'config/edit',
            'uses'=> 'SystemConfController@getIndex',
        ]);

        Route::post('update',[
            'as'=>'config/update',
            'uses'=> 'SystemConfController@postUpdate',
        ]);

        Route::post('upload', [
            'as' => 'config/upload',
            'uses' => 'SystemConfController@postUpload',
        ]);

        Route::post('delete', [
            'as' => 'config/delete',
            'uses' => 'SystemConfController@postDelete',
        ]);
    });

    // 團隊設定
    Route::group(['prefix'=>'teams'], function(){
        Route::get('index',[
            'as' => 'teams/index',
            'uses' => 'TeamController@getAllTeamAndUser',
        ]);

        Route::post('create',[
            'as' => 'teams/create',
            'uses' => 'TeamController@ajaxCreateData',
        ]);

        Route::post('delete',[
            'as' => 'teams/delete',
            'uses' => 'TeamController@ajaxDeleteData',
        ]);

        Route::post('update',[
            'as' => 'teams/update',
            'uses' => 'TeamController@ajaxUpdateData',
        ]);

        Route::post('memberSet',[
            'as' => 'teams/memberSet',
            'uses' => 'UserTeamController@postMemberSet',
        ]);

        Route::post('update_drop',[
            'as' => 'teams/update_drop',
            'uses' => 'TeamController@ajaxUpdateDrop',
        ]);
    });

    # 員工管理
    Route::group(['prefix'=>'user'], function(){
        Route::any('index',[
            'as' => 'user/index',
            'uses' => 'UserController@getIndex',
        ]);

        Route::post('update',[
            'as' => 'user/update',
            'uses' => 'UserController@postUpdate',
        ]);

        Route::get('edit/{id}', [
            'as' => 'user/edit',
            'uses' => 'UserController@getEdit',
        ]);
    });

    # 假別管理
    Route::group(['prefix'=>'leave_type'], function(){
        Route::match(['get', 'post'], 'index',[
            'as' => 'leave_type',
            'uses' => 'LeaveTypeController@getIndex',
        ]);

        Route::get('create',[
            'as' =>'leave_type/create',
            'uses' => 'LeaveTypeController@getCreate',
        ]);

        Route::get('edit/{id}',[
            'as' => 'leave_type/edit',
            'uses' => 'LeaveTypeController@getEdit',
        ]);

        Route::get('delete/{id}',[
            'as' => 'leave_type/delete',
            'uses' => 'LeaveTypeController@postDelete',
        ]);

        Route::post('insert',[
            'as' => 'leave_type/insert',
            'uses' => 'LeaveTypeController@postInsert',
        ]);

        Route::post('update',[
            'as' => 'leave_type/update',
            'uses' => 'LeaveTypeController@postUpdate',
        ]);

        Route::post('update_ajax',[
            'as' => 'leave_type/update_ajax',
            'uses' => 'LeaveTypeController@ajaxUpdateData',
        ]);
    });

    # 國定假日/補班
    Route::group(['prefix'=>'holidies'], function(){
        Route::match(['get', 'post'], 'index', [
            'as' => 'holidies',
            'uses' => 'HolidayController@getIndex',
        ]);

        Route::get('create', [
            'as' => 'holidies/create',
            'uses' => 'HolidayController@getCreate',
        ]);

        Route::get('edit/{id}', [
            'as' => 'holidies/edit',
            'uses' => 'HolidayController@getEdit',
        ]);

        Route::get('delete/{id}', [
            'as' => 'holidies/delete',
            'uses' => 'HolidayController@postDelete',
        ]);

        Route::post('insert', [
            'as' => 'holidies/insert',
            'uses' => 'HolidayController@postInsert',
        ]);

        Route::post('update', [
            'as' => "holidies/update",
            'uses' => 'HolidayController@postUpdate',
        ]);
    });

    // 報表
    Route::group(['prefix'=>'report'], function(){
        Route::any('index',[
            'as' => 'report/index',
            'uses' => 'ReportController@postIndex',
        ]);

        Route::any('vacation/{year}/{month}/{user_id}/{type_id}',[
            'as' => 'report/vacation',
            'uses' => 'ReportController@getUserData'
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'report/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    # 特休報表
    Route::group(['prefix'=>'annual_report'], function(){
        Route::any('index',[
            'as'=>'annual_report/index',
            'uses'=> 'AnnualReportController@getIndex',
        ]);

        Route::get('view/{id}/{year}', [
            'as' => 'annual_report/view',
            'uses' => 'AnnualReportController@getView',
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'annual_report/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    // 特休結算
    Route::group(['prefix'=>'annual_leave_calculate'], function(){
        Route::any('index', [
            'as' => 'annual_leave_calculate/index',
            'uses' => 'AnnualHoursController@getIndex',
        ]);
        Route::get('view/{id}/{year}', [
            'as' => 'annual_leave_calculate/view',
            'uses' => 'AnnualHoursController@getView',
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'annual_leave_calculate/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    // 離職人員結算
    Route::group(['prefix'=>'leaved_user_annual_leave_calculate'], function(){
        Route::any('index', [
            'as' => 'leaved_user_annual_leave_calculate/index',
            'uses' => 'LeavedUserAnnualHoursController@getIndex',
        ]);

        Route::get('view/{id}/{year}', [
            'as' => 'leaved_user_annual_leave_calculate/view',
            'uses' => 'LeavedUserAnnualHoursController@getView',
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'leaved_user_annual_leave_calculate/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    # 我的假單
    Route::group(['prefix'=>'leaves_my'], function(){
        Route::any('prove',[
            'as'=>'leaves_my/prove',
            'uses'=> 'LeavesMyController@getProve',
        ]);

        Route::any('upcoming',[
            'as'=>'leaves_my/upcoming',
            'uses'=> 'LeavesMyController@getUpcoming',
        ]);

        Route::any('history',[
            'as'=>'leaves_my/history',
            'uses'=> 'LeavesMyController@getHistory',
        ]);

        Route::get('update/{id}',[
            'as'=>'leaves_my/update',
            'uses'=> 'LeavesMyController@postUpdate',
        ]);

        Route::any('leave_detail/{id}', [
            'as' => 'leaves_my/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    # 同意代理嗎?
    Route::group(['prefix'=>'agent_approve'], function(){
        Route::any('index',[
            'as'=>'agent_approve/index',
            'uses'=> 'AgentApproveController@getIndex',
        ]);

        Route::post('insert',[
            'as'=>'agent_approve/insert',
            'uses'=> 'AgentApproveController@postInsert',
        ]);

        Route::any('edit/{id}',[
            'as'=>'agent_approve/edit',
            'uses'=> 'AgentApproveController@getEdit',
        ]);

        Route::any('leave_detail/{id}', [
            'as' => 'agent_approve/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
        
    });

    // 我要放假
    Route::group(['prefix'=>'leave'], function(){

        Route::get('create', [
            'as' => 'leave/create',
            'uses' => 'LeaveController@getCreate',
        ]);

        Route::post('insert', [
            'as' => 'leave/insert',
            'uses' => 'LeaveController@postInsert',
        ]);

        Route::post('calculate_hours',[
            'as' => 'leave/calculate_hours',
            'uses' => 'LeaveController@calculate_hours',
        ]);

        //我的假單詳細頁
        Route::any('edit/{id}', [
            'as' => 'leave/edit',
            'uses' => 'LeaveController@getEdit',
        ]);

        Route::post('update', [
            'as' => 'leave/update',
            'uses' => 'LeaveController@postUpdate',
        ]);

        Route::post('upload', [
            'as' => 'leave/upload',
            'uses' => 'LeaveController@postUpload',
        ]);

        Route::post('delete', [
            'as' => 'leave/delete',
            'uses' => 'LeaveController@postDelete',
        ]);

        Route::any('leave_eliminate/{id}', [
            'as' => 'leave/leave_eliminate',
            'uses' => 'LeaveController@postEliminateLeaves',
        ]);
    });

    # 團隊假單-主管
    Route::group(['prefix'=>'leaves_manager'], function(){
        Route::any('prove/{role}',[
            'as'=>'leaves_manager/prove',
            'uses'=> 'LeavesManagerController@getProve',
        ]);

        Route::any('upcoming/{role}',[
            'as'=>'leaves_manager/upcoming',
            'uses'=> 'LeavesManagerController@getUpcoming',
        ]);

        Route::any('history/{role}',[
            'as'=>'leaves_manager/history',
            'uses'=> 'LeavesManagerController@getHistory',
        ]);

        Route::any('calendar/{role}',[
            'as'=>'leaves_manager/calendar',
            'uses'=> 'LeavesManagerController@getCalendar',
        ]);

        Route::any('calendar/',[
            'as'=>'leaves_manager/calendar/ajax',
            'uses' => 'SiteController@ajaxGetAllAvailableLeaveListByDateRange',
        ]);
        Route::post('insert/{role}',[
            'as' => 'leaves_manager/insert',
            'uses' => 'LeavesManagerController@postInsert',
        ]);

        Route::get('edit/{id}',[
            'as' => 'leaves_manager/edit',
            'uses' => 'LeavesManagerController@getEdit',
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'leaves_manager/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    # 團隊假單-HR
    Route::group(['prefix'=>'leaves_hr'], function(){
        Route::any('prove',[
            'as'=>'leaves_hr/prove',
            'uses'=> 'LeavesHrController@getProve',
        ]);

        Route::any('upcoming',[
            'as'=>'leaves_hr/upcoming',
            'uses'=> 'LeavesHrController@getUpcoming',
        ]);

        Route::any('history',[
            'as'=>'leaves_hr/history',
            'uses'=> 'LeavesHrController@getHistory',
        ]);

        Route::get('edit/{id}',[
            'as'=>'leaves_hr/edit',
            'uses'=> 'LeavesHrController@getEdit',
        ]);
        Route::any('leave_detail/{id}', [
            'as' => 'leaves_hr/leave_detail',
            'uses' => 'LeaveController@getEdit',
        ]);
    });

    // 天災假設定
    Route::group(['prefix'=>'natural'], function(){
        Route::get('index',[
            'as'=>'natural/index',
            'uses'=> 'NaturalController@getIndex',
        ]);

        Route::any('edit',[
            'as'=>'natural/edit',
            'uses'=> 'NaturalController@getEdit',
        ]);

        Route::post('update',[
            'as'=>'natural/update',
            'uses'=> 'NaturalController@postUpdate',
        ]);
    });

    // 
    Route::group(['prefix'=>'sheet'], function(){

        Route::group(['prefix'=>'daily'], function(){

            Route::get('index',[
                'as'=>'sheet/daily/index',
                'uses'=> 'sheet\DailyController@getIndex',
            ]);

            Route::get('creat',[
                'as'=>'sheet/daily/creat',
                'uses'=> 'sheet\DailyController@getEdit',
            ]);

            Route::post('update',[
                'as'=>'sheet/daily/update',
                'uses'=> 'sheet\DailyController@postUpdate',
            ]);
        });
    });

    // 工作日誌
    Route::group(['prefix'=>'sheet'], function(){
        //搜尋
        Route::group(['prefix'=>'search'], function(){
            Route::get('index',[
                'as'=>'sheet/search/index',
                'uses'=> 'SheetSearchController@getIndex',
            ]);
        });

        //權限
        Route::group(['prefix'=>'auth'], function(){
            Route::get('index',[
                'as'=>'sheet/auth/index',
                'uses'=> 'SheetAuthController@getIndex',
            ]);
        });

        // 月報表
        Route::group(['prefix'=>'calendar'], function(){
            Route::get('view/{user_id?}', [
                'as' => 'sheet/calendar/view',
                'uses' => 'Sheet\CalendarController@view',
            ]);

            Route::post('ajax_sheet', [
                'as' => 'sheet/calendar/ajax_sheet',
                'uses' => 'Sheet\CalendarController@ajaxGetWorkByUserAndMonth',
            ]);
        });

        # 缺填次數報表
        Route::any('absense_report/index',[
            'as'=>'absense_report/index',
            'uses'=> 'Sheet\AbsenceController@getIndex',
        ]);
    });

    # 工作日誌 - 專案項目設定
    Route::group(['prefix'=>'sheet_project'], function(){
        Route::match(['get', 'post'], 'index',[
            'as' => 'sheet_project/index',
            'uses' => 'Sheet\SheetProjectController@getIndex',
        ]);

        Route::get('create',[
            'as' =>'sheet_project/create',
            'uses' => 'Sheet\SheetProjectController@getCreate',
        ]);

        Route::get('edit',[
            'as' => 'sheet_project/edit',
            'uses' => 'Sheet\SheetProjectController@getEdit',
        ]);

        Route::get('delete',[
            'as' => 'sheet_project/delete',
            'uses' => 'Sheet\SheetProjectController@postDelete',
        ]);

        Route::post('insert',[
            'as' => 'sheet_project/insert',
            'uses' => 'Sheet\SheetProjectController@postInsert',
        ]);

        Route::post('update',[
            'as' => 'sheet_project/update',
            'uses' => 'Sheet\SheetProjectController@postUpdate',
        ]);

        Route::post('update_ajax',[
            'as' => 'sheet_project/update_ajax',
            'uses' => 'Sheet\SheetProjectController@ajaxUpdateData',
        ]);
    });

});

Route::get('export_excel/{year}/{month}',[
    'as' => 'export_excel',
    'uses' => 'ExportController@ExportReport',
]);

Route::get('export_annual_excel/{year}',[
    'as' => 'export_annual_excel',
    'uses' => 'ExportController@ExportAnnualReport',
]);

Route::get('export_annual_hour_excel/{year}',[
    'as' => 'export_annual_hour_excel',
    'uses' => 'ExportController@ExportAnnualHoursReport',
]);

Route::get('export_leaved_hour_excel/{year}',[
    'as' => 'export_leaved_hour_excel',
    'uses' => 'ExportController@ExportLeavedHoursReport',
]);

Route::match(['get', 'post'], '/demo/image',[
    'as'=>'demo_image',
    'uses'=> 'DemoControllor@getImage',
]);