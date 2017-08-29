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
				<form id="form_config_company" action="{{ url('set_config') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="config_company_name" class="col-sm-2 control-label">公司名稱</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="config_company_name" name="config[company_name]" placeholder="Company Name" value="{{ $config->getValue('company_name')[0] }}">
							</div>

							<label for="config_company_sort_name" class="col-sm-2 control-label">簡稱</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="config_company_sort_name" name="config[company_sort_name]" placeholder="Company sort name" value="{{ $config->getValue('company_sort_name')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_website" class="col-sm-2 control-label">網址</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_website" name="config[company_website]" placeholder="Website" value="{{ $config->getValue('company_website')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_logo" class="col-sm-2 control-label">LOGO</label>
							<div class="col-sm-10">
								<input id="config_company_logo" name="config[company_logo]" class="file" type="file" value="{{ $config->getValue('company_logo')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_logo" class="col-sm-2 control-label"></label>
                            @if( $config->getValue('company_logo')[0] != "") 
							<div class="col-sm-10">
								<img src = ".\dist\img\{{ $config->getValue('company_logo')[0] }}">
							</div>
                            @endif
						</div>
						<div class="form-group">
							<label for="config_company_rules" class="col-sm-2 control-label">人事規章</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_rules" name="config[company_rules]" placeholder="URL" value="{{ $config->getValue('company_rules')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_domamin" class="col-sm-2 control-label">異常回報</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_mail" name="config[company_mail]" placeholder="E-MAIL" value="{{ $config->getValue('company_mail')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_company_mail" class="col-sm-2 control-label">網域</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_company_domain" name="config[company_domain]" placeholder="Wabow.com" value="{{ $config->getValue('company_domain')[0] }}">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-info pull-right">送出</button>
					</div>
					<!-- /.box-footer -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</div>

			<div class="box box-success">
				<div class="box-header with-border">
				<h3 class="box-title">SMTP 設定</h3>
				</div>
				<form id="form_config_smtp" action="{{ url('set_config') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
				<div class="box-body">
					<div class="form-group">
					<label for="config_smtp_host" class="col-sm-2 control-label">HOST</label>

					<div class="col-sm-7">
						<input type="email" class="form-control" id="config_smtp_host" name="config[config_smtp_host]" placeholder="ex: smtp.gmail.com" value="{{ $config->getValue('config_smtp_host')[0] }}">
					</div>

					<label for="config_smtp_port" class="col-sm-1 control-label">Port</label>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="config_smtp_port" name="config[smtp_port]" placeholder="465" value="{{ $config->getValue('smtp_port')[0] }}">
					</div>
					</div>
					<div class="form-group">
					<label for="config_smtp_username" class="col-sm-2 control-label">Username</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_username" name="config[smtp_username]" placeholder="ex: test-leave@gmail.com" value="{{ $config->getValue('smtp_username')[0] }}">
					</div>

					<label for="config_smtp_password" class="col-sm-2 control-label">Password</label>

					<div class="col-sm-4">
						<input type="password" class="form-control" id="config_smtp_password" name="config[smtp_password]" placeholder="請輸入密碼" value="{{ $config->getValue('smtp_password')[0] }}">
					</div>
					</div>

					<div class="form-group">
						<label for="config_smtp_auth" class="col-sm-2 control-label">Auth</label>
						<div class="col-sm-10">
							<label>
								<input type="radio" name="config[smtp_auth]" class="flat-red" value="true" @if ( $config->getValue('smtp_auth')[0]  == 'true') checked="checked" @endif >
								是
							</label>&emsp;
							<label>
								<input type="radio" name="config[smtp_auth]" class="flat-red" value="false" @if ( $config->getValue('smtp_auth')[0]  == 'false') checked="checked" @endif>
								否
							</label>&emsp;
						</div>
					</div>

					<div class="form-group">
					<label for="config_smtp_from" class="col-sm-2 control-label">From</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_from" name="config[smtp_from]" placeholder="hello" value="{{ $config->getValue('smtp_from')[0] }}">
					</div>

					<label for="config_smtp_display" class="col-sm-2 control-label">Display</label>

					<div class="col-sm-4">
						<input type="text" class="form-control" id="config_smtp_display" name="config[smtp_display]" placeholder="請假機器" value="{{ $config->getValue('smtp_display')[0] }}">
					</div>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<button type="reset" class="btn btn-default">重置</button>
					<button type="submit" class="btn btn-success pull-right">送出</button>
				</div>
				<!-- /.box-footer -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
			</div>
		</div>
		<div class="col-md-6">


			<div class="box box-warning">
				<div class="box-header with-border">
				<h3 class="box-title">登入設定</h3>
				</div>
				<form id="form_config_google" action="{{ url('set_config') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="form_config_google_login" class="col-sm-3 control-label">Google-自動登入</label>
							<div class="col-sm-9">
								<label>
									<input type="radio" name="config[google_status]" class="flat-red" value="true" @if ($config->getValue('google_status')[0] == 'true' ) checked="checked" @endif>
									是
								</label>&emsp;
								<label>
									<input type="radio" name="config[google_status]" class="flat-red" value="false" @if ($config->getValue('google_status')[0] == 'false' ) checked="checked" @endif>
									否
								</label>&emsp;
							</div>
						</div>
						<div class="form-group">
							<label for="config_google_json" class="col-sm-3 control-label">Google-Key</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="config_google_json" name="config[google_json]" placeholder="Google auto login json" value="{{ $config->getValue('google_json')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_google_json" class="col-sm-3 control-label">Google認證用client_id</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="config_google_client_id" name="config[google_google_client_id]" placeholder="Google client_id" value="{{ $config->getValue('google_client_id')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_google_json" class="col-sm-3 control-label">Google認證用client_secret</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="config_google_json" name="config[google_json]" placeholder="Google client_secret" value="{{ $config->getValue('google_client_secret')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_google_json" class="col-sm-3 control-label">Google認證用回傳網址</label>

							<div class="col-sm-9">
								<input type="text" class="form-control" id="config_google_json" name="config[google_json]" placeholder="Google return url" value="{{ $config->getValue('google_redirect')[0] }}">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-warning pull-right">送出</button>
					</div>
				<!-- /.box-footer -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
          	</div>

			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Slack 設定</h3>
				</div>
				<form id="form_config_slack" action="{{ url('set_config') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="form-group">
							<label for="form_config_slack_status" class="col-sm-2 control-label">啟用</label>
							<div class="col-sm-10">
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="true" @if ($config->getValue('slack_status')[0] == 'true') checked="checked" @endif>
									是
								</label>&emsp;
								<label>
									<input type="radio" name="config[slack_status]" class="flat-red" value="false" @if ($config->getValue('slack_status')[0]  == 'false') checked="checked" @endif>
									否
								</label>&emsp;
							</div>
						</div>
						<div class="form-group">
							<label for="config_slack_token" class="col-sm-2 control-label">Token</label>

							<div class="col-sm-5">
								<input type="email" class="form-control" id="config_slack_token" name="config[slack_token]" placeholder="API Token" value="{{ $config->getValue('slack_token')[0] }}">
							</div>

							<label for="config_slack_public_channel" class="col-sm-2 control-label">廣播頻道</label>
							<div class="col-sm-3">
								<input type="text" class="form-control" id="config_slack_public_channel" name="config[slack_public_channel]" placeholder="指定通知頻道" value="{{ $config->getValue('slack_public_channel')[0] }}">
							</div>
						</div>
						<div class="form-group">
							<label for="config_slack_botname" class="col-sm-2 control-label">BOT代號</label>

							<div class="col-sm-10">
								<input type="text" class="form-control" id="config_slack_botname" name="config[slack_botname]" placeholder="機器人代號" value="{{ $config->getValue('slack_botname')[0] }}">
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="reset" class="btn btn-default">重置</button>
						<button type="submit" class="btn btn-danger pull-right">送出</button>
					</div>
				<!-- /.box-footer -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
				</form>
          	</div>
		</div>
	</div>
<!-- /.content -->
@stop
