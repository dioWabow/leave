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

<!-- 全部共用 -->
<script>
$(function () {
  $(".clickable-row").click(function(e) {
    if($(e.target).hasClass('ignore')) return;

    var ignore = ['input', 'a', 'button', 'textarea', 'label'];
    var clicked = e.target.nodeName.toLowerCase();
    if($.inArray(clicked, ignore) > -1) return;
    
    window.location = $(this).data('href');
  });

  $('#checkall').on('ifChecked ifUnchecked',function(evant){
    if(evant.type == 'ifChecked')
      $('.check').iCheck('check');
    else
      $('.check').iCheck('uncheck');
  });

  //代理人、通知對象
  $(".select2").select2({width: '100%'});

});

</script>

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

<!-- 我要請假用 -->
@if(Request::is('leave/*'))
<script>
$(function () {
  $(".clickable-row").click(function(e) {
    if($(e.target).hasClass('ignore')) return;

    var ignore = ['input', 'a', 'button', 'textarea', 'label'];
    var clicked = e.target.nodeName.toLowerCase();
    if($.inArray(clicked, ignore) > -1) return;
    
    window.location = $(this).data('href');
  });

  $('#checkall').on('ifChecked ifUnchecked',function(evant){
    if(evant.type == 'ifChecked')
      $('.check').iCheck('check');
    else
      $('.check').iCheck('uncheck');
  });

  var $leave_dayrange           = $('#leave_dayrange');
  var $leave_timepicker         = $('#leave_timepicker');
  var $leave_dayrange_allday    = $('#leave_dayrange_allday');
  var $leave_dayrange_morning   = $('#leave_dayrange_morning');
  var $leave_dayrange_afternoon = $('#leave_dayrange_afternoon');
  var $leave_spent_hours        = $('#leave_spent_hours');
  var $leave_spent_hours_hide   = $('#leave_spent_hours_hide');
  var $label_leave_spent_hours  = $('#label_leave_spent_hours');
  var $label_leave_dayrange     = $('#label_leave_dayrange');
  var $div_leave_spent_hours    = $('#div_leave_spent_hours');
  var $div_leave_dayrange       = $('#div_leave_dayrange');
  var $input_leave_type_id      = $("input[name='leave\[type_id\]']");
  var $input_leave_notic_person = $("input[name='leave\[notic_person\]\[\]']");
  var $div_leave_notic_person   = $("#div_leave_notic_person");
  var $keep_dayrange   = $("#keep_dayrange");
  var $leave_notice = $("#leave_notice");

  var leave_type_arr = ['entertain','birthday','lone_stay'];
  var leave_type_single_arr = ['entertain','birthday','lone_stay'];
  var leave_type_notice_arr = ['birthday','lone_stay'];
  var daterangepicker_type = 'isDate';

  //Flat red color scheme for iCheck
  $('input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
  });

  //通知對象
  $div_leave_notic_person.hide();
  $('input[type="checkbox"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
  });

  $input_leave_notic_person.on('ifChanged', function(event){
    if(event.target.value == 'none') {
      if(event.target.checked == true)
        $div_leave_notic_person.hide();
      else
        $div_leave_notic_person.show();

      $input_leave_notic_person.each(function(){
        if($(this).val() != event.target.value) $(this).iCheck('uncheck');
      });
    } else if (event.target.value == 'all') {
      if(event.target.checked == true){
        $input_leave_notic_person.each(function(){
          if($(this).val() != 'none') $(this).iCheck('check');
        });
      }else{
        $input_leave_notic_person.each(function(){
          $(this).iCheck('uncheck');
        });
      }
    }
  });

  //檢查哪些假別已用完
  $input_leave_type_id.each(function(){
    if($(this).attr('hour') == 0) $(this).iCheck('disable');
    if($(this).iCheck('update')[0].checked === true){

      var mydata = $(this).attr('exception');
      if($.inArray(mydata, leave_type_single_arr) !== -1) {
        daterangepicker_type = 'isSingleDate';
      } else {
        daterangepicker_type = 'isDatetime';
      }
      fetchDaterangepicker();
      if($.inArray(mydata, leave_type_arr) !== -1){
        $div_leave_spent_hours.hide();
        $label_leave_spent_hours.hide();
        
      }else{
        $div_leave_dayrange.hide();
        $label_leave_dayrange.hide();
        $leave_notice.hide();
      }

      if($.inArray(mydata, leave_type_notice_arr) !== -1){
        $leave_notice.text("該假別半天會當一天使用，請假之前請先考慮清楚");
      }
      
      //遇到善待假則 allday 不可選擇
      if ($keep_dayrange.val()) {

        if ($keep_dayrange.val().trim() == "morning") {

          $leave_dayrange_morning.iCheck('check');

        } else if($keep_dayrange.val().trim() == "afternoon") {

          $leave_dayrange_afternoon.iCheck('check');

        } else {

          $leave_dayrange_allday.iCheck('check');

        }

        //遇到善待假則 allday 不可選擇
        if($(this).val() == '1') {
          $leave_dayrange_allday.iCheck('disable');
        }

      } else {

        $leave_dayrange_allday.iCheck('check');

        //遇到善待假則 allday 不可選擇
        if($(this).val() == '1') {
          $leave_dayrange_allday.iCheck('disable');
          $leave_dayrange_allday.iCheck('uncheck');
          $leave_dayrange_morning.iCheck('check');
        }

      }
    }
  });

  //請假類別檢查
  $input_leave_type_id.on('ifChecked', function(event){
    $leave_timepicker.val('');
    $leave_spent_hours.val('');
    $leave_spent_hours_hide.val('');

    var mydata = $(this).attr('exception');
    if($.inArray(mydata, leave_type_arr) !== -1) {
      daterangepicker_type = 'isDate';
      if($.inArray(mydata, leave_type_single_arr) !== -1) daterangepicker_type = 'isSingleDate';

      //只要選到單一天，則將請假時段全開，並預設選擇 allday
      $("input[name='leave\[dayrange\]']").iCheck('enable'); 
      $leave_dayrange_allday.iCheck('check');

      //遇到善待假則 allday 不可選擇
      if(mydata == 'entertain') {
        $leave_dayrange_allday.iCheck('disable');
        $leave_dayrange_allday.iCheck('uncheck');
        $leave_dayrange_morning.iCheck('check');
      }

      $div_leave_spent_hours.hide();
      $label_leave_spent_hours.hide();

      $div_leave_dayrange.show();
      $label_leave_dayrange.show();

      $leave_notice.show();
    }else{
      $leave_notice.hide();

      $div_leave_spent_hours.show();
      $label_leave_spent_hours.show();

      $div_leave_dayrange.hide();
      $label_leave_dayrange.hide();

      daterangepicker_type = 'isDatetime';
    }

    if($.inArray(mydata, leave_type_notice_arr) !== -1){
      $leave_notice.text("該假別半天會當一天使用，請假之前請先考慮清楚");
    }

    fetchDaterangepicker();
  });

  //代理人、通知對象
  $(".select2").select2({width: '100%'});

  //日期選擇器
  function fetchDaterangepicker(){
    var options = {};
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var time = $leave_timepicker.val();

    options.locale = {format: 'YYYY-MM-DD'};
    if(daterangepicker_type == 'isSingleDate') {
      options.singleDatePicker = true;
      options.minDate = yyyy + '-' + mm + '-' + dd;
    }
    if(daterangepicker_type == 'isDatetime') {
      if (time) {
        options.startDate = time.split(" - ")['0'];
        options.endDate = time.split(" - ")['1'];
      } else {
        options.startDate = yyyy+"-"+mm+"-"+dd+" 09:00";
        options.endDate = yyyy+"-"+mm+"-"+dd+" 18:00";
      }

      options.timePicker = true;
      options.timePickerIncrement = 30;
      options.timePicker24Hour = true;
      options.minDate = yyyy + '-' + mm + '-' + dd;
      options.locale = {format: 'YYYY-MM-DD HH:mm'};
    }

    $leave_timepicker.daterangepicker(options);
    $leave_timepicker.val(time);

    $leave_timepicker.on('apply.daterangepicker', function(ev, picker) {
      var myStartDate = new Date(picker.startDate);
      var myEndDate = new Date(picker.endDate);

      //若天數 > 1則，不給選擇上午與下午
      if(daterangepicker_type == 'isDate') {
        var day = Math.round((myEndDate - myStartDate)/(24*60*60*1000));

        if(day > 1) {
          $leave_dayrange_morning.iCheck('disable');
          $leave_dayrange_afternoon.iCheck('disable');
          $leave_dayrange_allday.iCheck('check');
        }else{
          $leave_dayrange_morning.iCheck('enable');
          $leave_dayrange_afternoon.iCheck('enable');
        }
      }
    });

    $leave_timepicker.on('show.daterangepicker', function(ev, picker) {
        $('.hourselect option').each(function(){
          if($(this).val() < 9 || $(this).val() > 18) $(this).remove(); 
        });
    });

    $leave_timepicker.on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $("#ajax_switch").val(1);
    });

    $leave_timepicker.on('hide.daterangepicker', function(ev, picker) {
        $leave_spent_hours.val('');
        $leave_spent_hours_hide.val('');
        if(daterangepicker_type != 'isSingleDate') {

          calculate_hours();

        }
    });
  }
});
</script>
@endif

