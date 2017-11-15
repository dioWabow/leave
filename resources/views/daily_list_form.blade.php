@extends('default')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  @if($model->id > 0)
	<i class="fa fa-briefcase"></i> 修改工作項目
	<small>Edit Sheet</small>
	@else
	<i class="fa fa-briefcase"></i> 新增工作項目
	<small>New Sheet</small>
	@endif
  </h1>
	@if($model->id > 0)
		{{ Breadcrumbs::render('sheet/daily/edit','修改') }}
	@else
  		{{ Breadcrumbs::render('sheet/daily/edit','新增') }}
	@endif
</section>

<!-- Main content -->
<form action="{{ route($model->id > 0 ? 'sheet/daily/update' : 'sheet/daily/insert') }}" method="POST" id="daily_list_form">
{{ csrf_field() }}
  <input type="hidden" id="daily_id" name="daily[id]" class="form-control pull-right" value="{{ $model->id }}">
  <input type="hidden" id="daily_user_id" name="daily[user_id]" class="form-control pull-right" value="{{ Auth::user()->id }}">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				@if($model->id > 0)
				<h3 class="box-title">修改工作項目</h3>&nbsp;&nbsp;
          @if (!TimeHelper::checkEditSheetDate($model->working_day) || $model->user_id != Auth::user()->id)
            <font size="4" color="red"><i class="fa fa-ban fa-2x"></i>&nbsp;僅供顯示</font>
          @endif
				@else
				<h3 class="box-title">新增工作項目</h3>
				@endif
			</div>
			<div class="box-body">
				<div class="form-group {{ $errors->has('daily.working_day') ? 'has-error' : '' }}" id="group_timepicker">
					<div class="row">
						<div class="col-md-1">
							<label>工作日期 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-clock-o"></i>
								</div>
								<input type="text" id="daily_working_day" name="daily[working_day]" value="{{ TimeHelper::getNowDate($model->working_day) }}" class="form-control pull-right single-date" @if(!TimeHelper::checkEditSheetDate($model->working_day) ||  $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>
							</div>
							<span class="text-danger">{{ $errors->first('daily.working_day') }}</span>
						</div>
					</div>
				</div>
				<div class="form-group {{ $errors->has('daily.project_id') ? 'has-error' : '' }}">
					<div class="row">
						<div class="col-md-1">
							<label>專案名稱 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-folder"></i>
							</div>
								<select class="form-control" id="daily_project_id" name="daily[project_id]" @if(!TimeHelper::checkEditSheetDate($model->working_day) ||  $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>
								@foreach( $project as $value)
									@if( $value->fetchProject->available != 0)
										<option value="{{ $value->fetchProject->id }}" @if ($model->project_id == $value->fetchProject->id) selected @endif>{{ $value->fetchProject->name }}</option>
									@endif
								@endforeach
								</select>
							</div>
							<span class="text-danger">{{ $errors->first('daily.project_id') }}</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1 form-group {{ $errors->has('daily.items') ? 'has-feedback has-error' : '' }}">
							<label>標題</label>
						</div>
						<div class="col-md-11 form-group {{ $errors->has('daily.items') ? 'has-feedback has-error' : '' }}">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-file-text-o"></i>
								</div>
                  <input type="text" class="form-control" id="daily_items" name="daily[items]" value="{{ $model->items }}" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>
							</div>
							<span class="text-danger">{{ $errors->first('daily.items') }}</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>內容</label>
						</div>
						<div class="col-md-11">
              <textarea class="form-control" id="daily_description" name="daily[description]" rows="3" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>{{ $model->description }}</textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1 form-group {{ $errors->has('daily.hour') ? 'has-feedback has-error' : '' }}">
							<label>工作時數 <span style="color:red">*</span></label>
						</div>
						<div class="col-md-11 form-group {{ $errors->has('daily.hour') ? 'has-feedback has-error' : '' }}">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-hourglass"></i>
								</div>
									<input type="text" class="form-control daily-hour" id="daily_hour" name="daily[hour]" value="{{ $model->hour }}" placeholder="(單位小時 0.1,0.5,1,2 依此類推)" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>
								<div class="input-group-addon">
									HR
								</div>
							</div>
              <span class="text-danger">{{ $errors->first('daily.hour') }}</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>標籤</label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-tags"></i>
								</div>
									<input type="text" id="daily_tag" name="daily[tag]" value="{{ $model->tag }}" placeholder="測試,未完成,待追蹤" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif></input>
							</div>
						</div>
					</div>
				</div>

				<div class="form-group {{ $errors->has('daily.url') ? 'has-error' : '' }}">
					<div class="row">
						<div class="col-md-1">
							<label>連結</label>
						</div>
						<div class="col-md-11">
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-link"></i>
								</div>
                  <input type="text" value="{{ $model->url }}" id="daily_url" name="daily[url]" class="form-control" placeholder="http://redmine.wabow.com/issues/xxxx" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>
							</div>
							<span class="text-danger">{{ $errors->first('daily.url') }}</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>備註</label>
						</div>
						<div class="col-md-11">
							<textarea class="form-control" id="daily_remark" name="daily[remark]" rows="3" @if(!TimeHelper::checkEditSheetDate($model->working_day) || $model->id > 0 && $model->user_id != Auth::user()->id) disabled="disabled" @endif>{{ $model->remark }}</textarea>
						</div>
					</div>
				</div>
			</form>
      @if ( $model->id > 0 && $model->user_id != Auth::user()->id || !TimeHelper::checkEditSheetDate($model->working_day))
			<div class="box-footer">
				<div class="pull-right">
          <a href="javascript:window.history.go(-1);">
            <button type="button" class="btn btn-primary"><i class="glyphicon glyphicon-repeat"></i> 回到列表</button>
          </a>
				</div>
			</div>
      @else
      <div class="box-footer">
			 @if($model->id > 0)
				<div class="pull-left">
					<a href="{{ route('sheet/daily/delete', [ 'id' => $model->id ]) }}">
						<button type="button" class="btn btn-danger">刪除</button>
					</a>
				</div>
				@endif
				<div class="pull-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-undo"></i> 取消</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
				</div>
			</div>
		</div>
    @endif
	</section>
		<input type="hidden" id="ajax_switch" value="0">
</form>
<!-- /.content -->
@stop
