<?php 
// DashBoard
Breadcrumbs::register('index/ajax', function ($breadcrumbs) {
    $breadcrumbs->push('Dashboard');
});

// 我要放假
Breadcrumbs::register('leave/create', function ($breadcrumbs) {
    $breadcrumbs->push('我要放假');
});

// 我的假單
Breadcrumbs::register('leaves_my', function ($breadcrumbs) {
    $breadcrumbs->push('我的假單',route('leaves_my/prove'));
});

// 協助申請列表
Breadcrumbs::register('leave_assist/index', function ($breadcrumbs) {
    $breadcrumbs->push('協助申請請假', route('leave_assist/getIndex'));
});

// 協助申請請假
Breadcrumbs::register('leave_assist/create', function ($breadcrumbs,$user_name) {
    $breadcrumbs->parent('leave_assist/index');
    $breadcrumbs->push($user_name.'放假單');
});

// 同意代理嗎?
Breadcrumbs::register('agent_approve', function ($breadcrumbs) {
    $breadcrumbs->push('同意代理嗎?',route('agent_approve/index'));
});

// 我是代理人
Breadcrumbs::register('agent', function ($breadcrumbs) {
    $breadcrumbs->push('我是代理人',route('agent/index'));
});

// 團隊假單- manager
Breadcrumbs::register('leaves_manager', function ($breadcrumbs) {
    $breadcrumbs->push('團隊假單','javascript:window.history.go(-1);');
});

// 團隊假單- hr
Breadcrumbs::register('leaves_hr', function ($breadcrumbs) {
    $breadcrumbs->push('團隊假單','javascript:window.history.go(-1);');
});

// 天災假調整
Breadcrumbs::register('natural', function ($breadcrumbs) {
    $breadcrumbs->push('天災假調整');
});

// 基本設定
Breadcrumbs::register('setting', function ($breadcrumbs) {
    $breadcrumbs->push('基本設定');
});

// 系統設定
Breadcrumbs::register('config', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('系統設定');
});

// 團隊設定
Breadcrumbs::register('team', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('團隊設定');
});

// 員工管理
Breadcrumbs::register('user', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('員工管理', route('user/index'));
});

// 員工管理 - 修改資料
Breadcrumbs::register('user/edit', function ($breadcrumbs) {
    $breadcrumbs->parent('setting');
    $breadcrumbs->push('基本資料修改');
});

// 假期設定
Breadcrumbs::register('leave_setting', function ($breadcrumbs) {
    $breadcrumbs->push('假期設定');
});

// 假別管理
Breadcrumbs::register('leave_type', function ($breadcrumbs) {
    $breadcrumbs->parent('leave_setting');
    $breadcrumbs->push('假別管理', route('leave_type'));
});

// 假別管理 - 修改資料
Breadcrumbs::register('leave_type/edit', function ($breadcrumbs,$action) {
    $breadcrumbs->parent('leave_type');
    $breadcrumbs->push('資料'.$action);
});

// 國定假日/補班
Breadcrumbs::register('holidies', function ($breadcrumbs) {
    $breadcrumbs->parent('leave_setting');
    $breadcrumbs->push('國定假日/補班', route('holidies'));
});

// 國定假日/補班 - 修改資料
Breadcrumbs::register('holidies/edit', function ($breadcrumbs,$action) {
    $breadcrumbs->parent('holidies');
    $breadcrumbs->push('資料'.$action);
});

// 月/年報表
Breadcrumbs::register('month_year_report', function ($breadcrumbs) {
    $breadcrumbs->push('月/年報表');
});

// 報表
Breadcrumbs::register('report', function ($breadcrumbs) {
    $breadcrumbs->parent('month_year_report');
    $breadcrumbs->push('報表', route('report/index'));
});

// 報表列表
Breadcrumbs::register('report/view', function ($breadcrumbs,$leave_type) {
    $breadcrumbs->parent('report');
    $breadcrumbs->push($leave_type.'列表','javascript:window.history.go(-1);');
});

// 特休報表
Breadcrumbs::register('annual_report', function ($breadcrumbs) {
    $breadcrumbs->parent('month_year_report');
    $breadcrumbs->push('特休報表', route('annual_report/index'));
});

// 特休假單列表
Breadcrumbs::register('annual_report/view', function ($breadcrumbs) {
    $breadcrumbs->parent('annual_report');
    $breadcrumbs->push('特休假單列表','javascript:window.history.go(-1);');
});

// 特休結算
Breadcrumbs::register('annual_leave_calculate', function ($breadcrumbs) {
    $breadcrumbs->parent('month_year_report');
    $breadcrumbs->push('特休結算', route('annual_leave_calculate/index'));
});

// 特休假單列表(結算用)
Breadcrumbs::register('annual_leave_calculate/view', function ($breadcrumbs) {
    $breadcrumbs->parent('annual_leave_calculate');
    $breadcrumbs->push('特休假單列表','javascript:window.history.go(-1);');
});

// 特休結算(離職)
Breadcrumbs::register('leaved_user_annual_leave_calculate', function ($breadcrumbs) {
    $breadcrumbs->parent('month_year_report');
    $breadcrumbs->push('特休結算(離職)', route('leaved_user_annual_leave_calculate/index'));
});

// 特休假單列表(離職)
Breadcrumbs::register('leaved_user_annual_leave_calculate/view', function ($breadcrumbs) {
    $breadcrumbs->parent('leaved_user_annual_leave_calculate');
    $breadcrumbs->push('特休假單列表(離職)','javascript:window.history.go(-1);');
});

// 搜尋
Breadcrumbs::register('sheet/search/index', function ($breadcrumbs) {
    $breadcrumbs->push('搜尋',route('sheet/search/index'));
});

// 假單詳細頁
Breadcrumbs::register('leave/view', function ($breadcrumbs,$bread,$leave_name = '') {

    if ($bread == 'leaves_my') { //我的假單

      $breadcrumbs->parent('leaves_my');

    } elseif ($bread == 'agent_approve') { //同意代理嗎?

      $breadcrumbs->parent('agent_approve');

    } elseif ($bread == 'leaves_hr') { //hr 團隊假單

      $breadcrumbs->parent('leaves_hr');

    } elseif ($bread == 'leaves_manager') { //manager 團隊假單

      $breadcrumbs->parent('leaves_manager');

    } elseif ($bread == 'report') { //報表

      $breadcrumbs->parent('report/view',$leave_name);

    } elseif ($bread == 'annual_report') { //特休假單列表

      $breadcrumbs->parent('annual_report/view');

    } elseif ($bread == 'annual_leave_calculate') { //特休假單列表 - 結算

      $breadcrumbs->parent('annual_leave_calculate/view');

    } elseif ($bread == 'leaved_user_annual_leave_calculate') { //特休假單列表(離職)

      $breadcrumbs->parent('leaved_user_annual_leave_calculate/view');

    } elseif ($bread == 'agent') { //我是代理人

      $breadcrumbs->parent('agent');

    }
    
    $breadcrumbs->push('假單檢示');
});