@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 國定假日/補班資料修改
	<small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li><a href="./holidies.html">國定假日/補班</a></li>
	<li class="active">資料修改</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">中秋節 資料修改</h3>
			</div>
			<div class="box-body">

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>類型</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="holidies[kind]" class="flat-red" value="holiday" checked="checked"> 
							國定假日
						</label>&emsp; 
						<label>
							<input type="radio" name="holidies[kind]" class="flat-red" value="work-day"> 
							工作日
						</label>&emsp; 
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>名稱</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="holidies_title" name="holidies[title]" class="form-control pull-right" value="中秋節">
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>日期</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="holidies_date" name="holidies[date]" class="form-control pull-right" date="2017-10-04">
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>使用區間</label>
					</div>
					<div class="col-md-11">
						<input type="text" id="holidies_available_date" name="holidies[available_date]" class="form-control pull-right">
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
