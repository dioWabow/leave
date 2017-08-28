
  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{ route('index') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ route('root_path') }}dist/img/wabow_logo.png"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>哇寶</b>請假系統</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications Menu -->
          <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 張假單尚未審核
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="dist/img/dio.png" class="user-image" alt="Dio">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">Dio</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="dist/img/dio.png" class="img-circle" alt="Dio">

                <p>
                  Dio
                  <small>Member since 09 Oct. 2013</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">總特休<br><span class="label label-success">100小時</span></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">可用時數<br><span class="label label-warning">100小時</span></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">待審核<br><span class="label label-danger">100小時</span></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="login.html" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/dio.png" class="img-circle" alt="Dio">
        </div>
        <div class="pull-left info">
          <p>Dio</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="active">
          <a href="{{ route('index') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </li>
        <li class="header">PERSONAL</li>
        <!-- Optionally, you can add icons to the links -->
        <li class=""><a href="{{ route('leave_form2') }}"><i class="fa fa-plane"></i> <span>我要放假</span></a></li>
        <li class="">
          <a href="{{ route('leave') }}"><i class="fa fa-calendar"></i> <span>我的假單</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red" alt="待審核假單">3</small>
            </span>
          </a>
        </li>
        <li class="header">Agent</li>
        <li class="">
          <a href="{{ route('leave_agent_prove') }}">
            <i class="fa fa-user-secret"></i> <span>同意代理嗎？</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
            </span>
          </a>
        </li>
        <li class="">
          <a href="{{ route('leave_agent') }}">
            <i class="fa fa-github-alt"></i> <span>我是代理人</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
            </span>
          </a>
        </li>
        <li class="header">MINI-MANAGER</li>
        <li class="">
          <a href="{{ route('leave_manager') }}"><i class="fa fa-calendar-check-o"></i> <span>團隊假單</span>
                <span class="pull-right-container">
            <small class="label pull-right bg-red">3</small>
          </span>
              </a>
        </li>
        <li class="">
          <a href="{{ route('leave_form33') }}"><i class="fa fa-hand-spock-o"></i> <span>協助申請請假</span>
          </a>
        </li>
        <li class="header">MANAGER</li>
        <li class="">
          <a href="{{ route('leave_manager') }}"><i class="fa  fa-calendar-check-o"></i> <span>團隊假單</span>
                <span class="pull-right-container">
            <small class="label pull-right bg-red">3</small>
          </span>
              </a>
        </li>
        <li class="">
          <a href="{{ route('leave_form33') }}"><i class="fa fa-hand-spock-o"></i> <span>協助申請請假</span>
          </a>
        </li>
        <li class="header">BOSS</li>
        <li class="">
          <a href="{{ route('leave_manager') }}"><i class="fa  fa-calendar-check-o"></i> <span>團隊假單</span>
                <span class="pull-right-container">
            <small class="label pull-right bg-red">1</small>
          </span>
              </a>
        </li>
        <li class="header">HUMAN-RESOURCE</li>
        <li class="">
          <a href="{{ route('leave_hr') }}"><i class="fa fa-calendar-check-o"></i> <span>團隊假單</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">2</small>
            </span>
          </a>
        </li>
        <li class="">
          <a href="{{ route('leave_form33') }}"><i class="fa fa-hand-spock-o"></i> <span>協助申請請假</span>
          </a>
        </li>
        <li class="">
          <a href="{{ route('natural_disaster') }}"><i class="fa fa-cloud"></i> <span>天災假單調整</span></a>
        </li>
      <!--<li class="">
          <a href="paid_sick.html"><i class="fa fa-heartbeat"></i> <span>有新薪病假調整</span></a>
        </li>-->
        <li class="treeview ">
          <a href="#"><i class="fa fa-folder-open-o"></i> <span>基本設定</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ route('system_conf') }}"><i class="fa fa-circle-o"></i>系統設定</a></li>
            <li class=""><a href="{{ route('teams') }}"><i class="fa fa-circle-o"></i>團隊設定</a></li>
            <li class=""><a href="{{ route('users') }}"><i class="fa fa-circle-o"></i>員工管理</a></li>
          </ul>
        </li>
        <li class="treeview ">
          <a href="#"><i class="fa fa-anchor"></i> <span>假期設定</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ route('leave_type') }}"><i class="fa fa-circle-o"></i>假別管理</a></li>
            <li class=""><a href="{{ route('holidies') }}"><i class="fa fa-circle-o"></i>國定假日/補班</a></li>
          </ul>
        </li>
            <li class="treeview ">
          <a href="#"><i class="fa fa-bar-chart"></i> <span>月/年報表</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="{{ route('report') }}"><i class="fa fa-circle-o"></i>報表</a></li>
            <li class=""><a href="{{ route('report-annual-leave') }}"><i class="fa fa-circle-o"></i>特休報表</a></li>
          </ul>
        </li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>