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

Route::get('/', function () {
    return view('login');
})->name('root_path');

Route::get('login/google', 'Auth\LoginController@redirectToGoogle')->name('login_google');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/leave.html', function () {
        return view('leave');
    })->name('leave');
    Route::get('/leave_agent.html', function () {
        return view('leave_agent');
    })->name('leave_agent');
    Route::get('/leave_agent_finish_view.html', function () {
        return view('leave_agent_finish_view');
    })->name('leave_agent_finish_view');
    Route::get('/leave_agent_prove.html', function () {
        return view('leave_agent_prove');
    })->name('leave_agent_prove');
    Route::get('/leave_agent_view.html', function () {
        return view('leave_agent_view');
    })->name('leave_agent_view');
    Route::get('/leave_form.html', function () {
        return view('leave_form');
    })->name('leave_form');
    Route::get('/leave_form2.html', function () {
        return view('leave_form2');
    })->name('leave_form2');
    Route::get('/leave_form3.html', function () {
        return view('leave_form3');
    })->name('leave_form3');
    Route::get('/leave_form33.html', function () {
        return view('leave_form33');
    })->name('leave_form33');
    Route::get('/leave_hr.html', function () {
        return view('leave_hr');
    })->name('leave_hr');
    Route::get('/leave_hr_view.html', function () {
        return view('leave_hr_view');
    })->name('leave_hr_view');
    Route::get('/leave_manager.html', function () {
        return view('leave_manager');
    })->name('leave_manager');
    Route::get('/leave_manager_view.html', function () {
        return view('leave_manager_view');
    })->name('leave_manager_view');
    Route::get('/leave_view.html', function () {
        return view('leave_view');
    })->name('leave_view');
    Route::get('/login.html', function () {
        return view('login');
    })->name('login');
    Route::get('/natural_disaster.html', function () {
        return view('natural_disaster');
    })->name('natural_disaster');
    Route::get('/report.html', function () {
        return view('report');
    })->name('report');

    Route::get('/report-annual-leave.html', function () {
        return view('report-annual-leave');
    })->name('report-annual-leave');
    Route::get('/system_conf.html', function () {
        return view('system_conf');
    })->name('system_conf');

    # dashboard
    Route::get('index', ['uses' => 'SiteController@getIndex'])->name('index');
    Route::post('index', [
        'as' => 'index/ajax',
        'uses' => 'SiteController@ajaxGetAllAvailableLeaveListByDateRange',
    ]);

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
    });

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
    });
    
    // 報表
    Route::group(['prefix'=>'report'], function(){
        Route::any('index',[
            'as' => 'report/index',
            'uses' => 'ReportController@postIndex',
        ]);

        Route::get('vacation',[
            'as' => 'report/vacation',
            'uses' => 'ReportController@getUserData'
        ]);
    });
});

Route::match(['get', 'post'], '/demo/image',[
    'as'=>'demo_image',
    'uses'=> 'DemoControllor@getImage',
]);
