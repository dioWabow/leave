
  <!-- Main Header -->
  <header class="main-header">

    <!-- Logo -->
    <a href="{{ route('index') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{ UrlHelper::getCompanyLogoUrl(ConfigHelper::getConfigValueByKey('company_logo') )}}"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>{{ConfigHelper::getConfigValueByKey('company_short_name')}}</b>請假系統</span>
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
              @if(LeaveHelper::getProveMyLeavesTotalByUserId()>0)<span class="label label-warning">{{ LeaveHelper::getProveMyLeavesTotalByUserId() }}</span>@endif
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have {{ LeaveHelper::getProveMyLeavesTotalByUserId() }} notifications</li>
              @if(LeaveHelper::getProveMyLeavesTotalByUserId()>0)
              <li>
                <!-- Inner Menu: contains the notifications -->
                <ul class="menu">
                  <li><!-- start notification -->
                    <a href="{{ route('leaves_my/prove') }}">
                      <i class="fa fa-users text-aqua"></i> {{ LeaveHelper::getProveMyLeavesTotalByUserId() }} 張假單尚未審核
                    </a>
                  </li>
                  <!-- end notification -->
                </ul>
              </li>
              <li class="footer"><a href="{{ route('leaves_my/prove') }}">View all</a></li>
              @endif
            </ul>
          </li>
          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="{{ UrlHelper::getUserAvatarUrl(Auth::user()->avatar) }}" class="user-image" alt="{{ Auth::user()->nickname }}">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs">{{ Auth::user()->nickname }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- The user image in the menu -->
              <li class="user-header">
                <img src="{{ UrlHelper::getUserAvatarUrl(Auth::user()->avatar) }}" class="img-circle" alt="{{ Auth::user()->nickname }}">

                <p>
                  {{ Auth::user()->nickname }}
                  <small>Member since {{ Carbon\Carbon::parse(Auth::user()->enter_date)->format('d M. Y') }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">總特休<br><span class="label label-success">{{Auth::user()->annual_hours}}小時</span></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">可用時數<br><span class="label label-warning">{{LeaveHelper::calculateRemainAnnualHours()}}小時</span></a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">待審核<br><span class="label label-danger">{{LeaveHelper::calculateAuunalUsedHours()}}小時</span></a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Sign out</a>
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
          <img src="{{ UrlHelper::getUserAvatarUrl(Auth::user()->avatar) }}" class="img-circle" alt="{{ Auth::user()->nickname }}">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->nickname }}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li @if(Request::is('index'))class="active" @endif>
          <a href="{{ route('index') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
        </li>
        <li class="header">TIMESHEET</li>
        <li @if(Request::is('sheet/daily/index'))class="active" @endif>
          <a href="{{ route('sheet/daily/index') }}"><i class="fa fa-calendar-plus-o"></i> <span>日誌</span></a>
        </li>
        <li>
          <a href="{{ route('sheet/calendar/view') }}"><i class="glyphicon glyphicon-list-alt"></i> <span>月日誌</span>
          </a>
        </li>
        <li>
          <a href="{{ route('sheet/search/index') }}"><i class="glyphicon glyphicon-search"></i> <span>搜尋</span>
          </a>
        </li>
        <li>
          <a href="{{ route('absense_report/index') }}"><i class="glyphicon glyphicon-thumbs-down"></i> <span>缺填日誌</span>
          </a>
        </li>
       	<li>
          <a href="{{ route('sheet/project/index') }}"><i class="glyphicon glyphicon-file"></i> <span>專案項目</span>
          </a>
        </li>
	<li>
          <a href="{{ route('sheet/auth/index') }}"><i class="glyphicon glyphicon-eye-open"></i> <span>權限設定</span>
          </a>
        </li>
        <li class="header">PERSONAL</li>
        <!-- Optionally, you can add icons to the links -->
        <li @if(Request::is('leave/*'))class="active" @endif>
          <a href="{{ route('leave/create') }}"><i class="fa fa-plane"></i> <span>我要放假</span></a>
        </li>
        <li @if(Request::is('leaves_my/*')) class="active" @endif>
          <a href="{{ route('leaves_my/prove') }}"><i class="fa fa-calendar"></i> <span>我的假單</span>
            <span class="pull-right-container">
              @if( LeaveHelper::getProveMyLeavesTotalByUserId()>0)<small class="label pull-right bg-red" alt="待審核假單">{{ LeaveHelper::getProveMyLeavesTotalByUserId() }}</small>@endif
            </span>
          </a>
        </li>
        <li @if(Request::is('leave_assist/*'))class="active" @endif>
          <a href="{{ route('leave_assist/getIndex') }}"><i class="fa fa-hand-spock-o"></i> <span>協助申請請假</span>
          </a>
        </li>
        <li class="header">Agent</li>
        <li @if(Request::is('agent_approve/*')) class="active" @endif>
          <a href="{{ route('agent_approve/index') }}">
            <i class="fa fa-user-secret"></i> <span>同意代理嗎？</span>
            <span class="pull-right-container">
              @if(LeaveHelper::getAgentApproveLeavesTotal()>0)<small class="label pull-right bg-red">{{ LeaveHelper::getAgentApproveLeavesTotal() }}</small>@endif
            </span>
          </a>
        </li>
        <li @if(Request::is('agent/*')) class="active" @endif>
          <a href="{{ route('agent/index') }}">
            <i class="fa fa-github-alt"></i> <span>我是代理人</span>
            <span class="pull-right-container">
              @if( LeaveHelper::getAgentLeavesTotal() >0)<small class="label pull-right bg-red">{{ LeaveHelper::getAgentLeavesTotal() }}</small>@endif
            </span>
          </a>
        </li>
        @if( !empty( Auth::hasMiniManagement() ) )
        <li class="header">MINI-MANAGER</li>
        <li @if(Request::is('leaves_manager/*/minimanager')) class="active" @endif>
          <a href="{{ route('leaves_manager/prove', [ 'role' => 'minimanager' ] ) }}"><i class="fa fa-calendar-check-o"></i> <span>團隊假單</span>
            <span class="pull-right-container">
              @if (LeaveHelper::getProveManagerLeavesTabLable('minimanager')>0)<small class="label pull-right bg-red">{{ LeaveHelper::getProveManagerLeavesTabLable('minimanager') }}</small>@endif
            </span>
          </a>
        </li>
        @endif
        @if( !empty(Auth::hasManagement() ) )
        <li class="header">MANAGER</li>
        <li @if(Request::is('leaves_manager/*/manager')) class="active" @endif>
          <a href="{{ route('leaves_manager/prove', [ 'role' => 'manager' ] ) }}"><i class="fa  fa-calendar-check-o"></i> <span>團隊假單</span>
            <span class="pull-right-container">
                @if (LeaveHelper::getProveManagerLeavesTabLable('manager')>0)<small class="label pull-right bg-red">{{ LeaveHelper::getProveManagerLeavesTabLable('manager') }}</small>@endif
            </span>
          </a>
        </li>
        @endif
        @if( Auth::hasAdmin() )
        <li class="header">BOSS</li>
        <li @if(Request::is('leaves_manager/*/admin')) class="active" @endif>
          <a href="{{ route('leaves_manager/prove', [ 'role' => 'admin' ] ) }}"><i class="fa  fa-calendar-check-o"></i> <span>團隊假單</span>
            <span class="pull-right-container">
              @if(LeaveHelper::getProveManagerLeavesTabLable('admin')> 0) <small class="label pull-right bg-red">{{ LeaveHelper::getProveManagerLeavesTabLable('admin') }}</small>@endif
            </span>
          </a>
        </li>
        @endif
        @if( Auth::hasHr() )
        <li class="header">HUMAN-RESOURCE</li>
        <li @if(Request::is('leaves_hr/*')) class="active" @endif>
          <a href="{{ route('leaves_hr/prove') }}"><i class="fa fa-calendar-check-o"></i> <span>團隊假單</span>
            <span class="pull-right-container">
              @if(LeaveHelper::getHrProveLeavesTotal()>0) <small class="label pull-right bg-red">{{ LeaveHelper::getHrProveLeavesTotal() }}</small>@endif
            </span>
          </a>
        </li>
        <li @if(Request::is('natural/*')) class="active" @endif>
          <a href="{{ route('natural/index') }}"><i class="fa fa-cloud"></i> <span>天災假單調整</span></a>
        </li>
        @endif
      <!--<li class="">
          <a href="paid_sick.html"><i class="fa fa-heartbeat"></i> <span>有新薪病假調整</span></a>
        </li>-->
        @if( Auth::hasHr() )
        <li class="treeview @if(Request::is('teams/*', 'user/*','config/*'))active @endif">
          <a href="#"><i class="fa fa-folder-open-o"></i> <span>基本設定</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::is('config/*')) class="active" @endif><a href="{{ route('config/edit') }}"><i class="fa fa-circle-o"></i>系統設定</a></li>
            <li @if(Request::is('teams/*'))class="active" @endif class=""><a href="{{ route('teams/index') }}"><i class="fa fa-circle-o"></i>團隊設定</a></li>
            <li @if(Request::is('user/*'))class="active" @endif><a href="{{ route('user/index') }}"><i class="fa fa-circle-o"></i>員工管理</a></li>
          </ul>
        </li>
        <li class="treeview @if(Request::is('holidies/*', 'leave_type/*'))active @endif">
          <a href="#"><i class="fa fa-anchor"></i> <span>假期設定</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li  @if(Request::is('leave_type/*')) class="active" @endif><a href="{{ route('leave_type') }}"><i class="fa fa-circle-o"></i>假別管理</a></li>
            <li @if(Request::is('holidies/*'))class="active" @endif><a href="{{ route('holidies') }}"><i class="fa fa-circle-o"></i>國定假日/補班</a></li>
          </ul>
        </li>
            <li class="treeview @if(Request::is('report/*','annual_report/*','annual_leave_calculate/*','leaved_user_annual_leave_calculate/*'))active @endif">
          <a href="#"><i class="fa fa-bar-chart"></i> <span>月/年報表</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li  @if(Request::is('report/*')) class="active" @endif><a href="{{ route('report/index') }}"><i class="fa fa-circle-o"></i>報表</a></li>
            <li @if(Request::is('annual_report/*')) class="active" @endif ><a href="{{ route('annual_report/index') }}"><i class="fa fa-circle-o"></i>特休報表</a></li>
            @if( Auth::hasAdmin() )
            <li @if(Request::is('annual_leave_calculate/*')) class="active" @endif><a href="{{route('annual_leave_calculate/index')}}"><i class="fa fa-circle-o"></i>特休結算</a></li>
	          <li @if(Request::is('leaved_user_annual_leave_calculate/*')) class="active" @endif><a href="{{route('leaved_user_annual_leave_calculate/index')}}"><i class="fa fa-circle-o"></i>特休結算(離職)</a></li>
            @endif
          </ul>
        </li>
      </ul>
      @endif
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
