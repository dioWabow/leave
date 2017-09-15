@extends('default')

@section('content')
<section class="content-header">
  <h1>
    <i class="fa fa-github-alt"></i> 我是代理人
    <small>Agent Leave List</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">我是代理人</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<form name="frmOrderby" id="frmOrderby" action="{{ route('leave_agent') }}" method="POST">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							@if(count($model->order_by)>0)
								<input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
								<input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
							@else
								<input id="order_by" type="hidden" name="order_by[order_by]" value="">
								<input id="order_way" type="hidden" name="order_by[order_way]" value="">
							@endif
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="3%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
												<th><a href="javascript:void(0)" class="sort" sortname="hours">時間</a></th>
												<th><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
												<th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
												<th width="8%"><a href="#sort_days"></a></th>
											</tr>
										</thead>
										{!!csrf_field()!!}
										</form>
									<tbody>
									@foreach ($dataProvider as $value)
										<tr class="clickable-row" data-href="leave_agent_finish_view.html">
											<td>
                      	<img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $value->fetchUser->nickname }}" width="50px">
                    	</td>
											<td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
											<td>{{ $value->reason }}</td>
											<td>{{ $value->hours }}</td>
											<td>{{ LeaveHelper::getDiffDaysLabel($value->start_time) }}</td>
										</tr>
									@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
</div>
<script>
$('.sort').on('click', function(){

	var $sortname = $(this).attr('sortname');
	var $order_by = "{{ $model->order_by }}";
	var $order_way = "{{ $model->order_way }}";

	$("#order_by").val($sortname);

	if ($order_by == $sortname && $order_way == "DESC") {
    $("#order_way").val("ASC");
	} else {
    $("#order_way").val("DESC");
	}
  
	$("#frmOrderby").submit();

});

</script>
@stop