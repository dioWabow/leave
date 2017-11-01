@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="glyphicon glyphicon-list-alt"></i>
  月日誌
  <small>timesheet calendar</small>
  </h1>
  {{ Breadcrumbs::render('sheet/calendar/view') }}
</section>

<!-- Main content -->
<section class="content" id="calendar_content">
  <!-- /.row calendar -->
  <div class="row">
  <!-- /.col -->
  <div class="col-md-12">
    <div class="box box-primary">
    <div class="box-body no-padding">
      <div class="col-xs-12">
      <div class="nav-tabs-custom" style="margin-top: 5px;">
        <ul class="nav nav-tabs">
          <li class="{{$chosed_user_id==Auth::user()->id ? 'active' : ''}} fonts">
              <a href="{{route('sheet/calendar/view')}}">
              <img src="{{UrlHelper::getUserAvatarUrl(Auth::user()->avatar)}}" width="50px"><br><span class="fonts">{{Auth::user()->nickname}}</span></a>
          </li>
          @foreach($timesheetpermissions as $timesheetpermission)
          @if($timesheetpermission->fetchUser->status)
            <li class="fonts {{$chosed_user_id==$timesheetpermission->fetchUser->id ? 'active' : ''}}">
                <a href="{{route('sheet/calendar/view' ,['user_id' => $timesheetpermission->fetchUser->id])}}">
                  <img src="{{UrlHelper::getUserAvatarUrl($timesheetpermission->fetchUser->avatar)}}" width="50px" alt="{{$timesheetpermission->fetchUser->nickname}}"><br>
                  <span class="fonts">
                      {{$timesheetpermission->fetchUser->nickname}}
                  </span>
                </a>
            </li>
          @endif
          @endforeach
        </ul>
      <!-- /.nav-tabs-custom -->
    </div>
      <!-- THE CALENDAR -->
      <div id="calendar"></div>
    </div>
    <!-- /.box-body -->
    </div>
    <!-- /. box -->
  </div>
  <!-- /.col -->
  </div>
  <!-- /.row calendar -->

</section>
<!-- /.content -->
<!-- Index頁面 -->

@stop
