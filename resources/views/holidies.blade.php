@extends('default')

@section('content')
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
	</div>
</section>
@stop
