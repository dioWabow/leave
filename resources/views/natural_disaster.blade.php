<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')

  <!-- Page script -->
<script>
$(function () {
    var $naturalDisasterList = $('.naturalDisasterList');

    $naturalDisasterList.hide();
    $('#settingSearch').on('click', function(){
        $naturalDisasterList.show();
    });

    $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    }).each(function(){
        $(this).val($(this).attr('date'));
    }).on('change', function(){ 
        $('#' + $(this).attr('id') + '_type option:eq(1)').prop('selected', true);
    });
});
</script>




  
</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">

@include('layouts.header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-cloud"></i> 天災假單調整
	<small>Natural Disaster Modify</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">天災假單調整</li>
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
								<form name="frmSetting" action="" method="POST">
									<div class="pull-left">
										<label>
											類型：
											<select id="setting_type" name="setting[type]" class="form-control">
												<option value="">請選擇</option>
												<option value="">大颱風</option>
												<option value="">大地震</option>
												<option value="">大停電</option>
											</select>
										</label>
										&nbsp;
										<label>
											開始時間：
											<input type="text" id="setting_start_date" name="setting[start_date]" class="form-control single-date">
										</label>
										&nbsp;
										<label>
											<select id="setting_start_date_type" name="setting[start_date_type]" class="form-control">
												<option value="">請選擇</option>
												<option value="">上午</option>
												<option value="">下午</option>
											</select>
										</label>
										&nbsp;
										<label>
											結束時間：
											<input type="text" id="setting_end_date" name="setting[end_date]" class="form-control single-date">
										</label>
										&nbsp;
										<label>
											<select id="setting_end_date_type" name="setting[end_date_type]" class="form-control">
												<option value="">請選擇</option>
												<option value="">上午</option>
												<option value="">下午</option>
											</select>
										</label>
										<label><button type="button" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button></label>
										&nbsp;
									</div>
								</form>
							</div>
						</div>
						<div class="row naturalDisasterList">
							<div class="col-sm-6">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th width="3%"></th>
											<th>名稱</th>
											<th width="50%">請假日期</th>
											<th width="10%">請假時數</th>
											<th width="10%">天災時數</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<img src="dist/img/wabow_logo.png" class="img-circle" alt="" width="50px">
											</td>
											<td>全體員工</td>
											<td>2017-10-04 (全天）</td>
											<td>0</td>
											<td>8</td>
										</tr>
										<tr>
											<td>
												<img src="dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px">
											</td>
											<td>毛毛</td>
											<td>2017-10-04 (全天）</td>
											<td>8</td>
											<td>8</td>
										</tr>

										<tr>
											<td>
												<img src="dist/img/users/rita.png" class="img-circle" alt="Rita" width="50px">
											</td>
											<td>Rita</td>
											<td>2017-10-04 ~ 2017-10-05 (上午）</td>
											<td>12</td>
											<td>8</td>
										</tr>
										<tr>
											<td>
												<img src="dist/img/users/sheng.png" class="img-circle" alt="Sheng" width="50px">
											</td>
											<td>Sheng</td>
											<td>2017-10-04 (下午）</td>
											<td>4</td>
											<td>4</td>
										</tr>
										<tr>
											<td>
												<img src="dist/img/users/carol.png" class="img-circle" alt="Carol" width="50px">
											</td>
											<td>Carol</td>
											<td>2017-10-04 (下午）~ 2017-10-05 (上午）</td>
											<td>8</td>
											<td>4</td>
										</tr>
									</tbody>
								</table>
								<div class="col-md-2 col-md-offset-5">
									<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> 收回天災調整</button>
								</div>
							</div>
						
							<div class="col-sm-6">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th width="3%"></th>
											<th>名稱</th>
											<th width="50%">請假日期</th>
											<th width="10%">請假時數</th>
											<th width="10%">天災時數</th>
											<th width="10%">調整時數</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px">
											</td>
											<td>Dio</td>
											<td>2017-10-04 (全天）</td>
											<td>8</td>
											<td>8</td>
											<td class="text-red">0</td>
										</tr>

										<tr>
											<td>
												<img src="dist/img/users/eno.png" class="img-circle" alt="Eno" width="50px">
											</td>
											<td>Eno</td>
											<td>2017-10-04 ~ 2017-10-05 (上午）</td>
											<td>12</td>
											<td>8</td>
											<td class="text-red">4</td>
										</tr>
										<tr>
											<td>
												<img src="dist/img/users/evan.png" class="img-circle" alt="Evan" width="50px">
											</td>
											<td>Evan</td>
											<td>2017-10-04 (下午）</td>
											<td>4</td>
											<td>4</td>
											<td class="text-red">0</td>
										</tr>
										<tr>
											<td>
												<img src="dist/img/users/tony.png" class="img-circle" alt="Tony" width="50px">
											</td>
											<td>Tony</td>
											<td>2017-10-04 (下午）~ 2017-10-05 (上午）</td>
											<td>8</td>
											<td>4</td>
											<td class="text-red">4</td>
										</tr>
									</tbody>
									<tfooter>
										<tr>
											<th></th>
											<th></th>
											<th class="pull-right">結餘</th>
											<th>32</th>
											<th>24</th>
											<th class="text-red">8</th>
										</tr>
									</tfooter>
								</table>
								<div class="col-md-2 col-md-offset-5">
									<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> 確定送出調整</button>
								</div>
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
