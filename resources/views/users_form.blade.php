@extends('default')

@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1>
	<i class="fa fa-user"></i> 基本資料修改
	<small>Revise Personal Info</small>
  </h1>
  {{ Breadcrumbs::render('user/edit') }}
</section>

<!-- Main content -->
<form action="{{route('user/update')}}" method="POST" enctype="multipart/form-data">
{!!csrf_field()!!}
<input type="hidden" id="user_id" name="user[id]" value="{{$model->id}}">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">{{$model->name}} 基本資料修改</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>角色權限</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="admin" @if ($model->role == "admin") checked="checked" @endif>
							最高管理者
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="hr" @if ($model->role == "hr") checked="checked" @endif> 
							HR
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="user" @if ($model->role == "user") checked="checked" @endif> 
							員工
						</label>&emsp; 
					</div>
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="1" @if ($model->status == "1" && $model->job_seek == 0) checked="checked" @endif>
							在職中
						</label>&emsp; 
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="2" @if ($model->status == "1" && $model->job_seek == 1) checked="checked" @endif>
							將離職
						</label>&emsp; 
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="0" @if ($model->status == "0") checked="checked" @endif>
							已離職
						</label>&emsp;
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1 form-group {{ $errors->has('user.employee_no') ? 'has-error' : '' }}">
						<label>員工編號</label>
					</div>
					<div class="col-md-3 form-group {{ $errors->has('user.employee_no') ? 'has-error' : '' }}">
						<input type="text" id="user_number" name="user[employee_no]" class="form-control pull-right" value="{{$model->employee_no}}">
						<span class="text-danger">{{ $errors->first('user.employee_no') }}</span>
					</div>
					<div class="col-md-1 form-group {{ $errors->has('user.name') ? 'has-error' : '' }}">
						<label>姓名</label>
					</div>
					<div class="col-md-3 form-group {{ $errors->has('user.name') ? 'has-error' : '' }}">
						<input type="text" id="user_name" name="user[name]" class="form-control pull-right" value="{{$model->name}}">
						<span class="text-danger">{{ $errors->first('user.name') }}</span>
					</div>
					<div class="col-md-1 form-group {{ $errors->has('user.nickname') ? 'has-error' : '' }}">
						<label>稱呼</label>
					</div>
					<div class="col-md-3 form-group {{ $errors->has('user.nickname') ? 'has-error' : '' }}">
						<input type="text" id="user_nickname" name="user[nickname]" class="form-control pull-right" value="{{$model->nickname}}">
						<span class="text-danger">{{ $errors->first('user.nickname') }}</span>
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>性別</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" id="user_role" name="user[sex]" class="flat-red" value="1" @if ($model->sex == "1") checked="checked" @endif > 
							男孩
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[sex]" class="flat-red" value="0" @if ($model->sex == "0") checked="checked" @endif> 
							女孩
						</label>&emsp; 
					</div>
					<div class="col-md-1 form-group {{ $errors->has('user.birthday') ? 'has-error' : '' }}">
            <label>生日</label>
          </div>
          <div class="col-md-5 form-group {{ $errors->has('user.birthday') ? 'has-error' : '' }}">
            <input type="text" id="user_birthday" name="user[birthday]" class="form-control pull-right single-date" date="{{$model->birthday}}" value="{{$model->birthday}}">
						<span class="text-danger">{{ $errors->first('user.birthday') }}</span>
          </div>
        </div></div>

        <div class="form-group"><div class="row">
          <div class="col-md-1 form-group {{ $errors->has('user.enter_date') ? 'has-error' : '' }}">
            <label>到職日</label>
          </div>
          <div class="col-md-3 form-group {{ $errors->has('user.enter_date') ? 'has-error' : '' }}">
            <input type="text" id="user_enter_date" name="user[enter_date]" class="form-control pull-right single-date" date="@if($model->enter_date){{date('Y-m-d', strtotime($model->enter_date))}}@endif" value="@if($model->enter_date){{date('Y-m-d', strtotime($model->enter_date))}}@endif">
						<span class="text-danger">{{ $errors->first('user.enter_date') }}</span>
          </div>
          <div class="col-md-1 form-group {{ $errors->has('user.leave_date') ? 'has-error' : '' }}">
            <label>離職日</label>
          </div>
          <div class="col-md-3 form-group {{ $errors->has('user.leave_date') ? 'has-error' : '' }}">
            <div class="input-group">
              <input type="text" id="user_leave_date" name="user[leave_date]" class="form-control pull-right single-date" date="@if($model->leave_date){{date('Y-m-d', strtotime($model->leave_date))}}@endif"  value="@if($model->leave_date){{date('Y-m-d', strtotime($model->leave_date))}}@endif">
							<span class="text-danger">{{ $errors->first('user.leave_date') }}</span>
              <span class="input-group-btn">
                <button id="clear_leave_date" type="button" class="btn btn-secondary btn-danger">x</button>
              </span>
            </div>
          </div>
          <div class="col-md-1 form-group {{ $errors->has('user.arrive_time') ? 'has-error' : '' }}">
						<label>上班時間</label>
					</div>
					<div class="col-md-3 form-group {{ $errors->has('user.arrive_time') ? 'has-error' : '' }}">
						<select class="form-control select2" id="user_work_time" name="user[arrive_time]" data-placeholder="請選擇上班時段">
							<option value="0900" @if($model->arrive_time=="0900")selected="selected"@endif>09:00-18:00</option>
							<option value="0930" @if($model->arrive_time=="0930")selected="selected"@endif>09:30-18:30</option>
						</select>
					</div>
					<span class="text-danger">{{ $errors->first('user.arrive_time') }}</span>
				</div></div>
				
				<div class="form-group" id="group_timepicker"><div class="row">
					<div class="col-md-1">
						<label>代理人</label>
					</div>
					<div class="col-md-5">

						<select class="form-control select2" id="user_agent" name="user[agent][]" multiple="multiple" data-placeholder="請選擇職務代理人">
              @foreach($teams as $team)
              <optgroup label="{{$team->name}}">
                @foreach($team_users as $team_user)
                    @if($team->id==$team_user->team_id)
                      <option value="{{$team_user->user_id}}" @if(in_array($team_user->user_id,$user_agents))selected="selected"@endif>{{$team_user->fetchUser->nickname}}</option>
                    @endif
                @endforeach
              </optgroup>
              @endforeach
              @if(count($user_no_team)>0)
                <optgroup label="NOGROUP">
                  @foreach($user_no_team as $user)
                    <option value="{{$user->id}}" @if(in_array($user->id,$user_agents))selected="selected"@endif>{{$user->nickname}}</option>
                  @endforeach
                </optgroup>
              @endif
						</select>
					</div>
					<div class="col-md-1">
						<label>團隊</label>
					</div>
					<div class="col-md-5">
						<select class="form-control select2" id="user_agent" name="user[team][]" multiple="multiple" data-placeholder="請選擇團隊">
              @foreach($teams as $team)
              <option value="{{$team->id}}" @if(in_array($team->id,$user_teams))selected="selected"@endif>{{$team->name}}</option>
              @endforeach
						</select>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1 form-group {{ $errors->has('user.avatar') ? 'has-error' : '' }}">
						<label>頭像</label>
					</div>
					<div class="col-md-11 form-group {{ $errors->has('user.avatar') ? 'has-error' : '' }}">
						<input id="user_fileupload" name="avatar" class="file-loading" type="file" multiple data-min-file-count="0">
						<span class="text-danger">{{ $errors->first('user.avatar') }}</span>
					</div>
				</div></div>
			</div>
			<div class="box-footer">
				<div class="pull-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-undo"></i> 取消</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
				</div>
			</div>
		</div>
	</section>
</form>
<!-- /.content -->
@stop

