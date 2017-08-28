<link rel="stylesheet" href="{{route('root_path')}}/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<link rel="stylesheet" href="{{route('root_path')}}/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="{{route('root_path')}}/plugins/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="{{route('root_path')}}/plugins/fullcalendar/fullcalendar.print.css" media="print">

<!-- Select2 -->
<link rel="stylesheet" href="{{route('root_path')}}/plugins/select2/select2.min.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{route('root_path')}}/plugins/iCheck/all.css">
<!-- daterange picker -->
<link rel="stylesheet" href="{{route('root_path')}}/plugins/daterangepicker/daterangepicker.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{route('root_path')}}/plugins/timepicker/bootstrap-timepicker.min.css"> 
<!-- Bootstrap fileupload -->
<link href="{{route('root_path')}}/plugins/fileupload/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

<link rel="stylesheet" href="{{route('root_path')}}/plugins/nestable/style.css?v=3">
<link rel="stylesheet" href="{{route('root_path')}}/dist/css/AdminLTE.min.css">
<link rel="stylesheet" href="{{route('root_path')}}/dist/css/skins/skin-blue-light.min.css">
<link rel="stylesheet" href="{{route('root_path')}}/dist/css/wabow.css?v=6">

<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.2.3 -->
<script src="{{route('root_path')}}/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{route('root_path')}}/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="{{route('root_path')}}/dist/js/app.min.js"></script>

<!-- iCheck 1.0.1 -->
<script src="{{route('root_path')}}/plugins/iCheck/icheck.min.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{route('root_path')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{route('root_path')}}/plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- bootstrap time picker -->
<script src="{{route('root_path')}}/plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- Select2 -->
<script src="{{route('root_path')}}/plugins/select2/select2.full.min.js"></script>
<!-- Bootstrap fileupload -->
<script src="{{route('root_path')}}/plugins/fileupload/js/fileinput.js" type="text/javascript"></script>

<script src="{{route('root_path')}}/plugins/nestable/jquery.nestable.js"></script>
<script src="{{route('root_path')}}/plugins/nestable/jquery.nestable2.js?v=2"></script>

<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<!-- wabow -->
<script src="{{route('root_path')}}/js/wabow.js"></script>

<!-- 國定假日/補班與修改頁面 -->
  <script>
$(function () {
    $('#search_daterange').daterangepicker({
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#search_daterange').val('');

    $('#holidies_available_date').daterangepicker({
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#holidies_available_date').val('');

    $('#holidies_date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#holidies_date').val($('#holidies_date').attr('date'));
});
</script>

<!-- Index頁面 -->
<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
    }

    ini_events($('#external-events div.external-event'));

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day'
      },
      //Random default events
      events: [
        {
          title: 'All Day Event',
          start: new Date(y, m, 1),
          backgroundColor: "#f56954", //red
          borderColor: "#f56954" //red
        },
        {
          title: 'Long Event',
          start: new Date(y, m, d - 5),
          end: new Date(y, m, d - 2),
          backgroundColor: "#f39c12", //yellow
          borderColor: "#f39c12" //yellow
        },
        {
          title: 'Meeting',
          start: new Date(y, m, d, 10, 30),
          allDay: false,
          backgroundColor: "#0073b7", //Blue
          borderColor: "#0073b7" //Blue
        },
        {
          title: 'Lunch',
          start: new Date(y, m, d, 12, 0),
          end: new Date(y, m, d, 14, 0),
          allDay: false,
          backgroundColor: "#00c0ef", //Info (aqua)
          borderColor: "#00c0ef" //Info (aqua)
        },
        {
          title: 'Birthday Party',
          start: new Date(y, m, d + 1, 19, 0),
          end: new Date(y, m, d + 1, 22, 30),
          allDay: false,
          backgroundColor: "#00a65a", //Success (green)
          borderColor: "#00a65a" //Success (green)
        },
        {
          title: 'Click for Google',
          start: new Date(y, m, 28),
          end: new Date(y, m, 29),
          url: 'http://google.com/',
          backgroundColor: "#3c8dbc", //Primary (light-blue)
          borderColor: "#3c8dbc" //Primary (light-blue)
        }
      ],
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      drop: function (date, allDay) { // this function is called when something is dropped

        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject');

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject);

        // assign it the date that was reported
        copiedEventObject.start = date;
        copiedEventObject.allDay = allDay;
        copiedEventObject.backgroundColor = $(this).css("background-color");
        copiedEventObject.borderColor = $(this).css("border-color");

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);

        // is the "remove after drop" checkbox checked?
        if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
          $(this).remove();
        }

      }
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>

<!-- 我的假單頁面用 -->
  <script>
$(function () {
    $('#search_daterange').daterangepicker({
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('#search_daterange').val('');

    $("#leave_view_fileupload").fileinput({
        initialPreview: [
            './dist/img/unsplash2.jpg'
        ],
        initialPreviewAsData: true,
    });
});
</script>

<!--天災假調整用-->
<script>
$(function () {
    var $naturalDisasterList = $('.naturalDisasterList');

    $naturalDisasterList.hide();
    $('#settingSearch').on('click', function(){
        $naturalDisasterList.show();
    });

    $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    }).each(function(){
        $(this).val($(this).attr('date'));
    }).on('change', function(){ 
        $('#' + $(this).attr('id') + '_type option:eq(1)').prop('selected', true);
    });
});
</script>


<!-- 團隊設定用 -->
<script>
$('#nestable').nestable({
  maxDepth: 5
});
</script>

<!-- 員工管理與修改頁面用 -->
<script>
$(function () {
  $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('.single-date').each(function(){$(this).val($(this).attr('date'));});

    $("#user_fileupload").fileinput({
        initialPreview: [
            './dist/img/users/vic.png'
        ],
        initialPreviewAsData: true,
    });
});
</script>