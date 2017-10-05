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
        <input type="hidden" id="leave_type_id" name="leave_type[id]" class="form-control pull-right" value="{{ $model->id }}">
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
							{{ WebHelper::getTypesExceptionLabel('normal') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="job_seek" @if ($model->exception == 'job_seek') checked="checked" @endif >
							{{ WebHelper::getTypesExceptionLabel('job_seek') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="paid_sick" @if ($model->exception == 'paid_sick') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('paid_sick') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="sick" @if ($model->exception == 'sick') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('sick') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="entertain" @if ($model->exception == 'entertain') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('entertain') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="annual_leave" @if ($model->exception == 'annual_leave') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('annual_leave') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="lone_stay" @if ($model->exception == 'lone_stay') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('lone_stay') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="birthday" @if ($model->exception == 'birthday') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('birthday') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[exception]" class="flat-red" value="natural_disaster" @if ($model->exception == 'natural_disaster') checked="checked" @endif>
							{{ WebHelper::getTypesExceptionLabel('natural_disaster') }}
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
							{{ WebHelper::getTypesResetTimeLabel('none') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="week" @if ($model->reset_time == 'week') checked="checked" @endif>
							{{ WebHelper::getTypesResetTimeLabel('week') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="month" @if ($model->reset_time == 'month') checked="checked" @endif>
							{{ WebHelper::getTypesResetTimeLabel('month') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="season" @if ($model->reset_time == 'season') checked="checked" @endif>
							{{ WebHelper::getTypesResetTimeLabel('season') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="year" @if ($model->reset_time == 'year') checked="checked" @endif>
							{{ WebHelper::getTypesResetTimeLabel('year') }}
						</label>&emsp;
						<label>
							<input type="radio" name="leave_type[reset_time]" class="flat-red" value="other" @if ($model->reset_time == 'other') checked="checked" @endif>
							{{ WebHelper::getTypesResetTimeLabel('other') }}
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
					<input type="text" id="leave_type_available_date" name="leave_type[available_date]" value="@if(!empty($model->start_time)){{$model->start_time}} - {{$model->end_time}}@endif" class="form-control pull-right">
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
</form>
<!-- /.content -->
<script>
//使用區間清空值
$(".btn-danger").click(function() {
    $("#leave_type_available_date").val("");
});
</script>
@stop