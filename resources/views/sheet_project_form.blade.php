@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="glyphicon glyphicon-file"></i> 專案項目{{ $model->id > 0 ? '修改' : '新增' }}
    <small>Project Management</small>
  </h1>
  @if($model->id > 0)
  {{ Breadcrumbs::render('sheet/project/edit','修改') }}
  @else
  {{ Breadcrumbs::render('sheet/project/edit','新增') }}
  @endif
</section>

<!-- Main content -->
<form action="{{ route($model->id > 0 ? 'sheet/project/update' : 'sheet/project/insert') }}" id="sheet_project_form" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{$model->name}} 資料{{ $model->id > 0 ? '修改' : '新增' }}</h3>
			</div>
			<div class="box-body">
				<div class="form-group {{ $errors->has('sheet_project.title') ? 'has-error' : '' }}"><div class="row">
					<div class="col-md-1">
						<label>專案</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="sheet_project_title" name="sheet_project[title]" class="form-control pull-right" value="{{$model->name}}">
						<input type="hidden" name="sheet_project[id]" value="{{$model->id}}">
            <span class="text-danger">{{ $errors->first('sheet_project.title') }}</span>
					</div>
				</div></div>

				<div class="form-group {{ $errors->has('sheet_project.team') ? 'has-error' : '' }}">
					<div class="row">
						<div class="col-md-1">
							<label>團隊</label>
						</div>
						<div class="col-md-11">
							<label>
								<input type="checkbox" name="sheet_project[team][]" class="flat-red sheet_project_team" value="0"@if(in_array(0, $project_team)) checked="checked" @endif> 共用
							</label>
						</div>
						@foreach($main_team as $main_data)
						<div class="col-md-1"></div>
						<div class="col-md-11">
							<label>
								<input type="checkbox"  name="sheet_project[team][]" class="flat-red main_team sheet_project_team" value="{{$main_data->id}}" @if(in_array($main_data->id, $project_team)) checked="checked" @endif> {{$main_data->name}}
							</label>&emsp;
							@foreach($sub_team as $sub_data)
								@if($main_data->id == $sub_data->parent_id)
									<label class="sub_team show_team_{{$main_data->id}}" value="{{$main_data->id}}">
										<small class="label" style="background-color:{{$sub_data->color}};">{{$sub_data->name}}</small>
									</label>
								@endif
							@endforeach
						</div>
              @foreach($sub_team as $sub_data)
                @if($main_data->id == $sub_data->parent_id)
                  <div class="col-md-1"></div>
                    <div class="col-md-11">
                      <label>
                        　<input type="checkbox"  name="sheet_project[team][]" class="flat-red sheet_project_team" value="{{$sub_data->id}}" @if(in_array($sub_data->id, $project_team)) checked="checked" @endif> {{$sub_data->name}}
                      </label>
                    </div>
                  @endif
                @endforeach
						  @endforeach
              <div class="col-md-1"></div>
              <div class="col-md-11">
                <label>
                  <span class="text-danger">{{ $errors->first('sheet_project.team') }}</span>
                </label>
						  </div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>狀態</label>
						</div>
						<div class="col-md-11">
							<label>
								<input type="checkbox" name="sheet_project[available]" class="sheet_project_available" data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($model->available == "1") checked="checked" @endif>
							</label>
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
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		</div>
	</section>
</form>
<!-- /.content -->
@stop