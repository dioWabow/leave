@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-users"></i> 員工管理
	<small>Staff Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li class="active">員工管理</li>
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
												團隊：
												<select id="search_teams" name="search[teams]" class="form-control">
													<option value="">全部</option>
													<option value="waca" selected="selected">WACA</option>
													<option value="washop">WASHOP</option>
													<option value="system">SYSTEM</option>
													<option value="pm">PM</option>
												</select>
											</label>
											&nbsp;
											<label>
												狀態：
												<select name="search[status]" class="form-control">
													<option value="">全部員工</option>
													<option value="on_duty" selected="selected">在職員工</option>
													<option value="resigned">離職員工</option>
												</select>
											</label>
											&nbsp;
											<label>
												關鍵字：
												<input type="search" class="form-control" placeholder="請輸入員編、英文名、中文名進行查詢" name="search[keywords]" style="width:270px">
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
												<th width="3%"></th>
												<th width="5%"><a href="#sort_employee_no">編號</a></th>
												<th><a href="#sort_english_name">稱呼</a></th>
												<th><a href="#sort_name">姓名</a></th>
												<th width="8%"><a href="#sort_birthday">生日</a></th>
												<th width="8%"><a href="#sort_on_board_date">到職日</a></th>
												<th width="8%"><a href="#sort_leave_date">離職日</a></th>
												<th width="8%"><a href="#sort_work_time">上班時間</a></th>
												<th width="11%"><a href="#sort_job_agent">職代</a></th>
												<th width="10%"><a href="#sort_teams">團隊</a></th>
												<th width="4%"><a href="#sort_status">狀態</a></th>
											</tr>
										</thead>
										<tbody>
											<tr class='clickable-row' data-href='users_form.html'>
												<td align="center"><img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px"></td>
												<td align="center">
													<div>001</div>
													<div><small class="label bg-red">最高管理者</small></div>
												</td>
												<td>Neo</td>
												<td>李辰德</td>
												<td>1982-00-00</td>
												<td>2010-10-09</td>
												<td>-</td>
												<td>09:30 - 18:30</td>
												<td>-</td>
												<td>
													<small class="label bg-purple">PM</small>
													<small class="label bg-gray">HR</small>
												</td>
												<td align="center"><small class="badge bg-green" title="在職中">ON</small></td>
											</tr>
											<tr class='clickable-row' data-href='users_form.html'>
												<td align="center"><img src="dist/img/wabow_logo.png" class="img-circle" alt="毛毛" width="50px"></td>
												<td align="center">
													<div>035</div>
													<div><small class="label bg-blue">員工</small></div>
												</td>
												<td>毛毛</td>
												<td>張文馨</td>
												<td>1982-00-00</td>
												<td>2010-10-09</td>
												<td>-</td>
												<td>09:30 - 18:30</td>
												<td>
													<img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy" width="50px">
												</td>
												<td>
													<small class="label bg-yellow">WACA</small>
												</td>
												<td align="center"><small class="badge bg-green" title="在職中">ON</small></td>
											</tr>
											<tr class='clickable-row' data-href='users_form.html'>
												<td align="center"><img src="dist/img/dio.png" class="img-circle" alt="Dio" width="50px"></td>
												<td align="center">
													<div>032</div>
													<div><small class="label bg-red">最高管理者</small></div>
												</td>
												<td>Dio</td>
												<td>許瀚之</td>
												<td>1982-02-09</td>
												<td>2010-10-09</td>
												<td>-</td>
												<td>09:30 - 18:30</td>
												<td>
													<img src="dist/img/users/marty.png" class="img-circle" alt="Marty" width="50px">
													<img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px">
												</td>
												<td>
													<small class="label bg-blue">WASHOP</small>
													<small class="label bg-purple">PM</small>
												</td>
												<td align="center"><small class="badge bg-dark" title="已離職">OFF</small></td>
											</tr>
											<tr class='clickable-row' data-href='users_form.html'>
												<td align="center"><img src="dist/img/users/carol.png" class="img-circle" alt="Carol" width="50px">
												</td>
												<td align="center">
													<div>045</div>
													<div><small class="label bg-blue">員工</small></div>
												</td>
												<td>Carol</td>
												<td>王淑燕</td>
												<td>1980-00-00</td>
												<td>2010-10-09</td>
												<td>-</td>
												<td>09:30 - 18:30</td>
												<td>
													<img src="dist/img/users/eno.png" class="img-circle" alt="Eno" width="50px">
													<img src="dist/img/users/tony.png" class="img-circle" alt="Tony" width="50px">
												</td>
												<td>
													<small class="label bg-blue">WASHOP</small>
												</td>
												<td align="center"><small class="badge bg-green" title="在職中">ON</small></td>
											</tr>

											<tr class='clickable-row' data-href='users_form.html'>
												<td align="center"><img src="dist/img/users/vic.png" class="img-circle" alt="Vic" width="50px">
												</td>
												<td align="center">
													<div>036</div>
													<div><small class="label bg-blue">員工</small></div>
												</td>
												<td>Vic</td>
												<td>黃冠鳴</td>
												<td>1980-00-00</td>
												<td>2010-10-09</td>
												<td>-</td>
												<td>09:30 - 18:30</td>
												<td>
													<img src="dist/img/users/neo.png" class="img-circle" alt="Neo" width="50px">
												</td>
												<td>
													<small class="label bg-yellow">WACA</small>
													<small class="label bg-green">SYSTEM</small>
												</td>
												<td align="center"><small class="badge bg-green" title="在職中">ON</small></td>
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