@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 團隊假單
	<small>Teams Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">團隊假單</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="{{ Request::is('leaves_manager/prove/*')? 'active' : '' }}"><a href="{{ route('leaves_manager/prove', [ 'role' => $getRole ]) }}">{{ WebHelper::getLeaveTabLabel('prove') }}@if (LeaveHelper::getProveManagerLeavesTabLable($getRole)>0)<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{ LeaveHelper::getProveManagerLeavesTabLable($getRole) }} New Messages">{{ LeaveHelper::getProveManagerLeavesTabLable($getRole) }}</span>@endif</a></li>
					<li class="{{ Request::is('leaves_manager/upcoming/*') ? 'active' : '' }}" ><a href="{{ route('leaves_manager/upcoming', [ 'role' => $getRole ]) }}">{{ WebHelper::getLeaveTabLabel('upcoming') }}@if(LeaveHelper::getUpComingManagerLeavesTotal()>0)<span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="{{ LeaveHelper::getUpComingManagerLeavesTotal() }} New Messages">{{ LeaveHelper::getUpComingManagerLeavesTotal(Auth::user()->id) }}</span>@endif</a></li>
					<li class="{{ Request::is('leaves_manager/history/*') ? 'active' : '' }}" ><a href="{{ route('leaves_manager/history', [ 'role' => $getRole ]) }}">{{ WebHelper::getLeaveTabLabel('history') }}</a></li>
					@if ( in_array($getRole,['manager','minimanager']) )
					<li class="{{ Request::is('leaves_manager/calendar/*') ? 'active' : '' }}">
						<a href="{{ route('leaves_manager/calendar', [ 'role' => $getRole ] ) }}">{{ WebHelper::getLeaveTabLabel('calc') }}
						</a>
					</li>
					@endif
				</ul>
				<div class="tab-content">
					<!-- /.tab-pane-prove -->
					@if(Request::is('leaves_manager/prove/*'))
						@include('leave_manager_prove')
					@endif
					<!-- /.tab-pane -->

					<!-- /.tab-pane-upcoming -->
					@if(Request::is('leaves_manager/upcoming/*'))
						@include('leave_manager_upcoming')
					@endif
					<!-- /.tab-pane -->

					<!-- /.tab-pane-history -->
					@if(Request::is('leaves_manager/history/*'))
						@include('leave_manager_history')
					@endif
					<!-- /.tab-pane -->
					
					<!-- /.tab-pane -->
					@if(Request::is('leaves_manager/calendar/*'))
						@include('leave_manager_calendar')
					@endif
					<!-- /.tab-pane -->

				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop