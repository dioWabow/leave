@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
		<i class="fa fa-calendar"></i> 我的請假單
		<small>My Leave List</small>
  </h1>
  <ol class="breadcrumb">
		<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">我的請假單</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="{{Request::is('leaves/my/prove/*')? 'active' : ''}}"><a href="{{ route('leaves/my/prove', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('prove') }}<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{ LeaveHelper::getProveLeavesTotalByUserId(Auth::user()->id) }} New Messages">{{ LeaveHelper::getProveLeavesTotalByUserId(Auth::user()->id) }}</span></a></li>
					<li class="{{Request::is('leaves/my/upcoming/*') ? 'active' : ''}}" ><a href="{{ route('leaves/my/upcoming', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('upcoming') }} <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="{{ LeaveHelper::getUpComingLeavesTotalByUserId(Auth::user()->id) }} New Messages">{{ LeaveHelper::getUpComingLeavesTotalByUserId(Auth::user()->id) }}</span></a></li>
					<li class="{{Request::is('leaves/my/history/*') ? 'active' : ''}}" ><a href="{{ route('leaves/my/history', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('history') }}</a></li>
				</ul>
				<div class="tab-content">
					@if(Request::is('leaves/my/prove/*'))
						@include('leave_my_prove')
					@endif
					@if(Request::is('leaves/my/upcoming/*'))
						@include('leave_my_upcoming')
					@endif
					@if(Request::is('leaves/my/history/*'))
						@include('leave_my_history')
					@endif
				</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop