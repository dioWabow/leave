@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-hand-spock-o"></i> 協助申請請假
	<small>Taken a lot of time off</small>
  </h1>
  {{ Breadcrumbs::render('leave_assist/index') }}
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">請選擇欲請假對象</h3>
			</div>
			<div class="box-body">
				<ul class="mailbox-attachments clearfix">
          @forelse($user_arr as $user)
            @if($user->id!=Auth::user()->id)
    					<li class='clickable-row' data-href="{{ route('leave_assist/create', ['id'=>$user->id]) }}">
    						<span class="mailbox-attachment-icon has-img"><img src="{{UrlHelper::getUserAvatarUrl($user->avatar)}}" class="img-circle" title="{{$user->nickname}}" alt="{{$user->nickname}}"></span>

    						<div class="mailbox-attachment-info">
    							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i>{{$user->nickname}}</a>
    						</div>
    					</li>
            @endif
          @empty
            無資料
          @endforelse
				</ul>
			</div>
		</div>
	</section>
</form>
<!-- /.content -->
@stop