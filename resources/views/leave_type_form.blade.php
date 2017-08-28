@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 假別資料修改
	<small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li><a href="./users.html">假別管理</a></li>
	<li class="active">資料修改</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">公傷病假 資料修改</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>名稱</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="leave_type_title" name="leave_type[title]" class="form-control pull-right" value="公傷病假">
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>類型</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="leave_type[kind]" class="flat-red" value="normal" checked="checked"> 
							一般
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[kind]" class="flat-red" value="job_seeking"> 
							謀職假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[kind]" class="flat-red" value="scourge"> 
							天災假
						</label>&emsp; 
						<label>
							<input type="radio" id="leave_type_kind" name="leave_type[kind]" class="flat-red" value="paid_sick"> 
							帶薪病假
						</label>&emsp; 
						<label>
							<input type="radio" id="leave_type_kind" name="leave_type[kind]" class="flat-red" value="sick"> 
							病假
						</label>&emsp; 
						<label>
							<input type="radio" id="leave_type_kind" name="leave_type[kind]" class="flat-red" value="treat"> 
							善待假
						</label>&emsp; 
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>重置形式</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="one-time" checked="checked"> 
							一次性
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="aweek"> 
							一星期
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="amonth"> 
							一個月
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="three-month"> 
							三個月
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="ayear"> 
							一年
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="two-year"> 
							兩年
						</label>&emsp; 
						<label>
							<input type="radio" name="leave_type[type]" class="flat-red" value="annual-leave"> 
							特休
						</label>&emsp; 
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>上限（HR)</label>
					</div>
					<div class="col-md-5">
						<input type="text" id="leave_type_hour" name="leave_type[hour]" class="form-control pull-right" value="0">
					</div>
					<div class="col-md-6">
						<label class="text-red">(0 為無上限)</label>
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>理由</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>證明</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" checked="checked">
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="leave_type[status]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
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