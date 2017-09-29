
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
									<form name="vacationlist" id="vacation_list" action="{{ route('report/vacation')}}" method="GET">
										<input type="hidden" name="year" value="{{$year}}">
										<input type="hidden" name="month" value="{{$month}}">
										<input type="hidden" name="user_id" value="{{$user_id}}">
										<input type="hidden" name="type_id" value="{{$type_id}}">
									</form>
									<thead>
										<tr>
											<th width="4%"><a>請假者</a></th>
											<th><a>時間</a></th>
											<th><a>原因</a></th>
											<th width="8%"><a>時數(HR)</a></th>
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
@stop
