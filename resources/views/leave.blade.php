@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar"></i> 我的請假單
	<small>My Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{route('root_path')}}/index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">我的請假單</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="{{Request::is('leaves/my/prove/*')? 'active' : ''}}"><a href="{{ route('leaves_my_prove', ['user_id' => 1 ]) }}">等待核准<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="3 New Messages">4</span></a></li>
					<li class="{{Request::is('leaves/my/upcoming/*') ? 'active' : ''}}" ><a href="{{ route('leaves_my_upcoming', ['user_id' => 1 ]) }}">即將放假 <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span></a></li>
					<li class="{{Request::is('leaves/my/history/*') ? 'active' : ''}}" ><a href="{{ route('leaves_my_history', ['user_id' => 1 ]) }}">歷史紀錄</a></li>
				</ul>
				<div class="tab-content">
					@if(Request::is('leaves/my/prove/*'))
						@include('leave_prove')
					@endif
					@if(Request::is('leaves/my/upcoming/*'))
						@include('leave_upcoming')
					@endif
					@if(Request::is('leaves/my/history/*'))
						@include('leave_history')
					@endif
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop