<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')
  <style>
	th {cursor: pointer;}
  </style>

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

@include('layouts.header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 月/年報表
	<small>Monthly/Year Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>報表</li>
	<li class="active">月/年報表</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form name="frmSetting" id="frmSearch" action="{{ route('report/index')}}" method="POST">
							<div class="row">
								<div class="col-sm-5">
									<div class="label bg-blue" style="font-size:20px">{{$year}}-{{$month}}</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											時間：
											<select id="setting_year" name="setting[year]" class="form-control">
												@for($i=2015; $i <= date('Y'); $i++)
												<option value="{{$i}}" @if("$year" == "$i")selected="selected"@endif>{{$i}} 年</option>
												@endfor
											</select>
											<select id="setting_month" name="setting[month]" class="form-control">
												<option value="year" @if("$month" == "year")selected="selected"@endif>整年</option>
												@for($j=1; $j < 13; $j++)
												<option @if($j < 10)value=0{{$j}}@else value={{$j}} @endif @if("$month" == "$j")selected="selected"@endif>{{$j}}月</option>
												@endfor
											</select>
										</label>
										<label><button type="submit" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button></label>
										&nbsp;
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
											<th><a>名稱</a></th>
											@foreach($all_type as $type_data)
											<th><a>{{$type_data->name}}</a></th>
											@endforeach
											<th><a>總計(Hr)</a></th>
											<th><a>扣薪</a></th>
										</tr>
									</thead>
									<tbody>
										@if(isset($all_user) && count($all_user) > 0)
										@foreach($all_user as $user_data)
											<tr class="clickable-row" data-href="#">
												<td>
													<img src="{{UrlHelper::getUserAvatarUrl($user_data->avatar)}}" class="img-circle" alt="{{$user_data->nickname}}" width="60px">
												</td>
												<td>{{$user_data->nickname}}</td>
												@foreach($report_data as $report_key => $report_value)
												@foreach($all_type as $type_data)
												@if("{{$report_key}}" == "{{$user_data->id}}")
												<td><a href="{{ route('report/vacation') }}?year={{$year}}&month={{$month}}&user_id={{$user_data->id}}&type_id={{$type_data->id}}">{{$report_value[$type_data->id]}}</a></td>
												@endif
												@endforeach
												@endforeach
												<td class="text-red">{{$report_data[$user_data->id]['sum']}}</td>
												<td><span class="label bg-red">{{$report_data[$user_data->id]['deductions']}}</span></td>
											</tr>
										@endforeach
										@endif
									</tbody>
									<tfoot>
										<tr class="text-red">
											<th></th>
											<th class="pull-right">總計(Hr)</th>
											@foreach($report_total as $key => $total_data)
											@if($key == "sum")
											<td class="text-red">{{$total_data}}</td>
											@elseif($key == "deductions")
											<td><span class="label bg-red">{{$total_data}}</span></td>
											@else
											<th>{{$total_data}}</th>
											@endif
											@endforeach
										</tr>
									</tfoot>
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
