@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 團隊假單
	<small>Teams Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">團隊假單</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="{{Request::is('leaves/hr/prove/*')? 'active' : ''}}"><a href="{{ route('leaves_hr_prove', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('prove') }}<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="{{ LeaveHelper::getHrProveLeavesTotal() }} New Messages">{{ LeaveHelper::getHrProveLeavesTotal() }}</span></a></li>
					<li class="{{Request::is('leaves/hr/upcoming/*') ? 'active' : ''}}" ><a href="{{ route('leaves_hr_upcoming', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('upcoming') }} <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="{{ LeaveHelper::getHrUpComingLeavesTotal() }} New Messages">{{ LeaveHelper::getHrUpComingLeavesTotal() }}</span></a></li>
					<li class="{{Request::is('leaves/hr/history/*') ? 'active' : ''}}" ><a href="{{ route('leaves_hr_history', ['user_id' => Auth::user()->id ]) }}">{{ WebHelper::getLeaveTabLabel('history') }}</a></li>
				</ul>
				<div class="tab-content">
					<!-- /.tab-pane -->
          @if(Request::is('leaves/hr/prove/*'))
						@include('leave_hr_prove')
					@endif
					<!-- /.tab-pane -->
					<!-- /.tab-pane -->
           @if(Request::is('leaves/hr/upcoming/*'))
						@include('leave_hr_upcoming')
					@endif
					<!-- /.tab-pane -->
					<!-- /.tab-pane -->
					@if(Request::is('leaves/hr/history/*'))
						@include('leave_hr_history')
					@endif
					<!-- /.tab-pane -->
				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
</div>
@stop
