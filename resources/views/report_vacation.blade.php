
@extends('default')

@section('content')
  <style>
    th {cursor: pointer;}
  </style>
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-github-alt"></i> {{$all_type[$type_id]->name}}列表
	<small>Report Vacation List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="{{ route('report/index') }}">報表</a></li>
	<li class="active">{{$all_type[$type_id]->name}}列表</li>
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
									<form name="vacationlist" id="vacation_list" action="{{  route('report/vacation' ,['year' => $year, 'month' => $month, 'user_id' => $user_id, 'type_id' => $type_id])}}" method="GET">
										<input id="sort" type="hidden" name="order_by" @if(count($order_by) > 0)value="{{$order_by}}"@endif>
			                    		<input id="sort_way" type="hidden" name="order_way" @if(count($order_way) > 0)value="{{$order_way}}"@endif>
									</form>
									<thead>
										<tr>
											<th width="4%">請假者</th>
											<th><a href="javascript:void(0)" onclick="changeSort('start_time');">時間</a></th>
											<th>原因</th>
											<th width="8%"><a href="javascript:void(0)" onclick="changeSort('hours');">時數(HR)</a></th>
										</tr>
									</thead>
									<tbody>
                    @forelse($user_vacation_list as $list_data)
										<tr class="clickable-row" data-href="{{ route('leave/edit', [ 'id' => $list_data->id ]) }}">
											<td><img src="{{UrlHelper::getUserAvatarUrl($list_data->fetchUser->avatar)}}" class="img-circle" alt="{{$list_data->fetchUser->nickname}}" width="50px"></td>
											<td> {{ TimeHelper::changeViewTime($list_data->start_time, $list_data->end_time, $list_data->user_id) }}</td>
											<td>{{$list_data->reason}}</td>
											<td>{{$list_data->hours}}</td>
										</tr>
                    @empty
											<tr class="">
												<td colspan="4" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
											</tr>
										@endforelse
									</tbody>
								</table>
								{!! $user_vacation_list->appends(\Request::except('page'))->render() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script>

function changeSort(sort){
  order_by = $('#sort').val();
  order_way = $('#sort_way').val();
  $('#sort').val(sort);
  if (order_by == sort && order_way == "ASC") {
      $('#sort_way').val("DESC");
  } else {
    $('#sort_way').val("ASC");
  }
  $("#vacation_list").submit();
}

</script>
@stop
