@extends('default')

@section('content')
<section class="content-header">
  <h1>
    <i class="fa fa-github-alt"></i> 我是代理人
    <small>Agent Leave List</small>
  </h1>
  {{ Breadcrumbs::render('agent') }}
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<form name="frmOrderby" id="frmOrderby" action="{{ route('agent/index') }}" method="POST">
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
												<th width="5%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
												<th width="20%"><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
												<th width="35%"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
												<th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
												<th width="8%"><a href="#sort_days"></a></th>
											</tr>
										</thead>
										{!!csrf_field()!!}
										</form>
									<tbody>
									@foreach ($dataProvider as $value)
										<tr class="clickable-row" data-href="{{ route('agent/leave_detail', [ 'id' => $value->id ]) }}">
											<td>
                      	<img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}" title="{{ $value->fetchUser->nickname }}" alt="{{ $value->fetchUser->nickname }}" class="img-circle"  width="50px">
                    	</td>
											<td>{{ TimeHelper::changeViewTime($value->start_time, $value->end_time, $value->user_id) }}</td>
											<td>{{ $value->reason }}</td>
											<td>{{ $value->hours }}</td>
											<td @if ( LeaveHelper::getDiffDaysLabel($value->start_time) <= 5)class="text-red" @else class="text-black" @endif>
												@if ($value->start_time >= Carbon\Carbon::now()) 倒數{{ LeaveHelper::getDiffDaysLabel($value->start_time) }}天 @endif
                      </td>
										</tr>
									@endforeach
                  @if(count($dataProvider) == 0)
                    <tr class="">
                      <td colspan="7" align="center"><span class="glyphicon glyphicon-search"> 沒有相關結果</span></td>
                    </tr>
                  @endif
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
@stop