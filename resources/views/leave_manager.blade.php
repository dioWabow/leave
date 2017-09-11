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
					<li class="{{Request::is('leaves/manager/prove/*')? 'active' : ''}}"><a href="{{ route('leaves_manager_prove', ['user_id' => 1 ]) }}">{{ WebHelper::getLeaveTabLabel('prove') }}<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="1 New Messages">1</span></a></li>
					<li class="{{Request::is('leaves/manager/upcoming/*') ? 'active' : ''}}" ><a href="{{ route('leaves_manager_upcoming', ['user_id' => 1 ]) }}">{{ WebHelper::getLeaveTabLabel('upcoming') }} <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="1 New Messages">1</span></a></li>
					<li class="{{Request::is('leaves/manager/history/*') ? 'active' : ''}}" ><a href="{{ route('leaves_manager_history', ['user_id' => 1 ]) }}">{{ WebHelper::getLeaveTabLabel('history') }}</a></li>
					<li><a href="#calendar" data-toggle="tab">行事曆（只有小主管＆主管有）</a></li>
				</ul>
				<div class="tab-content">
					<!-- /.tab-pane-prove -->
					@if(Request::is('leaves/manager/prove/*'))
						@include('leave_manager_prove')
					@endif
					<!-- /.tab-pane -->

					<!-- /.tab-pane-upcoming -->
					@if(Request::is('leaves/manager/upcoming/*'))
						@include('leave_manager_upcoming')
					@endif
					<!-- /.tab-pane -->

					<!-- /.tab-pane-history -->
					@if(Request::is('leaves/manager/history/*'))
						@include('leave_manager_history')
					@endif
					<!-- /.tab-pane -->
					
					<!-- /.tab-pane -->
					<div class="tab-pane" id="calendar">
						<div id="calendar"></div>
					</div>
					<!-- /.tab-pane -->

				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>


<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>確定此批假單 <span class="text-red">不允許放假</span> 嗎？</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
@stop