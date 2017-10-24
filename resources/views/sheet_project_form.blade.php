@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="glyphicon glyphicon-file"></i> 專案項目修改
    <small>Project Management</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{ route('sheet_project/index') }}">專案項目</a></li>
    <li class="active">專案項目修改</li>
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
						<label>專案</label>
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
							<input type="checkbox" name="sheet_project[team]" class="flat-red" value="all">
							共用
						</label>&emsp; 
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label></label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" id="team_check" name="sheet_project[team]" class="flat-red" value="waca" >
							WACA
						</label>&emsp; 
            <label id="team">
							<button type="button" class="btn btn-success btn-xs">waca 9999</button>
							<button type="button" class="btn btn-success btn-xs">waca 888</button>
						</label>&emsp; 
            <div>
              <div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="waca 999" >
                  waca 999
                </label>&emsp; 
              </div>  
							<div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="waca 888" >
                  waca 888
                </label>&emsp; 
              </div>
            </div>  
					</div>
				</div></div>
				
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label></label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" id="team_check2" name="sheet_project[team]" class="flat-red" value="washop" >
							WASHOP
						</label>&emsp; 
            <label id="team2">
							<button type="button" class="btn btn-warning btn-xs">washop fight</button>
							<button type="button" class="btn btn-warning btn-xs">washop fly</button>
						</label>&emsp; 
            <div>
              <div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="washop fight" >
                  washop fight
                </label>&emsp; 
              </div>  
              <div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="washop fly" >
                  washop fly
                </label>&emsp; 
              </div>
            </div>  
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label></label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" id="team_check3" name="sheet_project[team]" class="flat-red" value="washop" >
							Hr
						</label>&emsp; 
            <label id="team3">
							<button type="button" class="btn btn-success btn-xs">Hr YO</button>
						</label>&emsp; 
            <div>
              <div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="Hr YO" >
                  Hr YO
                </label>&emsp; 
              </div>  
            </div>  
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label></label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" id="team_check4" name="sheet_project[team]" class="flat-red" value="washop" >
              PM
						</label>&emsp; 
            <label id="team4">
							<button type="button" class="btn btn-primary btn-xs">PM QQ</button>
						</label>&emsp; 
            <div>
              <div class="col-md-11">
                <label>
                  <input type="checkbox" name="sheet_project[team]" class="flat-red" value="PM QQ" >
                  PM QQ
                </label>&emsp; 
              </div>  
            </div>  
					</div>
				</div></div>

				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>狀態</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" checked="checked">
						</label>
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