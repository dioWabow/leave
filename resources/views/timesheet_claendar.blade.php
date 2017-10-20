@extends('default')

@section('content')
<style type="text/css">

  .fonts {
    display: block;
    text-align: center;
    font-weight:bold;
    font-size: 16px;
  }

  .popover {
    z-index: 1010; /* A value higher than 1010 that solves the problem */
  }

  .fc-title{
    font-size: 14px;
  }

</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  月報表
  <small>timesheet calendar</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">月報表</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- /.row calendar -->
  <div class="row">
  <!-- /.col -->
  <div class="col-md-12">
    <div class="box box-primary">
    <div class="box-body no-padding">
      <ul class="nav nav-tabs">
        <li class="active fonts"><a href=""><img src="http://leave.ptt.wabow.com/dist/img/users/dio.png" width="50px"><br><span class="fonts">dio</span></a></li>
        <li class="active fonts"><a href=""><img src="http://leave.ptt.wabow.com/dist/img/users/michael.png" width="50px"><br><span class="fonts">michael</span></a></li>
        <li class="active fonts"><a href=""><img src="http://leave.ptt.wabow.com/dist/img/users/tony.png" width="50px"><br><span class="fonts">tony</span></a></li>
        <li class="active fonts"><a href=""><img src="http://leave.ptt.wabow.com/storage/avatar/carrie.png" width="50px"><br><span class="fonts">carrie</span></a></li>
        <li class="active fonts"><a href=""><img src="http://leave.ptt.wabow.com/dist/img/users/eno.png" width="50px"><br><span class="fonts">eno</span></a></li>
      </ul>
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

    $('#calendar').fullCalendar({
      height: 800,
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,listMonth'
      },
      buttonText: {
        listMonth: 'List Month',
      },
      defaultDate: '2017-10-12',
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
          start: '2017-10-12'
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
