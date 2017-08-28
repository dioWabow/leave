@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-briefcase"></i> 系統設定
	<small>System Preferences</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li class="active">系統設定</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-6">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">公司資料</h3>
				</div>
				<form id="form_config_company" action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="config_company_name" class="col-sm-2 control-label">公司名稱</label>
							<div class="col-sm-5">
								<input type="email" class="form-control" id="config_company_name" name="config[company_name]" placeholder="Company Name">
							</div>

							<label for="config_company_sort_name" class="col-sm-2 control-label">簡稱</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="config_company_sort_name" name="config[company_sort_name]" placeholder="Company sort name">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_website" class="col-sm-2 control-label">網址</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_website" name="config[company_website]" placeholder="Website">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_logo" class="col-sm-2 control-label">LOGO</label>
							<div class="col-sm-10">
								<input id="config_company_logo" name="config[company_logo][]" class="file" type="file" data-min-file-count="1">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_rules" class="col-sm-2 control-label">人事規章</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_rules" name="config[company_rules]" placeholder="URL">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_mail" class="col-sm-2 control-label">異常回報</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_mail" name="config[company_mail]" placeholder="E-MAIL">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-info pull-right">送出</button>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>

			<div class="box box-success">
				<div class="box-header with-border">
				<h3 class="box-title">SMTP 設定</h3>
				</div>
				<form id="form_config_smtp" action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
				<div class="box-body">
					<div class="form-group">
					<label for="config_smtp_host" class="col-sm-2 control-label">HOST</label>

					<div class="col-sm-7">
						<input type="email" class="form-control" id="config_smtp_host" name="config[config_smtp_host]" placeholder="ex: smtp.gmail.com">
					</div>

					<label for="config_smtp_port" class="col-sm-1 control-label">Port</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="config_smtp_port" name="config[smtp_port]" placeholder="465" value="465">
					</div>
					</div>
					<div class="form-group">
					<label for="config_smtp_username" class="col-sm-2 control-label">Username</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_username" name="config[smtp_username]" placeholder="ex: test-leave@gmail.com">
					</div>
					
					<label for="config_smtp_password" class="col-sm-2 control-label">Password</label>

					<div class="col-sm-4">
						<input type="password" class="form-control" id="config_smtp_password" name="config[smtp_password]" placeholder="請輸入密碼">
					</div>
					</div>

					<div class="form-group">
						<label for="config_smtp_auth" class="col-sm-2 control-label">Auth</label>
						<div class="col-sm-10">
							<label>
								<input type="radio" name="config[smtp_auth]" class="flat-red" value="true"> 
								是
							</label>&emsp; 
							<label>
								<input type="radio" name="config[smtp_auth]" class="flat-red" value="false" checked>
								否
							</label>&emsp; 
						</div>
					</div>

					<div class="form-group">
					<label for="config_smtp_from" class="col-sm-2 control-label">From</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_from" name="config[smtp_from]" placeholder="hello">
					</div>
					
					<label for="config_smtp_display" class="col-sm-2 control-label">Display</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_display" name="config[smtp_display]" placeholder="請假機器">
					</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">重置</button>
					<button type="submit" class="btn btn-success pull-right">送出</button>
				</div>
				<!-- /.box-footer -->
				</form>
			</div>
		</div>
		<div class="col-md-6">


			<div class="box box-warning">
				<div class="box-header with-border">
				<h3 class="box-title">登入設定</h3>
				</div>
				<form id="form_config_google" action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="form_config_google_login" class="col-sm-3 control-label">Google-自動登入</label>
							<div class="col-sm-9">
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="true"> 
									是
								</label>&emsp; 
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="false" checked>
									否
								</label>&emsp; 
							</div>
						</div>
						<div class="form-group">
							<label for="config_google_json" class="col-sm-3 control-label">Google-Key</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="config_google_json" name="config[google_json]" placeholder="Google auto login json">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-warning pull-right">送出</button>
					</div>
				<!-- /.box-footer -->
				</form>
          	</div>

			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Slack 設定</h3>
				</div>
				<form id="form_config_slack" action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="form_config_slack_status" class="col-sm-2 control-label">啟用</label>
							<div class="col-sm-10">
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="true"> 
									是
								</label>&emsp; 
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="false" checked>
									否
								</label>&emsp; 
							</div>
						</div>
						<div class="form-group">
							<label for="config_slack_token" class="col-sm-2 control-label">Token</label>

							<div class="col-sm-5">
								<input type="email" class="form-control" id="config_slack_token" name="config[slack_token]" placeholder="API Token">
							</div>

							<label for="config_slack_public_channel" class="col-sm-2 control-label">廣播頻道</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="config_slack_public_channel" name="config[slack_public_channel]" placeholder="指定通知頻道">
							</div>
						</div>
						<div class="form-group">
							<label for="config_slack_botname" class="col-sm-2 control-label">BOT代號</label>

							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_slack_botname" name="config[slack_botname]" placeholder="機器人代號">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-danger pull-right">送出</button>
					</div>
				<!-- /.box-footer -->
				</form>
          	</div>
		</div>
	</div>
<!-- /.content -->
@stop