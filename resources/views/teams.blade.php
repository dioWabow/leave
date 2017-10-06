@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-sitemap"></i> 團隊設定
	<small>Teams Setting</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li class="active">團隊設定</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">團隊清單</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group"><div class="row">

						<div class="col-md-4">
							<form class="form-inline" id="menu-add" action="" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" id="addInputName" placeholder="團隊名稱" required>
								</div>
								<br>
								<div class="form-group">
									<div class="input-group my-colorpicker2">
										<input type="text" class="form-control" id="addInputColor" placeholder="團隊顏色" >
										<div class="input-group-addon">
											<i></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<button class="btn btn-info" type="button" id="addButton">新增</button>
							</form>
							<form class="form-inline" id="menu-editor" style="display: none;" action="" method="POST">
								<h3>修改 "<span id="currentEditName"></span>" 名稱</h3>
								<div class="form-group">
									<input type="text" class="form-control" id="editInputName" placeholder="團隊名稱" required>
								</div>
								<br>
								<div class="form-group">
									<div class="input-group my-colorpicker2">
										<input type="text" class="form-control" id="editInputColor" placeholder="團隊顏色" >
										<div class="input-group-addon">
											<i id="edit_color"></i>
										</div>
									</div>
									<!-- /.input group -->
								</div>
								<button class="btn btn-info" type="button" id="editButton">修改</button>
							</form>
						</div>
						<div class="col-md-8">
							<div class="dd nestable" id="nestable">
								<ol class="dd-list" id="team_set_list">
								@foreach($team_result as $team_data)
                                    @if (empty($team_data->parent_id))
									<li class="dd-item" data-id="{{$team_data->id}}" data-name="{{$team_data->name}}" data-color="{{$team_data->color}}" data-new="0" data-deleted="0">
										<div class="dd-handle">{{$team_data->name}}</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="{{$team_data->id}}">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-color="{{$team_data->color}}" data-owner-id="{{$team_data->id}}">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>
                                            @if ($team_data->has_children)
                                            <ol class="dd-list">
                                                @foreach($team_result as $team_data_children)
                                                @if ($team_data_children->parent_id == $team_data->id)
                                                <li class="dd-item" data-id="{{$team_data_children->id}}" data-name="{{$team_data_children->name}}" data-color="{{$team_data_children->color}}" data-new="0" data-deleted="0">
                                                    <div class="dd-handle">{{$team_data_children->name}}</div>
                                                    <span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="{{$team_data_children->id}}">
                                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                                    </span>
                                                    <span class="button-edit btn btn-default btn-xs pull-right" data-color="{{$team_data_children->color}}" data-owner-id="{{$team_data_children->id}}">
                                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                                    </li>
                                                @endif
                                                @endforeach
                                            </ol>
                                            @endif
									</li>
                                    @endif
								@endforeach
								</ol>
							</div>
						</div>
					</div></div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<form action="{{ route('teams/memberSet')}}" method="POST" name="member_form">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">夥伴設定</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-primary" id="memberReload"><i class="glyphicon glyphicon-repeat"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body" id="member_set">
					@foreach($team_result as $team_data)
						<div class="form-group member_list" id="member_match_manager" team_id="{{$team_data->id}}" team_name="{{$team_data->name}}"><div class="row">
							<div class="col-md-2">
								@if (empty($team_data->parent_id))
									<label>{{$team_data->name}}</label>
								@else
									<label>{{$team_data->parent_name}} / {{$team_data->name}}</label>
								@endif
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2  team_member" name="teams[{{$team_data->id}}][]" multiple="multiple" data-placeholder="請選擇隸屬人員" id="member_{{$team_data->id}}" member_id="{{$team_data->id}}">
								@foreach($user_result as $user_data)
									@if(array_key_exists("$team_data->id", $team_user_list))
										@if(in_array($user_data->id, $team_user_list[$team_data->id]))
											<option value="{{$user_data->id}}" selected="">{{$user_data->nickname}}</option>
										@else
											<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
										@endif
									@else
										<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
									@endif
								@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2 team_manager" name="managers[{{$team_data->id}}][]" data-placeholder="請選擇主管" id="manager_{{$team_data->id}}" manager_id="{{$team_data->id}}">
								@foreach($user_result as $user_data)
									@if(array_key_exists("$team_data->id", $team_manager_list))
										@if(in_array($user_data->id, $team_manager_list[$team_data->id]))
											<option value="{{$user_data->id}}" selected="">{{$user_data->nickname}}</option>
										@else
											<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
										@endif
									@else
										<option value="">請選擇主管</option>
										<option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
									@endif
								@endforeach
								</select>
							</div>
						</div></div>
					@endforeach
					</div>
					<div class="box-footer">
						<div class="pull-right">
							<button type="reset" class="btn btn-default" onclick="history.go();"><i class="fa fa-undo"></i> 取消</button>
							<button type="submit" class="btn btn-primary" id="data_post"><i class="fa fa-send-o"></i> Send</button>
						</div>
					</div>
				</div>
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
			</form>
		</div>
	</div>
</section>
<!-- /.content -->
@stop

