@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 國定假日/補班
	<small>Holiday Setting</small>
  </h1>
  {{ Breadcrumbs::render('holidies') }}
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
								<form name="frmSearch" id="frmSearch" action="{{ route('holidies') }}" method="POST">
										<input id="sort" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
										<input id="sort_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
									<label>
										每頁 
										<select name="order_by[pagesize]" class="form-control input-sm" onchange="javascript:changePageSize(this.value);">
											<option value="25"@if( "{{ $model->pagesize }}" == "{{25}}")selected="selected"@endif>25</option>
											<option value="50"@if( "{{ $model->pagesize }}" == "{{50}}")selected="selected"@endif>50</option>
											<option value="100"@if( "{{ $model->pagesize }}" == "{{100}}")selected="selected"@endif>100</option>
										</select> 
									筆</label>
									</div>
								</div>
									<div class="col-sm-9">
										<div class="pull-right">
											<label>
												類型：
												<select id="search_type" name="search[type]" class="form-control">
													<option value="" @if(count($search)>0 && $search['type']=="")selected="selected"@endif>全部</option>
													<option value="holiday" @if(count($search)>0 && $search['type']=="holiday")selected="selected"@endif>國定假日</option>
													<option value="work" @if(count($search)>0 && $search['type']=="work")selected="selected"@endif>工作日</option>
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
												<input type="search" class="form-control" placeholder="請輸入名稱進行查詢" name="search[name]" style="width:270px" @if(count($search) > 0)value="{{$search['name']}}@endif">
												<!-- 搜尋按鈕 -->
												<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
												<!-- 新增按鈕 -->
												<a href="{{ route('holidies/create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
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
												<th width="15%"><a href="javascript:void(0)" onclick="changeSort('type');">類型</a></th>
												<th><a href="javascript:void(0)" onclick="changeSort('name');">名稱</a></th>
												<th width="15%"><a href="javascript:void(0)" onclick="changeSort('date');">日期</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
											@foreach($dataProvider as $data)
											<tr class='clickable-row' data-href="{{ route('holidies/edit', ['id'=>$data['id']])}}">
												<td>{{$data->type}}</td>
												<td>{{$data->name}}</td>
												<td>{{ Carbon\Carbon::parse($data->date)->format('Y-m-d') }}</td>
												<td>
													<a href="{{ route('holidies/delete', ['id'=>$data['id']])}}"><button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button></a>
												</td>
											</tr>
											@endforeach
											@if(count($dataProvider) == 0)
											<tr class="">
												<td colspan="4" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
											</tr>
											@endif
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

