@extends('default')

@section('content')
<section class="content-header">
  <h1>
		<i class="fa fa-user-secret"></i> 同意代理嗎？
		<small>Are you sure ?</small>
  </h1>
	<ol class="breadcrumb">
		<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">同意代理嗎？</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
				<form name="frmOrderby" id="frmOrderby" action="{{ route('agent_approve') }}" method="POST">
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
												<th width="3%"><input type="checkbox" id="checkall" name="checkall" class="flat-red" value="all"></th>
												<th width="3%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
												<th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
												<th><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
												<th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
											</tr>
										</thead>
									{!!csrf_field()!!}
									</form>
									<tbody>
										@foreach ($dataProvider as $value)
											<tr class="clickable-row" data-href="leave_agent_view.html">
												<td>
													<input type="checkbox" name="check" class="flat-red check" value="">
												</td>
												<td><img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $value->fetchUser->nickname }}" width="50px"></td>
													<td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
												<td>{{ $value->reason }}</td>
												<td>{{ $value->hours }}</td>
											</tr>
										@endforeach
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
								<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalConfirm">不同意代理</button>
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">同意代理</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>確定 <span class="text-red">不能代理</span> 嗎？</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
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
