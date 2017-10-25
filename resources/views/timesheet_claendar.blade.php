@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="glyphicon glyphicon-list-alt"></i>
  月日誌
  <small>timesheet calendar</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">月日誌</li>
  </ol>
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
          <li class="active fonts">
              <a href=""><img src="http://leave.ptt.wabow.com/dist/img/users/dio.png" width="50px"><br><span class="fonts">dio</span></a>
          </li>
          @foreach($users as $user)
          <li class="fonts">
              <a href="">
                <img src="{{UrlHelper::getUserAvatarUrl($user->avatar)}}" width="50px" alt="{{$user->name}}"><br>
                <span class="fonts">
                    {{$user->name}}
                </span>
              </a>
          </li>
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
<script>

  $(document).ready(function() {

    var initialLocaleCode = 'zh-tw';

    $('#calendar').fullCalendar({
      height: 800,
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,listMonth'
      },
      buttonText: {
        listMonth: '月列表',
      },
      defaultDate: '2017-10-12',
      locale: initialLocaleCode,
      navLinks: false, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event / 5小時',
          start: '2017-10-01',
          description: 'long description',
        },
        {
          title: 'Long Event',
          start: '2017-10-07',
          end: '2017-10-10'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-10-09'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-10-16'
        },
        {
          title: 'Conference',
          start: '2017-10-11',
          end: '2017-10-13'
        },
        {
          title: 'Meeting',
          start: '2017-10-12',
          end: '2017-10-12'
        },
        {
          title: 'Lunch',
          start: '2017-10-12'
        },
        {
          title: 'Meeting',
          start: '2017-10-12'
        },
        {
          title: 'Happy Hour',
          start: '2017-10-12'
        },
        {
          title: 'Dinner',
          start: '2017-09-12'
        },
        {
          title: 'Birthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday PartyBirthday Party',
          start: '2017-10-13'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-10-28'
        }
      ],
      eventRender: function(event, element) {
        element.prop("title", event.title);
      }
    });
  });

</script>
@stop
