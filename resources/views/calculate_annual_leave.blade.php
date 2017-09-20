<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

@include('layouts.header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 特休結算
	<small>Annual Leave Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{route('index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>報表</li>
	<li class="active">特休結算</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form name="frmSetting" action="" method="POST">
							<div class="row">
								<div class="col-sm-5">
									<div class="label bg-blue" style="font-size:20px">{{Carbon\Carbon::parse()->format('Y')}}年</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											年份：
											<select id="setting_year" name="setting[year]" class="form-control">
                        @for ($i = 2015; $i <= Carbon\Carbon::parse()->format('Y'); $i++)
                        <option value="{{$i}}">{{$i}} 年</option>
                        @endfor
											</select>
										</label>
										<label><button type="button" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button></label>
										&nbsp;
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th width="3%"></th>
											<th><a href="#sort_name">姓名</a></th>
                      <th><a href="#sort_enter_date">到職日</a></th>
											<th><a href="#sort_total">總額度</a></th>
											<th><a href="#sort_used">使用額度</a></th>
											<th><a href="#sort_x">剩餘額度</a></th>
										</tr>
									</thead>
									<tbody>
                    @forelse($dataProvider as $annual_hour)
										<tr class='clickable-row' data-href='#'>
											<td>
												<img src="{{UrlHelper::getUserAvatarUrl($annual_hour->fetchUser->avatar)}}" class="img-circle" alt="{{$annual_hour->fetchUser->nickname}}" width="50px">
											</td>
                      <td>{{$annual_hour->fetchUser->nickname}}</td>
                      <td>{{TimeHelper::changeDateFormat($annual_hour->enter_date,'m')}}</td>
											<td>{{$annual_hour->annual_hours}}</td>
											<td>{{$annual_hour->used_annual_hours}}</td>
											<td>{{$annual_hour->remain_annual_hours}}</td>
										</tr>
                    @empty
                    <tr class='clickable-row' data-href='#'>
                      <td colspan="6" align="center">
                        無資料
                      </td>
                    </tr>
                    @endforelse
									</tbody>
									<tfotter>
										<tr class="text-red">
											<th></th>
											<th class="pull-right">總計(Hr)</th>
											<td>1400</td>
											<td>1220</td>
											<td>180</td>
										</tr>
									</tfotter>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016-2017 <a href="http://www.wabow.com" target="_blank">WABOW</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-file-text-o bg-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">人事規章</h4>

                <p>Rules</p>
              </div>
            </a>
          </li>
		  <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-wrench bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">異常回報</h4>

                <p>Error Report</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
</body>
</html>
