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
	<i class="fa fa-hand-spock-o"></i> 協助申請請假
	<small>Taken a lot of time off</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">協助申請請假</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">請選擇欲請假對象</h3>
			</div>
			<div class="box-body">
				<ul class="mailbox-attachments clearfix">
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/neo.png" class="img-circle" alt="Neo"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Neo</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/default.png" class="img-circle" alt="毛毛"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> 毛毛</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Suzy</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/rita.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Rita</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/sheng.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Sheng</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/henry.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Henry</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/default.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Stephanie</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/wei.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Wei</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/rock.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Rock</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/jerry.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Jerry</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
</form>
<!-- /.content -->
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