<!-- 員工管理用 -->
@if(Request::is('user/*'))
@if(Request::is('user/index'))
<script>
function changePageSize(pagesize){
  $("#frmSearch").submit();
}
function changeSort(sort){
  order_by = '{{$model->order_by}}';
  order_way = '{{$model->order_way}}';
  $('#order_by').val(sort);
  if (order_by == sort && order_way == "DESC") {
    $('#order_way').val("ASC");
  } else {
    $('#order_way').val("DESC");
  }
  $("#frmSearch").submit();
}
</script>
@endif
@if(Request::is('user/edit/*'))
<script>
$(function () {
  $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
    });

    $('.single-date').each(function(){
      $(this).val($(this).attr('date'));
    });

    $("#user_fileupload").fileinput({
        @if(!empty($model->avatar))
        initialPreview: [
            '{{UrlHelper::getUserAvatarUrl($model->avatar)}}'
        ],
        @endif
        initialPreviewAsData: true,
        showUpload: false,
    });
    
    $("#clear_leave_date").click(function() {
      $("#user_leave_date").val("");
    });
});
</script>
@endif
@endif

<!-- 特休結算用 -->
@if(Request::is('annual_leave_calculate/*'))
<script>
  function changeSort(sort){

    order_by = '{{$model->order_by}}';
    order_way = '{{$model->order_way}}';
    $('#order_by').val(sort);
    if (order_by == sort && order_way == "DESC") {
      $('#order_way').val("ASC");
    } else {
      $('#order_way').val("DESC");
    }
    $("#frmSearch").submit();
  }

  $(document).on('click', 'th', function() {
  var table = $(this).parents('table').eq(0);
  var rows = table.find('tbody > tr').toArray().sort(comparer($(this).index()));
  this.asc = !this.asc;
  if (!this.asc) {
    rows = rows.reverse();
  }
  table.children('tbody').empty().html(rows);
  });

  function comparer(index) {
    return function(a, b) {
      var valA = getCellValue(a, index),
        valB = getCellValue(b, index);
      return $.isNumeric(valA) && $.isNumeric(valB) ?
        valA - valB : valA.localeCompare(valB);
    };
  }

  function getCellValue(row, index) {
    return $(row).children('td').eq(index).text();
  }

</script>
@endif
