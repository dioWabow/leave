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
        'uses' => 'LeaveController@getCreate',
        'as' => 'leave/create',
        ]);

        Route::post('insert', [
            'uses' => 'LeaveController@postInsert',
            'as' => 'leave/insert',
        ]);

        Route::post('calculate_hours',[
            'uses' => 'LeaveController@calculate_hours',
            'as' => 'leave/calculate_hours',
        ]);
    });

    // 特休結算
    Route::group(['prefix'=>'annual_leave_calculate'], function(){
        Route::any('index', [
        'uses' => 'AnnualHoursController@getIndex',
        'as' => 'annual_leave_calculate/index',
        ]);

        Route::get('view/{id}/{year}', [
        'uses' => 'AnnualHoursController@getView',
        'as' => 'annual_leave_calculate/view',
        ]);
    });
    
});

Route::match(['get', 'post'], '/demo/image',[
    'as'=>'demo_image',
    'uses'=> 'DemoControllor@getImage',
]);
