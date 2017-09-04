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
    return view('index');
})->name('root_path');

// Route::get('/index', function () {
//     return view('index');
// })->name('index');

Route::get('index', ["uses"=>"SiteController@getIndex"])->name('index');

Route::post('index', ["uses"=>"SiteController@ajaxGetAllAvailableLeaveListByDateRange", "as"=>"indexChange"]);

Route::get('holidies', ["uses"=>"HolidayController@getIndex","as"=>"holidies"]);

Route::get('holidies/create', ["uses"=>"HolidayController@getCreate","as"=>"holidiesInsertForm"]);

Route::get('holidies/edit/{id}', ["uses"=>"HolidayController@getEdit","as"=>"holidiesUpdateForm"]);

Route::post('holidies/insert', ["uses"=>'HolidayController@postInsert',"as"=>"holidayCreate"]);

Route::post('holidies/update', ["uses"=>'HolidayController@postUpdate',"as"=>"holidayUpdate"]);

Route::any('holidies/search', ["uses"=>'HolidayController@getIndex',"as"=>"holidaySearch"]);

Route::get('holidies/delete/{id}', ["uses"=>"HolidayController@postDelete","as"=>"holidayDelete"]);

Route::get('/leave', function () {
    return view('leave');
})->name('leave');
Route::get('/leave_agent', function () {
    return view('leave_agent');
})->name('leave_agent');
Route::get('/leave_agent_finish_view', function () {
    return view('leave_agent_finish_view');
})->name('leave_agent_finish_view');
Route::get('/leave_agent_prove', function () {
    return view('leave_agent_prove');
})->name('leave_agent_prove');
Route::get('/leave_agent_view', function () {
    return view('leave_agent_view');
})->name('leave_agent_view');
Route::get('/leave_form', function () {
    return view('leave_form');
})->name('leave_form');
Route::get('/leave_form2', function () {
    return view('leave_form2');
})->name('leave_form2');
Route::get('/leave_form3', function () {
    return view('leave_form3');
})->name('leave_form3');
Route::get('/leave_form33', function () {
    return view('leave_form33');
})->name('leave_form33');
Route::get('/leave_hr', function () {
    return view('leave_hr');
})->name('leave_hr');
Route::get('/leave_hr_view', function () {
    return view('leave_hr_view');
})->name('leave_hr_view');
Route::get('/leave_manager', function () {
    return view('leave_manager');
})->name('leave_manager');
Route::get('/leave_manager_view', function () {
    return view('leave_manager_view');
})->name('leave_manager_view');
Route::get('/leave_type', function () {
    return view('leave_type');
})->name('leave_type');
Route::get('/leave_type_form', function () {
    return view('leave_type_form');
})->name('leave_type_form');
Route::get('/leave_view', function () {
    return view('leave_view');
})->name('leave_view');
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/natural_disaster', function () {
    return view('natural_disaster');
})->name('natural_disaster');
Route::get('/report', function () {
    return view('report');
})->name('report');
Route::get('/report-annual-leave', function () {
    return view('report-annual-leave');
})->name('report-annual-leave');
Route::get('/system_conf', function () {
    return view('system_conf');
})->name('system_conf');

Route::get('/teams', function () {
    return view('teams');
})->name('teams');
Route::get('/users', function () {
    return view('users');
})->name('users');
Route::get('/users_form', function () {
    return view('users_form');
})->name('users_form');
