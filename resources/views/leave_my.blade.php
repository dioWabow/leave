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
					<li class="{{Request::is('leaves/my/prove')? 'active' : ''}}"><a href="{{ route('leaves/my/prove') }}">{{ WebHelper::getLeaveTabLabel('prove') }} @if( LeaveHelper::getProveMyLeavesTotalByUserId()>0)<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{ LeaveHelper::getProveMyLeavesTotalByUserId() }} New Messages">{{ LeaveHelper::getProveMyLeavesTotalByUserId() }}</span>@endif</a></li>
					<li class="{{Request::is('leaves/my/upcoming') ? 'active' : ''}}" ><a href="{{ route('leaves/my/upcoming') }}">{{ WebHelper::getLeaveTabLabel('upcoming') }}@if(LeaveHelper::getUpComingMyLeavesTotalByUserId()>0) <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="{{ LeaveHelper::getUpComingMyLeavesTotalByUserId() }} New Messages">{{ LeaveHelper::getUpComingMyLeavesTotalByUserId() }}</span>@endif</a></li>
					<li class="{{Request::is('leaves/my/history') ? 'active' : ''}}" ><a href="{{ route('leaves/my/history') }}">{{ WebHelper::getLeaveTabLabel('history') }}</a></li>
				</ul>
				<div class="tab-content">
					@if(Request::is('leaves/my/prove'))
						@include('leave_my_prove')
					@endif
					@if(Request::is('leaves/my/upcoming'))
						@include('leave_my_upcoming')
					@endif
					@if(Request::is('leaves/my/history'))
						@include('leave_my_history')
					@endif
				</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop