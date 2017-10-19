@extends('default')

@section('content')
<style type="text/css">

  .fonts {

    display: block;
    text-align: center;

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
  <li><a href="{{ route('index') }}">日報表</a></li>
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
        <li class="active fonts"><a href=""><img src="https://goo.gl/wHhTwc" width="50px"><br><span class="fonts">dio</span></a></li>
        <li class="active fonts"><a href=""><img src="https://goo.gl/wHhTwc" width="50px"><br><span class="fonts">michael</span></a></li>
        <li class="active fonts"><a href=""><img src="https://goo.gl/wHhTwc" width="50px"><br><span class="fonts">tony</span></a></li>
        <li class="active fonts"><a href=""><img src="https://goo.gl/wHhTwc" width="50px"><br><span class="fonts">carrie</span></a></li>
        <li class="active fonts"><a href=""><img src="https://goo.gl/wHhTwc" width="50px"><br><span class="fonts">eno</span></a></li>
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
      header: {
        left: 'prev,next today',
        center: 'title',
        right: ''
      },
      defaultDate: '2017-10-12',
      navLinks: true,
      editable: true,
      eventLimit: true,
      events: [
        {
          title: 'All Day Event',
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
          start: '2017-10-09T16:00:00'
        },
        {
          id: 999,
          title: 'Repeating Event',
          start: '2017-10-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2017-10-11',
          end: '2017-10-13'
        },
        {
          title: 'Meeting',
          start: '2017-10-12T10:30:00',
          end: '2017-10-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2017-10-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2017-10-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2017-10-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2017-10-12T20:00:00'
        },
        {
          title: 'Birthday Party',
          start: '2017-10-13T07:00:00'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2017-10-28'
        }
      ],
      eventRender: function(event, element) {
            element.find('.fc-title').append("<br/>" + event.description);
      }
    });
  });

</script>
@stop
