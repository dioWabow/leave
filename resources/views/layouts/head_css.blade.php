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
<link rel="stylesheet" href="{{route('root_path')}}/plugins/colorpicker/bootstrap-colorpicker.min.css">
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
<!-- colorpicker -->
<script src="{{route('root_path')}}/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

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
@if(Request::is('holidies/*'))
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
@endif


<!-- 團隊設定用 -->
@if(Request::is('teams/*'))
<script>
$(document).ready(function () {

  $('#nestable').nestable();

  $(".my-colorpicker2").colorpicker();

  // 新增的ajax
  $('#menu-add').find("button[id='addButton']").click(function() {

    $this = $(this);
    $team_name = $this.parents().find("input[id='addInputName']").val();
    $team_color = $this.parents().find("input[id='addInputColor']").val();

    if($team_name == '') {
      alert('請填入組別名稱');
      return false;
    }

    if($team_color == ''){
      alert('請選擇組別顏色');
      return false;
    }

    $.ajax({
      type: "POST",
      url: "{{ route('teams/create') }}",
      dataType: "json",
      data: {
        "_token": "{{ csrf_token() }}",
        team_name: $team_name,
        team_color: $team_color,
      },
      success: function(data) {
        if (data.result) {
          alert('新增成功');
          $('.dd-list').append(data.html);
          $('.dd-empty').remove();
          $this.parents().find("input[id='addInputName']").val('');
          $this.parents().find("input[id='addInputColor']").val('');
        }
      },
      error: function(jqXHR) {
        alert("發生錯誤: " + jqXHR.status);
      }
    });
  });

  // 修改點下去 抓出id 丟給 editButton
  $('.button-edit').click(function(){
    $this = $(this);
    $id = $this.attr("data-owner-id");
    $('#editButton').val($id);
  });

  // 修改的ajax
  $('#editButton').click(function(){
    $this = $(this);

    $id = $this.val();
    $team_name = $this.parents().find("input[id='editInputName']").val();
    $team_color = $this.parents().find("input[id='editInputColor']").val();

    if($team_name == '') {
      alert('請填入組別名稱');
      return false;
    }

    if($team_color == ''){
      alert('請選擇組別顏色');
      return false;
    }

    $.ajax({
      type: "POST",
      url: "{{ route('teams/update') }}",
      dataType: "json",
      data: {
        "_token": "{{ csrf_token() }}",
        id: $id,
        team_name: $team_name,
        team_color: $team_color
      },
      success: function(data) {
        if (data.result) {
          alert('修改成功');
        }
      },
      error: function(jqXHR) {
        alert("發生錯誤: " + jqXHR.status);
      }
    });

  });

  // 刪除的 ajax
  $('.button-delete').click(function(){
    $this = $(this);

    $id = $this.attr("data-owner-id");

    $.ajax({
      type: "POST",
      url: "{{ route('teams/delete') }}",
      dataType: "json",
      data: {
        "_token": "{{ csrf_token() }}",
        id: $id,
      },
      success: function(data) {
        if (data.result) {
          alert('刪除成功');
        }
      },
      error: function(jqXHR) {
        alert("發生錯誤: " + jqXHR.status);
      }
    });

  });

  $('#memberReload').click(function(){

    $.get('index', function(data) {
      var html = $(data).find('#member_set').html();
      $('#member_set').html(html);
      $(".select2").select2();
    });

  });

});
</script>
@endif

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
