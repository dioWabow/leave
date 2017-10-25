
@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="glyphicon glyphicon-file"></i> 專案項目
	<small>Project Management</small>
  </h1>
  {{ Breadcrumbs::render('sheet_project/index') }}
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
                    筆
									</label>
                </div>
              </div>
              <div class="col-sm-9">
                <form name="frmSearch" action="" method="POST">
                  <div class="pull-right">
                    <label>
                      團隊：
                      <select id="search_team" name="search[team]" class="form-control">
                        <option value="">全部</option>
                        <option value="waca">WACA</option>
                        <option value="washop">WASHOP</option>
                        <option value="washop">HR</option>
                        <option value="washop">PM</option>
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
                      <input type="search" class="form-control" placeholder="請輸入專案進行查詢" name="search[keywords]" style="width:270px">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>
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
                      <th width="20%">專案</a></th>
                      <th width="20%">團隊</a></th>
                      <th width="4%">狀態</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="clickable-row" data-href="{{ route('sheet_project/edit') }}">
                      <td>EFSHOP衣芙日系</td>
                      <td><small class="label" style="background-color:#FF88C2;">waca</small><small class="label" style="background-color:#7700FF;">waca 999</small></td>
                      <td>
                        <input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
                      </td>
                    </tr>
                    <tr class="clickable-row" data-href="{{ route('sheet_project/edit') }}">
                      <td>EDOLLARS衣大樂是</td>
                      <td><small class="label" style="background-color:#319920;">washop</small></td>
                      <td>
                        <input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
                      </td>
                    </tr>

                    <tr class="clickable-row" data-href="{{ route('sheet_project/edit') }}">
                      <td>TWOEC蔥媽媽</td>
                      <td><small class="label" style="background-color:#319920;">washop</small></td>
                      <td>
                        <input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
                      </td>
                    </tr>
                    <tr class="">
                      <td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
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