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
    Route::get('index', ["uses"=>"SiteController@getIndex"])->name('index');
    Route::post('index', ["uses"=>"SiteController@ajaxGetAllAvailableLeaveListByDateRange", "as"=>"indexChange"]);
	
    Route::any('holidies/index', ["uses"=>"HolidayController@getIndex","as"=>"holidies"]);
    Route::get('holidies/create', ["uses"=>"HolidayController@getCreate","as"=>"holidiesInsertForm"]);
    Route::get('holidies/edit/{id}', ["uses"=>"HolidayController@getEdit","as"=>"holidiesUpdateForm"]);
    Route::post('holidies/insert', ["uses"=>'HolidayController@postInsert',"as"=>"holidayCreate"]);
    Route::post('holidies/update', ["uses"=>'HolidayController@postUpdate',"as"=>"holidayUpdate"]);
    Route::get('holidies/delete/{id}', ["uses"=>"HolidayController@postDelete","as"=>"holidayDelete"]);    
    
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
    Route::get('/leave_type.html', function () {
        return view('leave_type');
    })->name('leave_type');
    Route::get('/leave_type_form.html', function () {
        return view('leave_type_form');
    })->name('leave_type_form');
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

    Route::get('/teams.html', function () {
        return view('teams');
    })->name('teams');

Route::any('user/index',[
        'uses' => 'UserController@getIndex',
        'as' => 'user/index',
        ]);

Route::post('user/update',[
        'uses' => 'UserController@postUpdate',
        'as' => 'user/update'
        ]);

Route::get('user/edit/{id}', [
        'uses' => 'UserController@getEdit',
        'as' => 'user/edit',
        ]);
});

Route::match(['get', 'post'], '/demo/image',[
    'uses'=> 'DemoControllor@getImage',
    'as'=>'demo_image',
]);
