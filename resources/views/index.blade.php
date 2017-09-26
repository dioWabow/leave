@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	Dashboard
	<small>Control paneln</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="index"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Dashboard</li>
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
  $(function () {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev, next, today',
        center: 'title',
        right: ''
      },
      //Random default events
      events: function(start, end, timezone, callback) {
        $.ajax({
            url: '{{url("index")}}',
            type: 'POST',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                "_token": "{{ csrf_token() }}",
                start: start.unix(),
                end: end.unix()
            },
            success: function(data) {

              var events = [];

              $.each(data, function(index, value) {
                events.push({
                    title: value['title'],
                    start: value['start'], // will be parsed
                    end: value['end'],
                    backgroundColor: value['backgroundColor'],
                    borderColor: value['borderColor']
                });
              });

              callback(events);
            }
        });
      },
      editable: false,
    });

  });
</script>
@stop
