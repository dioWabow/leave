
@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 假別管理
	<small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li class="active">假別管理</li>
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
												形式：
												<select id="search_type" name="search[type]" class="form-control">
													<option value="">全部</option>
													<option value="one-time">一次性</option>
													<option value="aweek">一星期</option>
													<option value="amonth">一個月</option>
													<option value="three-month">三個月</option>
													<option value="ayear">一年</option>
													<option value="two-year">兩年</option>
													<option value="annual-leave">特休</option>
												</select>
											</label>
											&nbsp;
											<label>
												類型：
												<select id="search_kind" name="search[kind]" class="form-control">
													<option value="">全部</option>
													<option value="normal">一般</option>
													<option value="job_seeking">謀職假</option>
													<option value="scourge">天災假</option>
													<option value="paid_sick">帶薪病假</option>
													<option value="sick">病假</option>
													<option value="treat">善待假</option>
												</select>
											</label>
											&nbsp;
											<label>
												狀態：
												<select name="search[status]" class="form-control">
													<option value="">全部</option>
													<option value="available" selected="selected">開啟</option>
													<option value="disable">關閉</option>
												</select>
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
												<th><a href="#sort_name">名稱</a></th>
												<th width="15%"><a href="#sort_kind">類型</a></th>
												<th width="15%"><a href="#sort_reset_type">重置形式</a></th>
												<th width="15%"><a href="#sort_hour">上限(HR)</a></th>
												<th width="10%"><a href="#sort_reason">理由</a></th>
												<th width="10%"><a href="#sort_prove">證明</a></th>
												<th width="10%"><a href="#sort_status">狀態</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
											<tr class='clickable-row' data-href='leave_type_form.html'>
												<td>公傷病假</td>
												<td>一般</td>
												<td>一次性</td>
												<td>0</td>
												<td>
													<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[status]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
												</td>
												<td>
													<button type="submit" class="btn btn-danger" disabled="disabled"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>

											<tr class='clickable-row' data-href='leave_type_form.html'>
												<td>喪假</td>
												<td>一般</td>
												<td>一次性</td>
												<td>64</td>
												<td>
													<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[status]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
												</td>
												<td>
													<button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>

											<tr class='clickable-row' data-href='leave_type_form.html'>
												<td>陪產假</td>
												<td>一般</td>
												<td>一次性</td>
												<td>40</td>
												<td>
													<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
												</td>
												<td>
													<input type="checkbox" name="leave_type[status]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
												</td>
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
@stop