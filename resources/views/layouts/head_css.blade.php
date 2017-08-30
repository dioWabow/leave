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