@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-github-alt"></i> 缺填次數列表
  <small>Report Missing Sheet List</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('rank_report/index') }}">缺填次數報表</a></li>
  <li class="active">缺填工作日誌列表</li>
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
                    	<th width="5%"><a href="#sort_name">缺填者</a></th>
											<th width="15%"><a href="#sort_total">缺填日期</a></th>
											<th width="3%"></th>
										</tr>
									</thead>
									<tbody>
										<tr class="clickable-row" data-href="">
                      <td>
                        <img src="dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px">
                      </td>
                      <td>2017-10-16</td>
                      <td></td>
										</tr>
										<tr class="clickable-row" data-href="">
                      <td>
												<img src="dist/img/users/dio.png" class="img-circle" alt="毛毛" width="50px">
											</td>
                      <td>2017-01-28</td>
											<td></td>
										</tr>
										<tr class='clickable-row' data-href="">
                      <td>
												<img src="dist/img/users/dio.png" class="img-circle" alt="毛毛" width="50px">
											</td>
                      <td>2017-02-02</td>
											<td></td>
										</tr>
									</tbody>
									<tfotter>
										<tr class="text-red">
											<th></th>
											<th class="pull-right">總計(次數)</th>
											<td>3</td>
										</tr>
                    <tr class="clickable-row" data-href="#">
                      <td colspan="3" align="center">
                        無資料
                      </td>
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
<!-- /.content -->
@stop