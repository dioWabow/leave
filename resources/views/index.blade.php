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
  var json_change = '{!! json_encode($return_data) !!}';
  var events = JSON.parse(json_change);

  $(function () {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev, next, today',
        center: '',
        right: ''
      },
      //Random default events
      events: events,
      editable: false,
    });

    // 會改變的日期
    // 固定今天的日期

    $('.fc-prev-button').click(function(){
        // 傳減一
    });

    $('.fc-next-button').click(function(){

    });

  });
</script>
@stop
