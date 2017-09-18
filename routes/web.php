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

});

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

    #團隊設定
    Route::group(['prefix'=>'teams'], function(){
        Route::get('teams/index',[
            'uses' => 'TeamController@getAllTeamAndUser',
            'as' => 'teams/index',
        ]);

        Route::post('teams/create',[
            'uses' => 'TeamController@ajaxCreateData',
            'as' => 'teams/create',
        ]);

        Route::post('teams/delete',[
            'uses' => 'TeamController@ajaxDeleteData',
            'as' => 'teams/delete',
        ]);

        Route::post('teams/update',[
            'uses' => 'TeamController@ajaxUpdateData',
            'as' => 'teams/update',
        ]);

        Route::post('teams/memberSet',[
            'uses' => 'UserTeamController@postMemberSet',
            'as' => 'teams/memberSet'
        ]);

        Route::post('teams/update_drop',[
            'uses' => 'TeamController@ajaxUpdateDrop',
            'as' => 'teams/update_drop'
        ]);
    });

Route::match(['get', 'post'], '/demo/image',[
    'as'=>'demo_image',
    'uses'=> 'DemoControllor@getImage',
]);