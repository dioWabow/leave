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
    });

});

Route::match(['get', 'post'], '/demo/image',[
    'as'=>'demo_image',
    'uses'=> 'DemoControllor@getImage',
]);