<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>請假系統 DEMO</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
@include('layouts.head_css')

</head>
<body class="hold-transition skin-blue-light sidebar-mini">
<div class="wrapper">
@include('layouts.header')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-check-o"></i> 假單檢視
	<small>View Leave</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li><a href="{{ route('agent_approve/index') }}">同意代理嗎？</a></li>
	<li class="active">假單檢視</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-5">

			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="dist/img/users/dio.png" alt="Dio">
          <h3 class="profile-username text-center">Dio</h3>
          <h3 class="text-center"><span class="label label-default bg-green">待核准</span></h3>
          <br />
					<div id="wizard" class="form_wizard wizard_horizontal">
            <ul class="wizard_steps">
              <li>
                <a href="#step-1" class="disabled">
                  <span class="step_no">
                    <img src="dist/img/users/marty.png" title="Marty" alt="Marty" class="pic_gray">
                  </span>
                  <span class="step_descr disabled">
                      Step 1<br />
                      <small>代理人核准</small>
                  </span>
                </a>
              </li>
              <li>
                <a href="#step-2" class="disabled">
                  <span class="step_no">
                    <img src="dist/img/users/suzy.png" title="Suzy" alt="Suzy" class="pic_gray">
                  </span>
                  <span class="step_descr disabled">
                      Step 2<br />
                      <small>小主管核准</small>
                  </span>
                </a>
              </li>
              <li>
                <a href="#step-3" class="disabled">
                  <span class="step_no">
                    <img src="dist/img/users/default.png" alt="毛毛" title="毛毛" class="pic_gray">
                  </span>
                  <span class="step_descr disabled">
                      Step 3<br />
                      <small>主管核准</small>
                  </span>
                </a>
              </li>
              <li>
                <a href="#step-4" class="disabled">
                  <span class="step_no">
                    <img src="dist/img/users/neo.png" alt="Neo" class="pic_gray">
                  </span>
                  <span class="step_descr disabled">
                      Step 4<br />
                      <small>大ＢＯＳＳ核准</small>
                  </span>
                </a>
              </li>
            </ul>
          </div>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>假別</b> <a class="pull-right">善待假</a>
						</li>
						<li class="list-group-item">
							<b>開始時間</b> <a class="pull-right">2017-07-10 14:00</a>
						</li>
						<li class="list-group-item">
							<b>結束時間</b> <a class="pull-right">2017-07-10 15:00</a>
						</li>
						<li class="list-group-item">
							<b>代理人</b> <a class="pull-right">Marty</a>
						</li>
						<li class="list-group-item">
							<b>原因</b> <a class="pull-right">啊咿嗚誒喔，想去看電影，塞喲娜娜唷</a>
						</li>
						<li class="list-group-item">
							<b>額外通知</b> <a class="pull-right">Neo、毛毛</a>
						</li>
						<li class="list-group-item">
							<b>建立時間</b> <a class="pull-right">2017-07-03 09:00</a>
						</li>
					</ul>
					<div class="form-group" id="group_timepicker"><div class="row">
						<div class="col-md-2">說點話</div>
						<div class="col-md-10">
							<input type="text" id="leave_memo" name="leave[memo]" class="form-control pull-right">
						</div>
					</div></div>
					<div class="form-group" id="group_timepicker"><div class="row">
						<div class="col-md-6">
							<a href="#" class="btn btn-danger btn-block" data-toggle="modal" data-target="#myModalConfirm"><b>同意代理</b></a>
						</div>
						<div class="col-md-6">
							<a href="#" class="btn btn-info btn-block" data-toggle="modal" data-target="#myModalConfirm"><b>不同意代理</b></a>
						</div>
					</div></div>
				</div>
			<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
		<div class="col-md-7">
			<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
				<li><a href="#settings" data-toggle="tab">證明（補）</a></li>
			</ul>
			<div class="tab-content">
				<!-- /.tab-pane -->
				<div class="active tab-pane" id="timeline">
				<!-- The timeline -->
					<ul class="timeline timeline-inverse">
						<!-- timeline time label -->
						<li class="time-label">
							<span class="bg-red">
								待 核 准
							</span>
						</li>
						<!-- /.timeline-label -->
						<!-- timeline item -->
						<li>
							<i class="fa bg-aqua">
								<img class="profile-user-img img-responsive img-circle" src="dist/img/users/dio.png" alt="Dio">
							</i>

							<div class="timeline-item">
								<span class="time"><i class="fa fa-clock-o"></i> 09:00:30</span>

								<h3 class="timeline-header no-border"><a href="#">Dio</a> 提出請假申請
								</h3>
							</div>
						</li>
						<!-- END timeline item -->
						<li class="time-label">
							<span class="bg-green">
								2017-07-03
							</span>
						</li>
						<li>
							<i class="fa fa-clock-o bg-gray"></i>
						</li>
					</ul>
				</div>
				<!-- /.tab-pane -->

				<div class="tab-pane" id="settings">
					<img src="./dist/img/unsplash2.jpg" width="100%">
				</div>
				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

</section>
<!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <h1>確定 <span class="text-red">同意擔任代理人</span> 嗎？</h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2016-2017 <a href="http://www.wabow.com" target="_blank">WABOW</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-file-text-o bg-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">人事規章</h4>

                <p>Rules</p>
              </div>
            </a>
          </li>
		  <li>
            <a href="javascript:;">
              <i class="menu-icon fa fa-wrench bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">異常回報</h4>

                <p>Error Report</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
</body>
</html>
