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
	<i class="fa fa-github-alt"></i> 我是代理人
	<small>Agent Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">我是代理人</li>
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
									<thead>
										<tr>
											<th width="3%"><a href="#sort_name">請假者</a></th>
											<th><a href="#sort_datetime">時間</a></th>
											<th><a href="#sort_reason">原因</a></th>
											<th width="8%"><a href="#sort_hours">時數(HR)</a></th>
											<th width="8%"><a href="#sort_days"></a></th>
										</tr>
									</thead>
									<tbody>
										<tr class='clickable-row' data-href='leave_agent_finish_view.html'>
											<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
											<td>2017-08-10 (早上)</td>
											<td>找客戶 - 蔥媽媽</td>
											<td>3</td>
											<td class="text-red">倒數1天</td>
										</tr>
										<tr class='clickable-row' data-href='leave_agent_finish_view.html'>
											<td><img src="dist/img/users/rita.png" class="img-circle" alt="Rita" width="50px"></td>
											<td>2017-11-14 (整天）</td>
											<td>找客戶 - 蔥媽媽</td>
											<td>3</td>
											<td>倒數97天</td>
										</tr>
										<tr class='clickable-row' data-href='leave_agent_finish_view.html'>
											<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
											<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
											<td>找客戶 - 蔥媽媽</td>
											<td>3</td>
											<td>還有94天</td>
										</tr>
										<tr class='clickable-row' data-href='leave_agent_finish_view.html'>
											<td><img src="dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px"></td>
												<td>2017-12-11 ~ 2017-12-13</td>
											<td>找客戶 - 蔥媽媽</td>
											<td>24</td>
											<td>還有124天</td>
										</tr>
									</tbody>
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
