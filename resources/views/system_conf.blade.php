@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-briefcase"></i> 系統設定
    <small>System Preferences</small>
  </h1>
  {{ Breadcrumbs::render('config') }}
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">公司資料</h3>
                </div>
                <form id="form_config_company" action="{{ route('config/update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="config_company_name" class="col-sm-2 control-label">公司名稱</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="config_company_name" name="config[company_name]" placeholder="Company Name" value="{{ $config['company_name'] }}">
                            </div>

                            <label for="config_company_short_name" class="col-sm-2 control-label">簡稱</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="config_company_short_name" name="config[company_short_name]" placeholder="Company short name" value="{{ $config['company_short_name'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_company_website" class="col-sm-2 control-label">網址</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="config_company_website" name="config[company_website]" placeholder="Website" value="{{ $config['company_website'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_company_logo" class="col-sm-2 control-label">LOGO</label>
                            <div class="col-sm-10">
                                <input id="config_company_logo" name="company_logo" class="file" type="file" value="{{ $config['company_logo'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_company_logo" class="col-sm-2 control-label"></label>
                        </div>
                        <div class="form-group">
                            <label for="config_company_rules" class="col-sm-2 control-label">人事規章Url</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="config_company_rules" name="config[company_rules]" placeholder="URL" value="{{ $config['company_rules'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_company_domamin" class="col-sm-2 control-label">異常回報Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="config_company_mail" name="config[company_mail]" placeholder="E-MAIL" value="{{ $config['company_mail'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_company_mail" class="col-sm-2 control-label">網域</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="config_company_domain" name="config[company_domain]" placeholder="Wabow.com" value="{{ $config['company_domain'] }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default reset">重置</button>
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
                <form id="form_config_smtp" action="{{ route('config/update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                    <label for="config_smtp_host" class="col-sm-2 control-label">HOST</label>

                    <div class="col-sm-7">
                        <input type="text" class="form-control" id="config_smtp_host" name="config[smtp_host]" placeholder="ex: smtp.gmail.com" value="{{ $config['smtp_host'] }}">
                    </div>

                    <label for="config_smtp_port" class="col-sm-1 control-label">Port</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control" id="config_smtp_port" name="config[smtp_port]" placeholder="465" value="{{ $config['smtp_port'] }}">
                    </div>
                    </div>
                    <div class="form-group">
                    <label for="config_smtp_username" class="col-sm-2 control-label">Username</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="config_smtp_username" name="config[smtp_username]" placeholder="ex: leave" value="{{ $config['smtp_username'] }}">
                    </div>

                    <label for="config_smtp_password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="config_smtp_password" name="config[smtp_password]" placeholder="請輸入密碼" value="{{ $config['smtp_password'] }}">
                    </div>
                    </div>

                    <div class="form-group">
                        <label for="config_smtp_auth" class="col-sm-2 control-label">Auth</label>
                        <div class="col-sm-10">
                            <label>
                                <input type="radio" name="config[smtp_auth]" class="flat-red" value="true" @if ( $config['smtp_auth']  == 'true') checked="checked" @endif checked="checked" >
                                是
                            </label>&emsp;
                            <label>
                                <input type="radio" name="config[smtp_auth]" class="flat-red" value="false" @if ( $config['smtp_auth']  == 'false') checked="checked" @endif>
                                否
                            </label>&emsp;
                        </div>
                    </div>

                    <div class="form-group">
                    <label for="config_smtp_from" class="col-sm-2 control-label">From</label>

                    <div class="col-sm-4">
                        <input type="email" class="form-control" id="config_smtp_from" name="config[smtp_from]" placeholder="hello" value="{{ $config['smtp_from'] }}">
                    </div>

                    <label for="config_smtp_display" class="col-sm-2 control-label">Display</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="config_smtp_display" name="config[smtp_display]" placeholder="請假機器" value="{{ $config['smtp_display'] }}">
                    </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="reset" class="btn btn-default reset">重置</button>
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
                <form id="form_config_google" action="{{ route('config/update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="form_config_google_login" class="col-sm-3 control-label">Google-自動登入</label>
                            <div class="col-sm-9">
                                <label>
                                    <input type="radio" name="config[google_status]" class="flat-red" value="true" @if ( $config['google_status'] == 'true' ) checked="checked" @endif checked="checked">
                                    是
                                </label>&emsp;
                                <label>
                                    <input type="radio" name="config[google_status]" class="flat-red" value="false" @if ( $config['google_status'] == 'false' ) checked="checked" @endif>
                                    否
                                </label>&emsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_google_json" class="col-sm-3 control-label">Google認證用client_id</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="config_google_client_id" name="config[google_client_id]" placeholder="Google client_id" value="{{ $config['google_client_id'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_google_json" class="col-sm-3 control-label">Google認證用client_secret</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="config_google_client_secret" name="config[google_client_secret]" placeholder="Google client_secret" value="{{ $config['google_client_secret'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_google_json" class="col-sm-3 control-label">Google認證用回傳網址</label>

                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="config_google_redirect" name="config[google_redirect]" placeholder="Google return url" value="{{ $config['google_redirect'] }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default reset">重置</button>
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
                <form id="form_config_slack" action="{{ route('config/update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="form_config_slack_status" class="col-sm-2 control-label">啟用</label>
                            <div class="col-sm-10">
                                <label>
                                    <input type="radio" name="config[slack_status]" class="flat-red" value="true" @if ( $config['slack_status'] == 'true') checked="checked" @endif checked="checked">
                                    是
                                </label>&emsp;
                                <label>
                                    <input type="radio" name="config[slack_status]" class="flat-red" value="false" @if ( $config['slack_status']  == 'false') checked="checked" @endif>
                                    否
                                </label>&emsp;
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_slack_token" class="col-sm-2 control-label">Token</label>

                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="config_slack_token" name="config[slack_token]" placeholder="API Token" value="{{ $config['slack_token'] }}">
                            </div>

                            <label for="config_slack_public_channel" class="col-sm-2 control-label">廣播頻道</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" id="config_slack_public_channel" name="config[slack_public_channel]" placeholder="指定通知頻道" value="{{ $config['slack_public_channel'] }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="config_slack_botname" class="col-sm-2 control-label">BOT代號</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="config_slack_botname" name="config[slack_botname]" placeholder="機器人代號" value="{{ $config['slack_botname'] }}">
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default reset">重置</button>
                        <button type="submit" class="btn btn-danger pull-right">送出</button>
                    </div>

                    <!-- /.box-footer -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">其他設定</h3>
                </div>
                <form id="form_config_other" action="{{ route('config/update') }}" class="form-horizontal" method="POST" enctype="multipart/form-data" _lpchecked="1">
                    <div class="box-body">
                        <div class="form-group">
                        <label for="form_config_google_login" class="col-sm-3 control-label">大BOSS天數</label>
                            <div class="col-sm-9">
                            <input type="number" class="form-control" id="config_boss_days" name="config[boss_days]" placeholder="需要大BOSS審核的天數" value="{{ $config['boss_days'] }}">
                            </div>
                        </div>
                        <!--div class="form-group">
                        <label for="config_google_json" class="col-sm-3 control-label">董事天數</label>

                            <div class="col-sm-9">
                            <input type="number" class="form-control" id="config_boss_days" name="config[director_days]" placeholder="需要董事審核的天數" value="{{ $config['director_days'] }}">
                            </div>
                        </div-->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="reset" class="btn btn-default">重置</button>
                        <button type="submit" class="btn btn-default pull-right">送出</button>
                    </div>
                    <!-- /.box-footer -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->

<script>
    $(document).on('change', '#form_config_company', function(event){
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('click', '.file-input', function(event){
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_smtp', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_google', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_slack', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_other', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
    });
    $(".reset").click(function() {
      $(":input").prop("disabled", false);
    });

    var $option = {'showUpload': false};

    @if( $config['company_logo'] != '')
    $option.initialPreview = ['{{ UrlHelper::getCompanyLogoUrl($config['company_logo']) }}'];
    $option.initialPreviewAsData = true;
    @endif

    $("#config_company_logo").fileinput($option);
</script>
@stop
