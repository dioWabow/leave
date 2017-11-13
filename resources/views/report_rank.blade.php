@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="glyphicon glyphicon-thumbs-down"></i> 缺填日誌
	<small>Missing Sheet Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">缺填日誌</li>
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
									<div class="label bg-blue" style="font-size:20px">10月</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											時間：
											<select id="setting_year" name="setting[year]" class="form-control">
												<option value="2017" selected="selected">2017 年</option>
												<option value="2016">2016 年</option>
												<option value="2016">2015 年</option>
											</select>
										</label>
										<label>
											<select id="setting_month" name="setting[month]" class="form-control">
												<option value="year">整年</option>
                        <option value="1" selected="selected">1月</option>
												<option value="2">2月</option>
												<option value="3">3月</option>
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
											<th width="20%"><a href="#sort_name">姓名</a></th>
											<th width="20%"><a href="#sort_total">缺填次數</a></th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td>
												<img src="./dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px">
											</td>
											<td>毛毛</td>
											<td class="text-red">5</td>
										</tr>
										<tr  >
											<td>
												<img src="./dist/img/users/wabow_logo.png" class="img-circle" alt="Dio" width="50px">
											</td>
											<td>Dio</td>
											<td class="text-red">8</td>
										</tr>
										<tr>
											<td>
												<img src="./dist/img/users/wabow_logo.png" class="img-circle" alt="Wei" width="50px">
											</td>
											<td>Wei</td>
											<td class="text-red">10</td>
										</tr>
									</tbody>
									<tfotter>
                </tr>
				            <tr class="clickable-row" data-href="#">
                      <tr class="">
												<td colspan="3" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
											</tr>
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