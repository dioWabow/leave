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
						<form name="frmSetting" action="" method="POST">
							<div class="row">
								<div class="col-sm-5">
									<div class="label bg-blue" style="font-size:20px">2017-07</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											時間：
											<select id="setting_year" name="setting[year]" class="form-control">
												<option value="2017" selected="selected">2017 年</option>
												<option value="2016">2016 年</option>
											</select>
											<select id="setting_month" name="setting[month]" class="form-control">
												<option value="year">整年</option>
												<option value="1">一月</option>
												<option value="2">二月</option>
												<option value="3">三月</option>
												<option value="4">四月</option>
												<option value="5">五月</option>
												<option value="6">六月</option>
												<option value="7" selected="selected">七月</option>
												<option value="8">八月</option>
												<option value="9">九月</option>
												<option value="10">十月</option>
												<option value="11">十一月</option>
												<option value="12">十二月</option>
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
											<th><a href="#sort_name">名稱</a></th>
											<th><a href="#sort_x">善待假</a></th>
											<th><a href="#sort_x">生日假</a></th>
											<th><a href="#sort_x">久任假</a></th>
											<th><a href="#sort_x">年假</a></th>
											<th><a href="#sort_x">病假</a></th>
											<th><a href="#sort_x">有薪病假</a></th>
											<th><a href="#sort_x">生理假</a></th>
											<th><a href="#sort_x">公假</a></th>
											<th><a href="#sort_x">總計(Hr)</a></th>
											<th><a href="#sort_x">扣薪</a></th>
										</tr>
									</thead>
									<tbody>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="{{route('root_path')}}/dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px">
											</td>
											<td>毛毛</td>
											<td>4</td>
											<td>0</td>
											<td>0</td>
											<td>40</td>
											<td>2</td>
											<td>8</td>
											<td>8</td>
											<td>20</td>
											<td class="text-red">82</td>
											<td><span class="label bg-red">2</span></td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="{{route('root_path')}}/dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px">
											</td>
											<td>Dio</td>
											<td>4</td>
											<td>0</td>
											<td>0</td>
											<td>40</td>
											<td>2</td>
											<td>8</td>
											<td>8</td>
											<td>20</td>
											<td class="text-red">82</td>
											<td><span class="label bg-red">2</span></td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="{{route('root_path')}}/dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px">
											</td>
											<td>Wei</td>
											<td>4</td>
											<td>0</td>
											<td>0</td>
											<td>40</td>
											<td>2</td>
											<td>8</td>
											<td>8</td>
											<td>20</td>
											<td class="text-red">82</td>
											<td><span class="label bg-red">2</span></td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="{{route('root_path')}}/dist/img/users/eno.png" class="img-circle" alt="Eno" width="50px">
											</td>
											<td>Eno</td>
											<td>4</td>
											<td>0</td>
											<td>0</td>
											<td>40</td>
											<td>2</td>
											<td>8</td>
											<td>8</td>
											<td>20</td>
											<td class="text-red">82</td>
											<td><span class="label bg-red">2</span></td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="{{route('root_path')}}/dist/img/users/lube.png" class="img-circle" alt="Lube" width="50px">
											</td>
											<td>Lube</td>
											<td>4</td>
											<td>0</td>
											<td>0</td>
											<td>40</td>
											<td>2</td>
											<td>8</td>
											<td>8</td>
											<td>20</td>
											<td class="text-red">82</td>
											<td><span class="label bg-red">2</span></td>
										</tr>
									</tbody>
									<tfotter>
										<tr class="text-red">
											<th></th>
											<th class="pull-right">總計(Hr)</th>
											<th>40</th>
											<th>0</th>
											<th>0</th>
											<th>200</th>
											<th>10</th>
											<th>40</th>
											<th>40</th>
											<th>100</th>
											<th>410</th>
											<td><span class="label bg-red">10</span></td>
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
