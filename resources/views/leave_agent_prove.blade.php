@extends('default')

@section('content')
<section class="content-header">
  <h1>
		<i class="fa fa-user-secret"></i> 同意代理嗎？
		<small>Are you sure ?</small>
  </h1>
  
	{{ Breadcrumbs::render('agent_approve') }}
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
				<form name="frmOrderby" id="frmOrderby" action="{{ route('agent_approve/index') }}" method="POST">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						@if(count($model->order_by)>0)
							<input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
							<input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
						@else
							<input id="order_by" type="hidden" name="order_by[order_by]" value="">
							<input id="order_way" type="hidden" name="order_by[order_way]" value="">
						@endif
						{!!csrf_field()!!}
						</form>
						<form action="{{ route('agent_approve/insert') }}" method="POST">
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="3%"><input type="checkbox" id="checkall" name="checkall" class="flat-red" value="all"></th>
												<th width="8%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
												<th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
												<th width="35%"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
												<th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
											</tr>
										</thead>
									<tbody>
										@foreach ($dataProvider as $value)
											<tr class="clickable-row" data-href="{{ route('agent_approve/leave_detail',[ 'id' => $value->id ]) }}">
												<td>
													<input type="checkbox" name="leave[leave_id][]" id="approve_check" class="flat-red check"  value="{{ $value->id }}">
												</td>
												<td><img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $value->fetchUser->nickname }}" width="50px"></td>
												<td>{{ TimeHelper::changeViewTime($value->start_time, $value->end_time, $value->user_id) }}</td>
												<td>{{ $value->reason }}</td>
												<td>{{ $value->hours }}</td>
											</tr>
										@endforeach
										@if(count($dataProvider) == 0)
											<tr class="">
												<td colspan="9" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
											</tr>
              			@endif
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
									<input type="text" id="leave_reason" name="leave[memo]" class="form-control pull-right" placeholder="請填寫原因(可不填）">
								</div>
								<button type="button" class="btn btn-danger approve_leave" disabled="disabled"  data-toggle="modal" data-target="#myModalConfirm">不同意代理</button>
								<button type="button" class="btn btn-info approve_leave" disabled="disabled" data-toggle="modal" data-target="#myModalConfirm">同意代理</button>
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
			 <!--文字寫變換在head_css內-->
        <h1></h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="btn_agree" name="leave[agree]" value="1">
{!!csrf_field()!!}
</form>
@stop
