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
	<i class="fa fa-github-alt"></i> 報表假單列表
	<small>Report Vacation List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="{{ route('report/index') }}">報表</a></li>
	<li class="active">報表假單列表</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-hover">
									<form name="vacationlist" id="vacation_list" action="{{ route('report/vacation')}}" method="GET">
										<input type="hidden" name="year" value="{{$year}}">
										<input type="hidden" name="month" value="{{$month}}">
										<input type="hidden" name="user_id" value="{{$user_id}}">
										<input type="hidden" name="type_id" value="{{$type_id}}">
										<input id="sort" type="hidden" name="order_by" @if(count($order_by) > 0)value="{{$order_by}}"@endif>
			                    		<input id="sort_way" type="hidden" name="order_way" @if(count($order_way) > 0)value="{{$order_way}}"@endif>
									</form>
									<thead>
										<tr>
											<th width="4%">請假者</th>
											<th><a href="javascript:void(0)" onclick="changeSort('start_time');">時間</a></th>
											<th>原因</th>
											<th width="8%"><a href="javascript:void(0)" onclick="changeSort('hours');">時數(HR)</a></th>
										</tr>
									</thead>
									<tbody>
										@foreach($user_data_list as $user_data)
										@foreach($user_vacation_list as $list_data)
										<tr class='clickable-row' data-href='#'>
											<td><img src="{{UrlHelper::getUserAvatarUrl($user_data->avatar)}}" class="img-circle" alt="{{$user_data->nickname}}" width="50px"></td>
											<td>{{ Carbon\Carbon::parse($list_data->start_time)->format('Y-m-d') }} ~ {{ Carbon\Carbon::parse($list_data->end_time)->format('Y-m-d') }}</td>
											<td>{{$list_data->reason}}</td>
											<td>{{$list_data->hours}}</td>
										</tr>
										@endforeach
										@endforeach
										@if(count($user_vacation_list) == 0)
											<tr class="">
												<td colspan="4" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
											</tr>
										@endif
									</tbody>
								</table>
								{!! $user_vacation_list->appends(\Request::except('page'))->render() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>

function changeSort(sort){
  order_by = $('#sort').val();
  order_way = $('#sort_way').val();
  $('#sort').val(sort);
  if (order_by == sort && order_way == "DESC") {
      $('#sort_way').val("ASC");
  } else {
    $('#sort_way').val("DESC");
  }
  $("#vacation_list").submit();
}
</script>
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

