@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 國定假日/補班
	<small>Holiday Setting</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
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
								<form name="frmSearch" id="frmSearch" action="{{ route('holidaySearch') }}" method="POST">
			                    <input id="sort" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
			                    <input id="sort_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
									<label>
					                    每頁 
					                    <select name="order_by[pagesize]" class="form-control input-sm" onchange="javascript:changePageSize(this.value);">
					                      <option value="2"@if( "{{ $model->pagesize }}" == "{{2}}")selected="selected"@endif>2</option>
					                      <option value="5"@if( "{{ $model->pagesize }}" == "{{5}}")selected="selected"@endif>5</option>
					                      <option value="10"@if( "{{ $model->pagesize }}" == "{{10}}")selected="selected"@endif>10</option>
					                    </select> 
					                  筆</label>
									</div>
								</div>
									<div class="col-sm-9">
										<div class="pull-right">
											<label>
												類型：
												<select id="search_type" name="search[type]" class="form-control">
													<option value="" @if(count($where)>0 && $where['type']=="")selected="selected"@endif>全部</option>
													<option value="holiday" @if(count($where)>0 && $where['type']=="holiday")selected="selected"@endif>國定假日</option>
													<option value="work" @if(count($where)>0 && $where['type']=="work")selected="selected"@endif>工作日</option>
												</select>
											</label>
											&nbsp;
											<label>
												區間：
												<input type="text" id="search_daterange" name="search[daterange]" class="form-control pull-right" @if(count($where) > 0)value="{{$where['daterange']}}@endif">
											</label>
											&nbsp;
											<label>
												關鍵字：
												<input type="search" class="form-control" placeholder="請輸入名稱進行查詢" name="search[name]" style="width:270px" @if(count($where) > 0)value="{{$where['name']}}@endif">
												<!-- 搜尋按鈕 -->
												<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
												<!-- 新增按鈕 -->
												<a href="{{ route('holidiesInsertForm') }}"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
											</label>
										</div>
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="15%"><a onclick="changeSort('type');">類型</a></th>
												<th><a onclick="changeSort('name');">名稱</a></th>
												<th width="15%"><a onclick="changeSort('date');">日期</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
											@foreach($dataProvider as $data)
											<tr class='clickable-row' data-href="{{ route('holidiesUpdateForm', ['id'=>$data['id']])}}">
												<td>{{$data->type}}</td>
												<td>{{$data->name}}</td>
												<td>{{$data->date}}</td>
												<td>
													<a href="{{ route('holidayDelete', ['id'=>$data['id']])}}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>
												</td>
											</tr>
											@endforeach
										</tbody>

									</table>
								</div>
							</div>
							{!! $dataProvider->render() !!}
						</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</section>
<script>
function changePageSize(pagesize){
  $("#frmSearch").submit();
}

function changeSort(sort){
  order_by = $('#sort').val();
  order_way = $('#sort_way').val();
  $('#sort').val(sort);
  if (order_by == sort && order_way == "DESC") {
      $('#sort_way').val("ASC");
  } else {
    $('#sort_way').val("DESC");
  }
  $("#frmSearch").submit();
}
</script>
@stop

