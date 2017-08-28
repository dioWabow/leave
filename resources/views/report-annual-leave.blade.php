@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 特休報表
	<small>Annual Leave Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>報表</li>
	<li class="active">特休報表</li>
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
									<div class="label bg-blue" style="font-size:20px">2017年</div>
									<small class="badge">最後更新：2017-03-04 12:05:09</small>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											年份：
											<select id="setting_year" name="setting[year]" class="form-control">
												<option value="2017" selected="selected">2017 年</option>
												<option value="2016">2016 年</option>
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
											<th><a href="#sort_total">總額度</a></th>
											<th><a href="#sort_used">使用額度</a></th>
											<th><a href="#sort_x">剩餘額度</a></th>
										</tr>
									</thead>
									<tbody>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px">
											</td>
											<td>毛毛</td>
											<td>320</td>
											<td>300</td>
											<td>20</td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px">
											</td>
											<td>Dio</td>
											<td>120</td>
											<td>20</td>
											<td>100</td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px">
											</td>
											<td>Wei</td>
											<td>320</td>
											<td>300</td>
											<td>20</td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="dist/img/users/eno.png" class="img-circle" alt="Eno" width="50px">
											</td>
											<td>Eno</td>
											<td>320</td>
											<td>300</td>
											<td>20</td>
										</tr>
										<tr class='clickable-row' data-href='leave_list.html'>
											<td>
												<img src="dist/img/users/lube.png" class="img-circle" alt="Lube" width="50px">
											</td>
											<td>Lube</td>
											<td>320</td>
											<td>300</td>
											<td>20</td>
										</tr>
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
@stop