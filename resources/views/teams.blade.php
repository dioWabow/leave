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
	<i class="fa fa-sitemap"></i> 團隊設定
	<small>Teams Setting</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li class="active">團隊設定</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">團隊清單</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group"><div class="row">

						<div class="col-md-4">
							<form class="form-inline" id="menu-add" action="" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" id="addInputName" placeholder="團隊名稱" required>
								</div>
								<br>
								<div class="form-group">
									<div class="input-group my-colorpicker2">
										<input type="text" class="form-control" id="addInputColor" placeholder="團隊顏色" >
										<div class="input-group-addon">
											<i></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<button class="btn btn-info" type="button" id="addButton">新增</button>
							</form>
							<form class="form-inline" id="menu-editor" style="display: none;" action="" method="POST">
								<h3>修改 "<span id="currentEditName"></span>" 名稱</h3>
								<div class="form-group">
									<input type="text" class="form-control" id="editInputName" placeholder="團隊名稱" required>
								</div>
								<br>
								<div class="form-group">
									<div class="input-group my-colorpicker2">
										<input type="text" class="form-control" id="editInputColor" placeholder="團隊顏色" >
										<div class="input-group-addon">
											<i></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<button class="btn btn-info" type="button" id="editButton">修改</button>
							</form>
						</div>
						<div class="col-md-8">
							<div class="dd nestable" id="nestable">
								<ol class="dd-list">
								@foreach($team_result as $team_data)
									<li class="dd-item" data-id="{{$team_data->id}}" data-name="{{$team_data->name}}" data-new="0" data-deleted="0">
										<div class="dd-handle">{{$team_data->name}}</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="{{$team_data->id}}">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="{{$team_data->id}}">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>
									</li>
								@endforeach
								</ol>
							</div>
						</div>
					</div></div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<form action="{{ route('teams/memberSet')}}" method="POST">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">夥伴設定</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-primary" id="memberReload"><i class="glyphicon glyphicon-repeat"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body" id="member_set">
					@foreach($team_result as $team_data)
						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>{{$team_data->name}}</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[{{$team_data->id}}][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
								@foreach($user_result as $user_data)
									@if(array_key_exists("$team_data->id", $team_user_list))
										@if(in_array($user_data->id, $team_user_list[$team_data->id]))
											<option value="{{$user_data->id}}" selected="">{{$user_data->nickname}}</option>
										@else
											<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
										@endif
									@else
										<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
									@endif
								@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="managers[{{$team_data->id}}][]" data-placeholder="請選擇主管">
								@foreach($user_result as $user_data)
									@if(array_key_exists("$team_data->id", $team_manager_list))
										@if(in_array($user_data->id, $team_manager_list[$team_data->id]))
											<option value="{{$user_data->id}}" selected="">{{$user_data->nickname}}</option>
										@else
											<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
										@endif
									@else
										<option value="">請選擇主管</option>
										<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
									@endif
								@endforeach
								</select>
							</div>
						</div></div>
					@endforeach
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<button type="reset" class="btn btn-default"><i class="fa fa-undo"></i> 取消</button>
							<button type="submit" class="btn btn-primary" id="data_post"><i class="fa fa-send-o"></i> Send</button>
						</div>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			</form>
		</div>
	</div>
<!-- /.content -->
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
