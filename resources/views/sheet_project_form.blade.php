@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-anchor"></i> 專案項目修改
    <small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
    <li>專案設定</li>
    <li><a href="./users.html">專案項目管理</a></li>
    <li class="active">專案修改</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">EFSHOP衣芙日系 資料修改</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>專案名稱</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="sheet_project_title" name="sheet_project[title]" class="form-control pull-right" value="EFSHOP衣芙日系">
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>團隊</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="sheet_project[team]" class="flat-red" value="waca" checked="checked"> 
							WACA
						</label>&emsp; 
						<label>
							<input type="radio" name="sheet_project[team]" class="flat-red" value="washop"> 
							WASHOP
						</label>&emsp; 
						<label>
							<input type="radio" name="sheet_project[team]" class="flat-red" value="hr"> 
							HR
						</label>&emsp; 
						<label>
							<input type="radio" id="sheet_project_team" name="sheet_project[team]" class="flat-red" value="pm"> 
							PM
						</label>&emsp; 
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-11">
						<input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
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