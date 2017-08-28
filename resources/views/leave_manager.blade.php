@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 團隊假單
	<small>Teams Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">團隊假單</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#prove" data-toggle="tab">等待核准 <span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="3 New Messages">4</span></a></li>
					<li><a href="#upcoming" data-toggle="tab">即將放假 <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span></a></li>
					<li><a href="#list" data-toggle="tab">歷史紀錄</a></li>
				</ul>
				<div class="tab-content">
					<!-- /.tab-pane -->
					<div class="active tab-pane" id="prove">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="3%"><input id="checkall" type="checkbox" name="checkall" class="flat-red" value="all"></th>
												<th width="3%"><a href="#sort_name">請假者</a></th>
												<th><a href="#sort_leave_type">假別</a></th>
												<th><a href="#sort_datetime">時間</a></th>
												<th><a href="#sort_reason">原因</a></th>
												<th width="3%"><a href="#sort_agency">代理人</a></th>
												<th width="8%"><a href="#sort_hours">時數(HR)</a></th>
												<th width="8%"></th>
											</tr>
										</thead>
										<tbody>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<input type="checkbox" name="check" class="flat-red check" value="">
												</td>
												<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
												<td>公假</td>
												<td>2017-08-10 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/marty.png" class="img-circle" alt="Marty" width="50px">
												</td>
												<td>3</td>
												<td class="text-red">倒數1天</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<input type="checkbox" name="check" class="flat-red check" value="">
												</td>
												<td><img src="dist/img/users/rita.png" class="img-circle" alt="Rita" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy" width="50px">
												</td>
												<td>3</td>
												<td>倒數94天</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<input type="checkbox" name="check" class="flat-red check" value="">
												</td>
												<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px">
												</td>
												<td>3</td>
												<td>倒數94天</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<input type="checkbox" name="check" class="flat-red check" value="">
												</td>
												<td><img src="dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													毛毛
												</td>
												<td>3</td>
												<td>倒數94天</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-commenting-o"></i>
										</div>
										<input type="text" id="leave_reason" name="leave[reason]" class="form-control pull-right" placeholder="請填寫原因(可不填）">
									</div>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalConfirm">不允許放假</button>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">允許放假</button>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->

					<!-- /.tab-pane -->
					<div class="tab-pane" id="upcoming">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th width="3%"><a href="#sort_name">請假者</a></th>
									<th><a href="#sort_leave_type">假別</a></th>
									<th><a href="#sort_datetime">時間</a></th>
									<th><a href="#sort_reason">原因</a></th>
									<th width="3%"><a href="#sort_agency">代理人</a></th>
									<th width="8%"><a href="#sort_hours">時數(HR)</a></th>
									<th width="8%"></th>
								</tr>
							</thead>
							<tbody>
								<tr class='clickable-row' data-href='leave_manager_view.html'>
									<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
									<td>公假</td>
									<td>2017-08-10 14:00 ~ 2017-11-11 17:00</td>
									<td>找客戶 - 蔥媽媽</td>
									<td>
										<img src="dist/img/users/marty.png" class="img-circle" alt="Marty" width="50px">
									</td>
									<td>3</td>
									<td class="text-red">倒數1天</td>
								</tr>
								<tr class='clickable-row' data-href='leave_manager_view.html'>
									<td><img src="dist/img/users/rita.png" class="img-circle" alt="Rita" width="50px"></td>
									<td>公假</td>
									<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
									<td>找客戶 - 蔥媽媽</td>
									<td>
										<img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy" width="50px">
									</td>
									<td>3</td>
									<td>倒數94天</td>
								</tr>
								<tr class='clickable-row' data-href='leave_manager_view.html'>
									<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
									<td>公假</td>
									<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
									<td>找客戶 - 蔥媽媽</td>
									<td>
										<img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px">
									</td>
									<td>3</td>
									<td>倒數94天</td>
								</tr>
								<tr class='clickable-row' data-href='leave_manager_view.html'>
									<td><img src="dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px"></td>
									<td>公假</td>
									<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
									<td>找客戶 - 蔥媽媽</td>
									<td>
										毛毛
									</td>
									<td>3</td>
									<td>倒數94天</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- /.tab-pane -->

					<!-- /.tab-pane -->
					<div class="tab-pane" id="list">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<form name="frmSetting" action="" method="POST">
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
										<div class="pull-right">
											<label>
												假別：
												<select id="search_leave_type" name="search[leave_type]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="">特休</option>
													<option value="">事假</option>
													<option value="">病假</option>
													<option value="">生日假</option>
													<option value="">久任假</option>
												</select>
												&nbsp;
												區間：
												<input type="text" id="search_daterange" name="search[daterange]" class="form-control pull-right">
												</label>
												&nbsp;
												<label>
												狀態：
												<select id="search_leave_type" name="search[leave_type]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="">已准假</option>
													<option value="">不准假</option>
												</select>
											</label>
											&nbsp;
											<label>
												<button type="button" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button>
											</label>
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
												<th width="3%"><a href="#sort_status">狀態</a></th>
												<th width="3%"><a href="#sort_name">請假者</a></th>
												<th><a href="#sort_leave_type">假別</a></th>
												<th><a href="#sort_datetime">時間</a></th>
												<th><a href="#sort_reason">原因</a></th>
												<th width="3%"><a href="#sort_agency">代理人</a></th>
												<th width="8%"><a href="#sort_hours">時數(HR)</a></th>
											</tr>
										</thead>
										<tbody>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<button type="button" class="btn bg-navy">已准假</button>
												</td>
												<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/marty.png" class="img-circle" alt="Marty" width="50px">
												</td>
												<td>3</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<button type="button" class="btn bg-navy">已准假</button>
												</td>
												<td><img src="dist/img/users/rita.png" class="img-circle" alt="Rita" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy" width="50px">
												</td>
												<td>3</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<button type="button" class="btn bg-maroon">不准假</button>
												</td>
												<td><img src="dist/img/users/dio.png" class="img-circle" alt="Dio" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													<img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px">
												</td>
												<td>3</td>
											</tr>
											<tr class='clickable-row' data-href='leave_manager_view.html'>
												<td>
													<button type="button" class="btn bg-maroon">不准假</button>
												</td>
												<td><img src="dist/img/users/wei.png" class="img-circle" alt="Wei" width="50px"></td>
												<td>公假</td>
												<td>2017-11-11 14:00 ~ 2017-11-11 17:00</td>
												<td>找客戶 - 蔥媽媽</td>
												<td>
													毛毛
												</td>
												<td>3</td>
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
					<!-- /.tab-pane -->

				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>確定此批假單 <span class="text-red">不允許放假</span> 嗎？</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
@stop