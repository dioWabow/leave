<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')

  <script>
$(function () {
    $('#search_daterange').daterangepicker({
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#search_daterange').val('');

    $('#holidies_available_date').daterangepicker({
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#holidies_available_date').val('');

    $('#holidies_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#holidies_date').val($('#holidies_date').attr('date'));
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
	<i class="fa fa-anchor"></i> 國定假日/補班
	<small>Holiday Setting</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li class="active">國定假日/補班</li>
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
							<div class="col-sm-3">
								<div class="dataTables_length">
									<label>
										每頁 
										<select name="search_page" class="form-control input-sm">
											<option value="25">25</option>
											<option value="50">50</option>
											<option value="100">100</option>
										</select> 
									筆</label>
									</div>
								</div>
								<div class="col-sm-9">
									<form name="frmSearch" action="" method="POST">
										<div class="pull-right">
											<label>
												類型：
												<select id="search_type" name="search[type]" class="form-control">
													<option value="">全部</option>
													<option value="holiday">國定假日</option>
													<option value="work-day">工作日</option>
												</select>
											</label>
											&nbsp;
											<label>
												區間：
												<input type="text" id="search_daterange" name="search[daterange]" class="form-control pull-right">
											</label>
											&nbsp;
											<label>
												關鍵字：
												<input type="search" class="form-control" placeholder="請輸入名稱進行查詢" name="search[keywords]" style="width:270px">
												<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
											</label>
										</div>
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="15%"><a href="#sort_type">類型</a></th>
												<th><a href="#sort_name">名稱</a></th>
												<th width="15%"><a href="#sort_date">日期</a></th>
												<th width="15%"><a href="#sort_available_date">可使用區間</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>國定假日</td>
												<td>中秋節</td>
												<td>2017-10-4</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>工作日</td>
												<td>國慶日連續假期補上班日</td>
												<td>2017-09-30</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>國定假日</td>
												<td>國慶日</td>
												<td>2017-10-10</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>國定假日</td>
												<td>國慶日連續假期</td>
												<td>2017-10-9</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>國定假日</td>
												<td>兒童節及民俗掃墓節</td>
												<td>2017-04-04</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											<tr class='clickable-row' data-href='holidies_form.html'>
												<td>工作日</td>
												<td>端午節假期補上班日</td>
												<td>2017-06-03</td>
												<td>-</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<ul class="pagination">
										<li class="paginate_button previous disabled">
											<a href="#">上一頁</a>
										</li>
										<li class="paginate_button active"><a href="#">1</a></li>
										<li class="paginate_button"><a href="#">2</a></li>
										<li class="paginate_button"><a href="#">3</a></li>
										<li class="paginate_button"><a href="#">4</a></li>
										<li class="paginate_button"><a href="#">5</a></li>
										<li class="paginate_button"><a href="#">6</a></li>
										<li class="paginate_button next">
											<a href="#">下一頁</a>
										</li>
									</ul>
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
