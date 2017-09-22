@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-anchor"></i>假別資料@if($model->id > 0)修改@else新增@endif
    <small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>假期設定</li>
    <li><a href="{{ route('leave_type') }}">假別管理</a></li>
    <li class="active">資料修改</li>
  </ol>
</section>

<!-- Main content -->
<form action="{{ route($model->id > 0 ? 'leave_type/update' : 'leave_type/insert') }}" method="POST" enctype="multipart/form-data">
{!!csrf_field()!!}
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{$model->name}} {{ $model->id > 0 ? '修改' : '新增' }}資料</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>名稱</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="leave_type_name" name="leave_type[name]" class="form-control pull-right" value="{{ $model->name }}">
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>類型</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="normal" @if ($model->exception == 'normal') checked="checked" @endif checked="checked">
							一般
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="job_seek" @if ($model->exception == 'job_seek') checked="checked" @endif >
							謀職假
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="paid_sick" @if ($model->exception == 'paid_sick') checked="checked" @endif>
							有薪病假
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="sick" @if ($model->exception == 'sick') checked="checked" @endif>
							無薪病假
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="entertain" @if ($model->exception == 'entertain') checked="checked" @endif>
							善待假
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="annaul_leave" @if ($model->exception == 'annaul_leave') checked="checked" @endif>
							特休
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="lone_stay" @if ($model->exception == 'lone_stay') checked="checked" @endif>
							久任假
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="birthday" @if ($model->exception == 'birthday') checked="checked" @endif>
							生日假
						</label>&emsp;
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>重置形式</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="none" @if ($model->reset_time == 'none') checked="checked" @endif checked="checked">
							不重置
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="week" @if ($model->reset_time == 'week') checked="checked" @endif>
							每週重置
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="month" @if ($model->reset_time == 'month') checked="checked" @endif>
							每月重置
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="season" @if ($model->reset_time == 'season') checked="checked" @endif>
							每季重置
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="year" @if ($model->reset_time == 'year') checked="checked" @endif>
							每年重置
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="other" @if ($model->reset_time == 'other') checked="checked" @endif>
							其他
						</label>&emsp;
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>上限（HR)</label>
					</div>
					<div class="col-md-5">
						<input type="text" id="leave_type_hour" name="leave_type[hours]" class="form-control pull-right" value="{{ $model->hours }}">
					</div>
					<div class="col-md-6">
						<label class="text-red">(0 為無上限)</label>
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>使用區間</label>
					</div>
					<div class="col-md-11">
				<div class="input-group">
					<input type="text" id="leave_type_available_date" name="leave_type[available_date]" class="form-control pull-right">
					<span class="input-group-btn">
						<button id="clear_leave_type_available_date" type="button" class="btn btn-secondary btn-danger">x</button>
					</span>
				</div>
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>扣薪</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[deductions]" class="leave_type_deductions" data-toggle="toggle" data-on="是" data-off="否" @if ($model->deductions == 1) checked="checked" @endif>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>理由</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" @if ( $model->reason == 1) checked="checked" @endif>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>證明</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" @if ( $model->prove == '1') checked="checked" @endif>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[available]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($model->available == 1) checked="checked" @endif>
					</div>

				</div></div>
			</div>
			<div class="box-footer">
				<div class="pull-right">
					<button type="reset" class="btn btn-default" ><i class="fa fa-undo"></i> 取消</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
				</div>
			</div>
		</div>
	</section>
        <input type="hidden" id="leave_type_id" name="leave_type[id]" class="form-control pull-right" value="{{ $model->id }}">
</form>
<!-- /.content -->
<script>
//使用區間清空值
$(".btn-danger").click(function() {
    $("#leave_type_available_date").val("");
});
</script>
@stop