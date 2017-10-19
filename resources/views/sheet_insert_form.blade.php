@extends('default')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  @if( 1 == 1 )
	<i class="fa fa-plane"></i> 新增工作項目
	<small>New Work</small>
	@else
	<i class="fa fa-hand-spock-o"></i> 修改工作項目
	<small>Edit Work</small>
	@endif
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	@if( 1 == 1 )
	<li class="active">新增工作項目</li>
	@else
	<li class="active">修改工作項目</li>
	@endif
  </ol>
</section>

<!-- Main content -->
<form action="{{route('leave/insert')}}" method="POST" enctype="multipart/form-data">
{!!csrf_field()!!}
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				@if( 1 == 1 )
				<h3 class="box-title">新增工作項目</h3>
				@else
				<h3 class="box-title">修改工作項目</h3>
				@endif
			</div>
			<div class="box-body">
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>專案名稱 *</label>
						</div>
						<div class="col-md-11">
							<select class="form-control">
								<option>washop</option>
								<option>waca</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group" id="group_timepicker">
					<div class="row">
						<div class="col-md-1">
							<label>工作日期 *</label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" id="leave_timepicker" name="leave[timepicker]" value="" class="form-control pull-right" date="">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>標題</label>
					</div>
					<div class="col-md-11">
                  		<input type="text" class="form-control">
					</div>
				</div></div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>內容</label>
						</div>
						<div class="col-md-11">
							<textarea class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>工作時數 *</label>
						</div>
						<div class="col-md-11">
							<input type="number" class="form-control" value="0">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>連結</label>
						</div>
						<div class="col-md-11">
							<input class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>TAG</label>
						</div>
						<div class="col-md-11">
							<input class="form-control">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>備註</label>
						</div>
						<div class="col-md-11">
							<textarea class="form-control" rows="3"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<div class="pull-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-undo"></i> 取消</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
				</div>
			</div>
		</div>
	</section>
		<input type="hidden" id="ajax_switch" value="0">
</form>
<!-- /.content -->


@stop
