@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="glyphicon glyphicon-file"></i> 專案項目{{ $projectModel->id > 0 ? '修改' : '新增' }}
    <small>Project Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('sheet/project/index') }}">專案項目</a></li>
    <li class="active">專案項目{{ $projectModel->id > 0 ? '修改' : '新增' }}</li>
  </ol>
</section>

<!-- Main content -->
<form action="{{ route($projectModel->id > 0 ? 'sheet/project/update' : 'sheet/project/insert') }}" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{$projectModel->name}} 資料{{ $projectModel->id > 0 ? '修改' : '新增' }}</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>專案</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="sheet_project_title" name="sheet_project[title]" class="form-control pull-right" value="{{$projectModel->name}}">
						<input type="hidden" name="sheet_project[id]" value="{{$projectModel->id}}">
					</div>
				</div></div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>團隊</label>
						</div>
						<div class="col-md-11">
							<label>
								<input type="checkbox" name="sheet_project[team][0]" class="flat-red" value="0"@if(in_array(0, $project_team)) checked="checked" @endif> 共用
							</label>
						</div>
						@foreach($main_team as $main_data)
						<div class="col-md-1"></div>
						<div class="col-md-11">
							<label>
								<input type="checkbox" name="sheet_project[team][]" class="flat-red main_team" value="{{$main_data->id}}" @if(in_array($main_data->id, $project_team)) checked="checked" @endif> {{$main_data->name}}
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
											　<input type="checkbox" name="sheet_project[team][]" class="flat-red" value="{{$sub_data->id}}" @if(in_array($sub_data->id, $project_team)) checked="checked" @endif> {{$sub_data->name}}
										</label>
									</div>
								@endif
							@endforeach
						@endforeach
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-1">
							<label>狀態</label>
						</div>
						<div class="col-md-11">
							<label>
								<input type="checkbox" name="sheet_project[available]" class="sheet_project_available" data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($projectModel->available == "1") checked="checked" @endif>
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