@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 2017-10-18
	<small>Work sheet</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">工作日誌</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">

					<li class=""><a href="#">dio</a></li>
					<li class=""><a href="#">tony</a></li>
					<li class="active"><a href="#">eno</a></li>
					<li class=""><a href="#">carrie</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="list">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<form name="frmSetting" action="" method="POST">
								<div class="row">
									<div class="col-sm-6">
										<!--div id="datepicker"></div-->
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
									<table class="table table-bordered table-striped table-hover footable footable-3 breakpoint breakpoint-lg rwd-table" data-toggle-selector=".footable-toggle" data-show-toggle="false" style="display: table;">
										<thead>
											<tr class="footable-header">
												<th class="footable-first-visible">
													<div class="icheckbox_flat-blue checked" aria-checked="true" aria-disabled="false" style="position: relative;"><input id="checkall" type="checkbox" name="checkall" class="flat-red" value="all" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
												</th>
												<th>
													<a href="#sort_status">專案名稱</a>
												</th>
												<th>
													標題
												</th>
												<th data-breakpoints="xs sm">
													內容
												</th>
												<th>
													<a href="#sort_datetime">時數</a>
												</th>
												<th>
													標籤
												</th>
												<th data-breakpoints="xs sm">
													備註
												</th>
											</tr>
										</thead>
										<tbody>
											<tr data-href="{{route('sheet/daily/creat')}}" class="clickable-row">
												<td data-th="複製" class="footable-first-visible">
													<div class="icheckbox_flat-blue checked" aria-checked="true" aria-disabled="false" style="position: relative;"><input type="checkbox" name="check" class="flat-red check" value="" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
												</td>
												<td data-th="專案名稱">
													其他
												</td>
												<td  data-th="標題">
													請假系統轉換 - 轉換說明
												</td>
												<td data-breakpoints="xs sm" data-th="內容">
													僅HTML
												</td>
												<td  data-th="時數">
													0.8 H
												</td>
												<td  data-th="標籤">
													<small class="label" style="background-color:#000000;">wahop</small>
													<small class="label" style="background-color:#000000;">測試</small>
													<small class="label" style="background-color:#000000;">未完成</small>
												</td>
												<td data-breakpoints="xs sm"  data-th="備注">
													還沒完成
												</td>
											</tr>
										</tbody>
									</table>
									<div class="row">
									<div class="col-md-12">
										<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">複製到今日</button>
									</div>
								</div>
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