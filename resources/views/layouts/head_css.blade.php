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
@if(Request::is('holidies/*'))
  <script>
$(function () {
    $('input[name="search[daterange]"]').daterangepicker({
        autoUpdateInput: false,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('input[name="search[daterange]"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="search[daterange]"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

    if("{{$model->start_date}}" == "") {
        $('#search_daterange').val('');
    } else {
        $('#search_daterange').val("{{ Carbon\Carbon::parse($model->start_date)->format('Y-m-d') }} - {{ Carbon\Carbon::parse($model->end_date)->format('Y-m-d') }}");
    }

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
@endif

<!-- 我的假單頁面用 -->
@if(Request::is('leaves/my/*'))
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
@endif



<!-- 團隊設定用 -->
<script>
$('#nestable').nestable({
  maxDepth: 5
});
</script>

<!-- 假別管理與修改頁面用 -->
@if(Request::is('leave_type/*'))
<script>
$(function () {
  $("#leave_type_available_date").daterangepicker({
    showDropdowns: true,
    locale: {format: 'YYYY-MM-DD'},
  });

@if($model->start_time != '' || $model->end_time != '' ) 
  $('#leave_type_available_date').val("{{Carbon\Carbon::parse($model->start_time)->format('Y-m-d')}} - {{\Carbon\Carbon::parse($model->end_time)->format('Y-m-d')}}");
@else
  $('#leave_type_available_date').val("");
@endif
});
</script>
@endif
<!-- 團隊假單頁面用 主管-->
@if(Request::is('leaves_manager/*'))
@if(Request::is('leaves_manager/prove/*'))
<script>
/* 批准假單文字替換*/
$(function () {
  $("#disagree").on("click", function(){

    $("#btn_agree").val(0);
    $(".change-body-text h1").html("確定此批假單 <span class='text-red'>不允許放假</span> 嗎？");
    
  });

  $("#agree").on("click", function(){

    $("#btn_agree").val(1);
    $(".change-body-text h1").html("確定此批假單 <span class='text-red'>允許放假</span> 嗎？");

  });
});
</script>
@endif
@if(Request::is('leaves_manager/history/*'))
<script>
$(function () {
  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth()+1; //January is 0!
  var yyyy = today.getFullYear();
  var $search_daterange = $('#search_daterange');
  var time = $search_daterange.val();
  
  $("#search_daterange").daterangepicker({
    showDropdowns: true,
    locale: {format: 'YYYY-MM-DD'},
    maxDate: yyyy + '-' + mm + '-' + dd
  });

  $("#search_daterange").val(time);
  
  $('input[name="search[daterange]"]').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('input[name="search[daterange]"]').on('cancel.daterangepicker', function(ev, picker) {
    $(this).val('');
  });

});
function changePageSize(pagesize)
{
  $("#frmOrderby").submit();
}
</script>
@endif
@if (Request::is('leaves_manager/prove/*','leaves_manager/upcoming/*','leaves_manager/history/*'))
<script>
$(function () {
  $(".sort").on("click", function(){

    var $sortname = $(this).attr("sortname");
    var $order_by = "{{ $model->order_by }}";
    var $order_way = "{{ $model->order_way }}";

    $("#order_by").val($sortname);

    if ($order_by == $sortname && $order_way == "DESC") {

      $("#order_way").val("ASC");

    } else {

      $("#order_way").val("DESC");

    }
    
    $("#frmOrderby").submit();

  });
});
</script>
@endif
@endif