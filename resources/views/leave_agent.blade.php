@extends('default')

@section('content')
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
@stop
