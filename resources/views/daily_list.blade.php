@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 2017-10-18
	<small>Today's work list</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">團隊假單</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">

				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="list">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<form name="frmSetting" action="" method="POST">
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group input-group-sm">
											<input type="text" class="form-control single-date">
											<span class="input-group-btn">
											<button type="button" class="btn btn-primary btn-flat">Go!</button>
											</span>
										</div>
										<button type="submit" class="btn btn-primary">今日</button>
									</div>
									<div class="col-sm-6">
									</div>
								</div>
							</form>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover footable footable-3 breakpoint breakpoint-lg" data-toggle-selector=".footable-toggle" data-show-toggle="false" style="display: table;">
										<thead>
											<tr class="footable-header">
												<th class="footable-first-visible">
													<a href="#sort_status">專案名稱</a>
												</th>
												<th>
													<a href="#sort_name">標題</a>
												</th>
												<th data-breakpoints="xs sm">
													<a href="#sort_leave_type">內容</a>
												</th>
												<th>
													<a href="#sort_datetime">時數</a>
												</th>
												<th>
													<a href="#sort_datetime">TAG</a>
												</th>
												<th data-breakpoints="xs sm">
													<a href="#sort_reason">備註</a>
												</th>
												<th data-breakpoints="xs sm">
													<a href="#sort_agency">修改/刪除</a>
												</th>
											</tr>
										</thead>
										<tbody>
											<tr data-href="{{route('sheet/daily/creat')}}" class="clickable-row">
												<td class="footable-first-visible">
													其他
												</td>
												<td>
													請假系統轉換 - 轉換說明
												</td>
												<td data-breakpoints="xs sm">
													僅HTML
												</td>
												<td>
													0.8 H
												</td>
												<td>
													測試,未完成
												</td>
												<td data-breakpoints="xs sm">
													還沒完成
												</td>
												<td data-breakpoints="xs sm">
													<button type="submit" class="btn btn-primary">修改</button>
													<button type="submit" class="btn btn-danger">刪除</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop