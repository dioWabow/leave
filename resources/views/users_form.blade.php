@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-user"></i> 基本資料修改
	<small>Revise Personal Info</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li><a href="./users.html">員工管理</a></li>
	<li class="active">基本資料修改</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Vic 基本資料修改</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>角色權限</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="super_admin"> 
							最高管理者
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="hr"> 
							HR
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[role]" class="flat-red" value="employee" checked="checked"> 
							員工
						</label>&emsp; 
					</div>
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="" checked="checked">
							在職中
						</label>&emsp; 
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="">
							將離職
						</label>&emsp; 
						<label>
							<input type="radio" name="user[status]" class="flat-red" value="">
							已離職
						</label>&emsp;
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>員工編號</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="user_number" name="user[number]" class="form-control pull-right" value="036">
					</div>
					<div class="col-md-1">
						<label>姓名</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="user_name" name="user[name]" class="form-control pull-right" value="黃冠鳴">
					</div>
					<div class="col-md-1">
						<label>稱呼</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="user_nickname" name="user[nickname]" class="form-control pull-right" value="Vic">
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>性別</label>
					</div>
					<div class="col-md-5">
						<label>
							<input type="radio" id="user_role" name="user[sex]" class="flat-red" value="male"> 
							男孩
						</label>&emsp; 
						<label>
							<input type="radio" id="user_role" name="user[sex]" class="flat-red" value="femal"> 
							女孩
						</label>&emsp; 
					</div>
					<div class="col-md-1">
						<label>生日</label>
					</div>
					<div class="col-md-5">
						<input type="text" id="user_birthday" name="user[birthday]" class="form-control pull-right single-date" date="1982-09-09">
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>到職日</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="user_onboard_date" name="user[onboard_date]" class="form-control pull-right single-date" date="2010-10-09">
					</div>
					<div class="col-md-1">
						<label>離職日</label>
					</div>
					<div class="col-md-3">
						<input type="text" id="user_leave_date" name="user[leave_date]" class="form-control pull-right single-date" date="">
					</div>
					<div class="col-md-1">
						<label>上班時間</label>
					</div>
					<div class="col-md-3">
						<select class="form-control select2" id="user_work_time" name="user[work_time]" data-placeholder="請選擇上班時段">
							<option value="09:00-18:00">09:00-18:00</option>
							<option value="09:30-18:30" selected="selected">09:30-18:30</option>
						</select>
					</div>
				</div></div>
				
				<div class="form-group" id="group_timepicker"><div class="row">
					<div class="col-md-1">
						<label>代理人</label>
					</div>
					<div class="col-md-5">
						<select class="form-control select2" id="user_agent" name="user[agent]" multiple="multiple" data-placeholder="請選擇職務代理人">
							<optgroup label="Wabow">
								<option value="Neo" selected="selected">Neo</option>
							</optgroup>
							<optgroup label="Ｗaca-Team">
								<option value="毛毛">毛毛</option>
								<option value="rita">Rita</option>
								<option value="lube">Lube</option>
								<option value="wei">Wei</option>
								<option value="rock">Rock</option>
							</optgroup>
							<optgroup label="Ｗaca-Engineer-Team">
								<option value="suzy">Suzy</option>
								<option value="rita">Rita</option>
								<option value="sheng">Sheng</option>
								<option value="henry">Henry</option>
							</optgroup>
							<optgroup label="Washop-Team">
								<option value="dio">Dio</option>
								<option value="eno">Eno</option>
								<option value="carol">Carol</option>
							</optgroup>
						</select>
					</div>
					<div class="col-md-1">
						<label>團隊</label>
					</div>
					<div class="col-md-5">
						<select class="form-control select2" id="user_agent" name="user[agent]" multiple="multiple" data-placeholder="請選擇團隊">
							<option value="WACA" selected="selected">WACA</option>
							<option value="WACA-工程">WACA-工程</option>
							<option value="WACA-業務">WACA-業務</option>
							<option value="WASHOP">WASHOP</option>
							<option value="PM">PM</option>
							<option value="SYSTEM" selected="selected">SYSTEM</option>
						</select>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>頭像</label>
					</div>
					<div class="col-md-11">
						<input id="user_fileupload" name="user[fileupload][]" class="file-loading" type="file" multiple data-min-file-count="1">
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