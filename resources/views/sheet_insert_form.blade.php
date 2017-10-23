@extends('default')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  @if( 1 == 1 )
	<i class="fa fa-briefcase"></i> 新增工作項目
	<small>New Sheet</small>
	@else
	<i class="fa fa-briefcase"></i> 修改工作項目
	<small>Edit Sheet</small>
	@endif
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="{{ route('sheet/daily/index') }}">工作日誌</a></li>
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
				<div class="form-group" id="group_timepicker">
					<div class="row">
						<div class="col-md-1">
							<label>工作日期 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" id="leave_timepicker" name="leave[timepicker]" value="{{TimeHelper::getNowDate()}}" class="form-control pull-right">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>專案名稱 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-folder"></i>
							</div>
							<select class="form-control">
								<option>washop</option>
								<option>waca</option>
							</select>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>標題</label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-file-text-o"></i>
								</div>
                  				<input type="text" class="form-control">
							</div>
						</div>
					</div>
				</div>
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
							<label>工作時數 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-5">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-hourglass"></i>
								</div>
                  				<input type="text" class="form-control" placeholder="(單位小時 0.1,0.5,1,2 依此類推)">
								<div class="input-group-addon">
									HR
								</div>
							</div>
						</div>
						<div class="col-md-1">
							<label>標籤</label>
						</div>
						<div class="col-md-5">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-tags"></i>
								</div>
                  				<input type="text" class="form-control" placeholder="測試,未完成,待追蹤">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>連結</label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-link"></i>
								</div>
                  				<input type="text" class="form-control" placeholder="http://redmine.wabow.com/issues/xxxx">
							</div>
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
				<div class="pull-left">
					<button type="submit" class="btn btn-danger">刪除</button>
				</div>
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
