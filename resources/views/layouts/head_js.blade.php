<!-- fullCalendar 2.2.5 -->
<!-- 全部共用 -->
<script>
$(function () {
  $('.table').on("click", ".clickable-row", function(e) {
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

  //預設圖片
  $("img").error(function () {
   $(this).unbind("error").attr("src", "{{route('root_path')}}/dist/img/users/default.png");
  });

  //Flat red color scheme for iCheck
  $('input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-blue',
    radioClass: 'iradio_flat-blue'
  });

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
@if(Request::is('leaves_my/*'))
  @if(Request::is('leaves_my/history'))
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
  @if (Request::is('leaves_my/prove','leaves_my/upcoming','leaves_my/history'))
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

<!--天災假調整用-->
@if(Request::is('natural/*'))
<script>
$(function () {
    $('#natural_search').on('click', function(){
        $("#natural_search_frm").submit();
    });

    var default_pre_date = "{{$input["date"]}}";
    var default_date = new Date(default_pre_date);
    $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
        startDate: default_date
    }).each(function(){
        $(this).val($(this).attr('date'));
    }).on('change', function(){ 
        $('#' + $(this).attr('id') + '_type option:eq(1)').prop('selected', true);
    });
    $("#natural_date").val(default_pre_date);
});
</script>
@endif

<!--工作日誌調整用-->
@if(Request::is('sheet/daily/*'))
<script>
  $(function () {
    /*算前7天的日期*/
    var minDate = new Date();
    minDate.setDate(minDate.getDate() - 7);
    var minDate = moment(minDate).format("YYYY-MM-DD");
    
    /*算後1天的日期*/
    var maxDate = new Date();
    maxDate.setDate(maxDate.getDate() + 1);
    var maxDate = moment(maxDate).format("YYYY-MM-DD");

    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var $search_work_day = $("#search_work_day");
    var time = $search_work_day.val();
    if(dd <= 9) dd = '0'+ dd;
    if(mm <= 9) mm = '0'+ mm;
    
    /*按下今日，變換日期*/
    $(".search-today").on("click", function(){
      $("#search_work_day").val(yyyy + '-' + mm + '-' + dd)
    });

    /*checkbox 樣式*/
    $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    $(".clickable-row").click(function(e) {
      if($(e.target).hasClass("ignore")) return;

      var ignore = ["input", "a", "button", "textarea", "label"];
      var clicked = e.target.nodeName.toLowerCase();
      if($.inArray(clicked, ignore) > -1) return;
      
      window.location = $(this).data("href");
    });

    /* checkbox 選取全部 效果 */
    $("#checkall").on("ifChecked ifUnchecked",function(evant){
      if(evant.type == "ifChecked")
        $(".check").iCheck("check");
      else
        $(".check").iCheck("uncheck");
    });

    /*確認check有勾選才可打開核准按鈕*/
    $("input[name='time_sheet[id][]']").on("ifChanged", function () {
      if ($('.check:checked').length > 0) {
        $("#time_sheet_copy_date,#time_sheet_copy_to").prop("disabled", false);
      } else {
          $("#time_sheet_copy_date,#time_sheet_copy_to").prop("disabled", true);
      }
    });

    /* 排序  */
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

    /* 如果是查看過去的日誌，會有日期的問題  */
    /* 當日誌的日期小於最小日期，則將日期清空，這樣datarangepicker才不會因為樣式不顯示原本的日期  */
    var daily_working_day = $("#daily_working_day").val();
    
    if ( new Date(daily_working_day) < new Date(minDate) ){
      minDate = "";
    }
  
    /* 列表複製 & 新增 + 修改 datarangepicker */
    $("#time_sheet_copy_date, #daily_working_day").daterangepicker({
      alwaysShowCalendars: true,
      singleDatePicker: true,
      showDropdowns: true,
      minDate: minDate,
      maxDate: maxDate,
      locale: {format: 'YYYY-MM-DD'}
    });  
    

    /* 前往日期的 datarangepicker */
    $("#search_work_day").daterangepicker({
      alwaysShowCalendars: true,
      singleDatePicker: true,
      showDropdowns: true,
      locale: {format: 'YYYY-MM-DD'},
    });

  });
</script>
<style>
  .rwd-table {
　background: #fff;
　overflow: hidden;
}
.rwd-table tr:nth-of-type(2n){
　background: #eee;
}
.rwd-table th, 
.rwd-table td {
　margin: 0.5em 1em;
}
.rwd-table {
　min-width: 100%;
}
.rwd-table th {
　display: none;
}
.rwd-table td {
　display: block;
}
.rwd-table td:before {
　content: attr(data-th) " : ";
　font-weight: bold;
　width: 6.5em;
　display: inline-block;
}
.rwd-table th, .rwd-table td {
　text-align: left;
}
.rwd-table th, .rwd-table td:before {
　color: #D20B2A;
　font-weight: bold;
}
@media (min-width: 480px) {
.rwd-table td:before {
　display: none;
}
.rwd-table th, .rwd-table td {
　display: table-cell;
　padding: 0.25em 0.5em;
}
.rwd-table th:first-child, 
.rwd-table td:first-child {
　padding-left: 0;
}
.rwd-table th:last-child, 
.rwd-table td:last-child {
　padding-right: 0;
}
.rwd-table th, 
.rwd-table td {
　padding: 1em !important;
}
}
</style>
@endif
@if(Request::is('sheet/daily/create','sheet/daily/edit/*'))
<script>
$(function () {
  $('#daily_list_form').bootstrapValidator({
      message: 'This value is not valid',
      fields: {
        'daily[working_day]': {
            validators: {
                notEmpty: {
                  message: '請填寫工作日期'
                },
            }
        },
        'daily[project_id]': {
            validators: {
                notEmpty: {
                  message: '至少選擇一項專案名稱'
                },
            }
        },
       'daily[items]': {
            validators: {
                notEmpty: {
                  message: '請填寫標題'
                },
                stringLength: {
                  max: 100,
                  message: '標題不可超過100個字'
                },
                regexp: {
                  regexp: /^[^　]+$/,
                  message: '標題請不要輸入全形空白',
                }
            }
        },
        'daily[hour]': {
            validators: {
                notEmpty: {
                    message: '請填寫工作時數'
                },
                numeric: {
                  message: '請填寫數字',
                }
            }
        },
      }
  });


  /*使用daterangerpicker 後 重新驗證 */
  $("#daily_working_day").on("hide.daterangepicker", function(){
    var bootstrapValidator = $("#daily_list_form").data('bootstrapValidator');
    bootstrapValidator.updateStatus('daily[working_day]', 'NOT_VALIDATED', null).validateField('daily[working_day]');
  });

  $('#daily_tag').tagit();

});

</script>

@endif

<!-- 團隊設定用 -->
@if(Request::is('teams/*'))
<script>
$(document).ready(function () {

  var judge_Drop = 0;

  var nestableChange = function (e) {
    var list = e.length ? e : $(e.target), output = list.data('output');

    $.ajax({
        method: "POST",
        url: "{{route('teams/update_drop')}}",
        data: {
          "_token": "{{ csrf_token() }}", 
          "team_json": window.JSON.stringify(list.nestable('serialize')),
        },
        success: function(data){
          if (judge_Drop == 0) {
            judge_Drop = 1;
          } else {
            if(data == "true") {
              alert('更新成功');
            } else {
              alert('沒有提供排序服務,請見諒');
            }
          }
          console.log(data);
        },
    }).fail(function(jqXHR, textStatus, errorThrown){
        alert("更新失敗!");
    });
  };

  $('#nestable').nestable({
    maxDepth: 2,
    dropCallback : 'sourceId'
    }).on('change', nestableChange);
  nestableChange($('#nestable').data('output', $('#nestable-output')));



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

    if($team_color == '') {
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
          $('#team_set_list').append(data.html);
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

  $(document).on('click', '.button-edit', prepareEdit);

  // 修改點下去 抓出id 丟給 editButton
  // 顏色丟給 edit_color
  $(document).on('click', '.button-edit', function(event){

    $this = $(this);

    $id = $this.attr("data-owner-id");
    $('#editButton').val($id);

    $team_color = $this.attr("data-color");
    $('#edit_color').css('backgroundColor', $team_color);

  });

  $(document).on('click', '#editButton', editMenuItem);

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
          $("#menu-editor").fadeOut();
        }
      },
      error: function(jqXHR) {
        alert("發生錯誤: " + jqXHR.status);
      }
    });

  });

  $(document).on('click', '.button-delete', deleteFromMenu);

  // 刪除的 ajax
  $(document).on('click', '.button-delete', function(event){
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

  $('form[name=member_form]').submit(function(event){

    // 跑所有team
    $('.member_list').each(function(){

      $team_id = $(this).attr('team_id');
      $team_name = $(this).attr('team_name');

      // 跑團隊人員 與 主管人員
      $team_member = $('#member_'+$team_id).select2('val');
      $team_manager = $('#manager_'+$team_id).select2('val');

      // 一定要有主管
      if($team_manager == "") {
        event.preventDefault();
        alert('請設定 ' + $team_name + ' 的主管!!');
      }

      // 當有選主管才要判斷
      if($team_manager != "") {

        if($team_member === null) {

          event.preventDefault();
          alert($team_name + ' 有主管的情況至少要有一名組員!!');

        } else {

          for(var key in $team_member) {

            if($team_manager == $team_member[key]) {

              event.preventDefault();
              alert($team_name + ' 人員不能同時為主管!!');

            }//endif

          }//endfor

        }//endelse

      }//endif

    });

});


});

</script>
@endif

<!-- 假別管理與修改頁面用 -->
@if(Request::is('leave_type/*'))
<script>
  $(function () {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!
    var yyyy = today.getFullYear();
    var $leave_type_available_date = $("#leave_type_available_date");
    var time = $leave_type_available_date.val();

    $("#leave_type_available_date").daterangepicker({
            showDropdowns: true,
            locale: {format: 'YYYY-MM-DD'},
        });
        
    $("#leave_type_available_date").val(time);
    
    $('input[name="leave_type[available_date]"]').on("apply.daterangepicker", function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
    });

    $('input[name="leave_type[available_date]"]').on("cancel.daterangepicker", function(ev, picker) {
      $(this).val('');
    });

    $("input[name^=leave_type]").on("change", function(){
      var id = $(this).val();
      var deductions = ($(".leave_type_deductions" + id).prop("checked")) ? '1' : '0';
      var reason = ($(".leave_type_reason" + id).prop("checked")) ? '1' : '0';
      var prove = ($(".leave_type_prove" + id).prop("checked")) ? '1' : '0';
      var available = ($(".leave_type_available" +id).prop("checked")) ? '1' : '0';

      $.ajax({
        type: "POST",
        url: "{{ route('leave_type/update_ajax') }}",
        dataType: "json",
        data: {
          "_token": "{{ csrf_token() }}",
          id: id,
          deductions: deductions,
          prove: prove,
          reason: reason,
          available: available,
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
  });

  function changePageSize(pagesize)
  {
      $("#frmSearch").submit();
  }

  function changeSort(sort)
  {
    order_by = "{{ $model->order_by }}";
    order_way = "{{ $model->order_way }}";

    $("#order_by").val(sort);

    if (order_by == sort && order_way == "DESC") {
        $("#order_way").val("ASC");
    } else {
        $("#order_way").val("DESC");
    }

    $("#frmSearch").submit();
  }

</script>
@endif

<!-- 協助請假 -->
@if(Request::is('leave_assist/getIndex'))
  <script>
  $(function () {
    $(".clickable-row").click(function(e) {
      if($(e.target).hasClass('ignore')) return;

      var ignore = ['input', 'a', 'button', 'textarea', 'label'];
      var clicked = e.target.nodeName.toLowerCase();
      if($.inArray(clicked, ignore) > -1) return;
      
      window.location = $(this).data('href');
    });
  });
  </script>
@endif
<!-- 我要請假用、協助請假 -->
@if(Request::is('leave/create','leave_assist/create/*'))
<script>
$(function () {
  
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
      } else {
        $leave_notice.hide();
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
    } else {
      $leave_notice.hide();
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
        @if($user->arrive_time == '0900')
          options.startDate = yyyy+"-"+mm+"-"+dd+" 09:00";
          options.endDate = yyyy+"-"+mm+"-"+dd+" 18:00";
        @else
          options.startDate = yyyy+"-"+mm+"-"+dd+" 09:30";
          options.endDate = yyyy+"-"+mm+"-"+dd+" 18:30";
        @endif
        
      }

      options.timePicker = true;
      options.timePickerIncrement = 30;
      options.timePicker24Hour = true;
      options.leave_compute = true;
      options.minute_select = true;
      @if($user->arrive_time == '0900')
        options.minute_option = 00;
        options.minDate = yyyy + '-' + mm + '-' + dd + ' 09:00';
      @else
        options.minute_option = 30;
        options.minDate = yyyy + '-' + mm + '-' + dd + ' 09:30';
      @endif
      
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

  function calculate_hours() {
    if ($("#leave_timepicker").val()) {
      $.ajax({
        url: '{{route("leave/calculate_hours")}}',
        type: 'POST',
        data: {"_token": "{{ csrf_token() }}", date_range:$("#leave_timepicker").val(),user_id:$('#leave_user_id').val()},
        dataType: 'JSON',
        success: function (data) { 
          $.each(data, function(index, element) {
              if ($("#ajax_switch").val() == 0) {
                $('#leave_spent_hours').val(element);
                $('#leave_spent_hours_hide').val(element);
              } else {
                $("#ajax_switch").val(0);
              }
          });
        }
      });
    }
  }

  $("#leave_fileupload").fileinput({
    initialPreviewAsData: true,
    showUpload: false,
    maxFileSize: 8000,
    'msgSizeTooLarge': '檔案："{name}" (<b>{size} KB</b>)，檔案上限超過<b>{maxSize} KB</b>，請重新選擇',
  });

  $("#rechoose").click(function(){
    window.location = "{{route('leave_assist/getIndex')}}";

  });

});
</script>
@endif

<!-- 假單詳細頁面 -->
@if(Request::is('leaves_my/leave_detail/*','report/leave_detail/*','leaves_manager/leave_detail/*','agent_approve/leave_detail/*','leaves_hr/leave_detail/*','annual_report/leave_detail/*','annual_leave_calculate/leave_detail/*','annual_report/leave_detail/*','leaved_user_annual_leave_calculate/leave_detail/*','agent/leave_detail/*'))
<script>
  $(function () {      

      $('#search_daterange').daterangepicker({
          showDropdowns: true,
          locale: {format: 'YYYY-MM-DD'},
      });

      $('#search_daterange').val('');
      
      $("#leave_view_fileupload").fileinput({
          uploadUrl: "{{route('leave/upload')}}",
          uploadAsync: false,
          maxFileCount: 5,
          validateInitialCount: true,
          overwriteInitial: false,
          showUpload: false,
          showRemove: false,
          maxFileSize: 8000,
          'msgSizeTooLarge': '檔案："{name}" (<b>{size} KB</b>)，檔案上限超過<b>{maxSize} KB</b>，請重新選擇',
          'msgFilesTooMany': '你選了{n}個檔案</b>，最多只能上傳<b>{m}</b>個檔案',
          @if(Auth::getUser()->id != $model->user_id||in_array($model->tag_id,[7,8])) 
          showBrowse: false,
          initialPreviewShowDelete: false,
          @endif
          initialPreviewAsData: true,
          uploadExtraData : {
            "_token": "{{ csrf_token() }}",
            "id": "{{$model->id}}",
          },
          @if($model->prove)
          initialPreview: [
            @foreach(explode(',',$model->prove) as $prove)
            "{{UrlHelper::getLeaveProveUrl($prove)}}",
            @endforeach
          ],
          initialPreviewConfig: [
          @foreach(explode(',',$model->prove) as $prove)
          {
            caption : "{{$prove}}",
            url: '{{route("leave/delete")}}',
            extra: {"_token" : "{{ csrf_token() }}",
              "id" : "{{$model->id}}",
              "file" : "{{$prove}}",
            },
          },
          @endforeach
          ],
          @endif
      preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
      previewFileIconSettings: { // configure your icon file extensions
          'doc': '<i class="fa fa-file-word-o text-primary"></i>',
          'xls': '<i class="fa fa-file-excel-o text-success"></i>',
          'ppt': '<i class="fa fa-file-powerpoint-o text-danger"></i>',
          'pdf': '<i class="fa fa-file-pdf-o text-danger"></i>',
          'zip': '<i class="fa fa-file-archive-o text-muted"></i>',
          'htm': '<i class="fa fa-file-code-o text-info"></i>',
          'txt': '<i class="fa fa-file-text-o text-info"></i>',
          'mov': '<i class="fa fa-file-movie-o text-warning"></i>',
          'mp3': '<i class="fa fa-file-audio-o text-warning"></i>',
          // note for these file types below no extension determination logic 
          // has been configured (the keys itself will be used as extensions)
          'jpg': '<i class="fa fa-file-photo-o text-danger"></i>', 
          'gif': '<i class="fa fa-file-photo-o text-muted"></i>', 
          'png': '<i class="fa fa-file-photo-o text-primary"></i>'    
      },
      previewFileExtSettings: { // configure the logic for determining icon file extensions
          'doc': function(ext) {
              return ext.match(/(doc|docx)$/i);
          },
          'xls': function(ext) {
              return ext.match(/(xls|xlsx)$/i);
          },
          'ppt': function(ext) {
              return ext.match(/(ppt|pptx)$/i);
          },
          'zip': function(ext) {
              return ext.match(/(zip|rar|tar|gzip|gz|7z)$/i);
          },
          'htm': function(ext) {
              return ext.match(/(htm|html)$/i);
          },
          'txt': function(ext) {
              return ext.match(/(txt|ini|csv|java|php|js|css)$/i);
          },
          'mov': function(ext) {
              return ext.match(/(avi|mpg|mkv|mov|mp4|3gp|webm|wmv)$/i);
          },
          'mp3': function(ext) {
              return ext.match(/(mp3|wav)$/i);
          }
      }
      }).on("filebatchselected", function(event, data, previewId, index) {
          $("#leave_view_fileupload").fileinput("upload");
      }).on('filebatchuploadsuccess', function(event, data, previewId, index) {

      }).on('filepredelete ', function(event, data, previewId, index) {

      }).on('filedeleted ', function(event, data, previewId, index) {

      });
  
      $("#cancel").on("click", function(){

        $("#leave_status").val(1);
        $(".modal-body h1").html("確定 <span class='text-red'>取消</span> 此假單嗎？");
       
      });

      $("#disagree").on("click", function(){

        $("#leave_status").val(0);
        $(".modal-body h1").html("確定 <span class='text-red'>不允許</span> 此假單嗎？");
       
      });

      $("#agree").on("click", function(){

        $("#leave_status").val(1);
        $(".modal-body h1").html("確定 <span class='text-red'>允許</span> 此假單嗎？");

      });

      $("#disagree_agent").on("click", function(){

        $("#leave_status").val(0);
        $(".modal-body h1").html("確定 <span class='text-red'>不代理</span> 此假單嗎？");
       
      });

      $("#agree_agent").on("click", function(){

        $("#leave_status").val(1);
        $(".modal-body h1").html("確定 <span class='text-red'>代理</span> 此假單嗎？");

      });
  
    $("#checkall").on("ifChecked ifUnchecked",function(event){
      if(event.type == "ifChecked")
        $(".check").iCheck("check");
      else
        $(".check").iCheck("uncheck");
    });

    /*確認check有勾選才可打開核准按鈕*/
    $("input[name='leave_day[]']").on("ifChanged", function () {
      if ($('.check:checked').length > 0) {
        $(".eliminate_confirm").prop("disabled", false);
      } else {
        $(".eliminate_confirm").prop("disabled", true);
      }
    });

    $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
    });

    $("#eliminate").on("click", function(){

      if ($('#leave_reason').val()) {

        $("#eliminate").attr("data-target", "#myModalConfirm1");
        $(".modal-body h1").html("確定 <span class='text-red'>銷假</span> 嗎？");

      } else {

        $("#eliminate").attr("data-target", "");
        alert("請輸入原因");

      }

    });

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
        maxFileSize: 8000,
        'msgSizeTooLarge': '檔案："{name}" (<b>{size} KB</b>)，檔案上限超過<b>{maxSize} KB</b>，請重新選擇',
    });
    
    $("#clear_leave_date").click(function() {
      $("#user_leave_date").val("");
    });
});
</script>
@endif
@endif

<!-- 特休結算+特休報表+報表+離職人員特休結算排序用 -->
@if(Request::is('annual_leave_calculate/*','report/index','annual_report/*','leaved_user_annual_leave_calculate/*','sheet/absense_report/index'))
<script>
  $(document).on("click", "th", function() {
  var table = $(this).parents("table").eq(0);
  var rows = table.find("tbody > tr").toArray().sort(comparer($(this).index()));
  this.asc = !this.asc;
  if (!this.asc) {
    rows = rows.reverse();
  }
  table.children("tbody").empty().html(rows);
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
    return $(row).children("td").eq(index).text();
  }
</script>
@endif
<!-- 我是代理人頁面/工作日誌搜尋用 -->
@if(Request::is('agent/index','sheet/search/index'))
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
<!-- 團隊假單頁面用-HR -->
@if(Request::is('leaves_hr/*'))
  @if(Request::is('leaves_hr/history'))
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
  @if (Request::is('leaves_hr/prove','leaves_hr/upcoming','leaves_hr/history'))
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

  $(".clickable-row").click(function(e) {
    if($(e.target).hasClass("ignore")) return;

    var ignore = ["input", "a", "button", "textarea", "label"];
    var clicked = e.target.nodeName.toLowerCase();
    if($.inArray(clicked, ignore) > -1) return;
    
    window.location = $(this).data("href");
  });

  $("#checkall").on("ifChecked ifUnchecked",function(evant){
    if(evant.type == "ifChecked")
      $(".check").iCheck("check");
    else
      $(".check").iCheck("uncheck");
  });

  /*確認check有勾選才可打開核准按鈕*/
  $("input[name='leave[leave_id][]']").on("ifChanged", function () {
    if ($('.check:checked').length > 0) {
      $(".approve_leave").prop("disabled", false);
    } else {
      $(".approve_leave").prop("disabled", true);
    }
  });

  var $input_leave_notic_person = $("input[name='leave\[notic_person\]\[\]']");
  var $div_leave_notic_person   = $("#div_leave_notic_person");
    
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
<!-- 同意代理嗎? 頁面用 -->
@if(Request::is('agent_approve/index'))
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
  /* 同不同意代理文字替換*/
  $(".btn-danger").on("click", function(){
    
    $("#btn_agree").val(0);
    $(".modal-body h1").html("確定 <span class='text-red'>不能代理</span> 嗎？");
    
  });

  $(".btn-info").on("click", function(){
    
    $("#btn_agree").val(1);
    $(".modal-body h1").html("確定 <span class='text-red'>同意代理</span> 嗎？");

  });

  $(".clickable-row").click(function(e) {
    if($(e.target).hasClass("ignore")) return;

    var ignore = ["input", "a", "button", "textarea", "label"];
    var clicked = e.target.nodeName.toLowerCase();
    if($.inArray(clicked, ignore) > -1) return;
    
    window.location = $(this).data("href");
  });

  $("#checkall").on("ifChecked ifUnchecked",function(evant){
    if(evant.type == "ifChecked")
      $(".check").iCheck("check");
    else
      $(".check").iCheck("uncheck");
  });

  /*確認check有勾選才可打開核准按鈕*/
  $("input[name='leave[leave_id][]']").on("ifChanged", function () {
    if ($('.check:checked').length > 0) {
      $(".approve_leave").prop("disabled", false);
    } else {
        $(".approve_leave").prop("disabled", true);
    }
  });

  var $input_leave_notic_person = $("input[name='leave\[notic_person\]\[\]']");
  var $div_leave_notic_person   = $("#div_leave_notic_person");
    
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
});
</script>
@endif

<!--系統設定-->
@if(Request::is('config/edit'))
<script>
$(function () {  
  $("#config_fileupload").fileinput({
      uploadUrl: "{{route('config/upload')}}",
      uploadAsync: false,
      maxFileCount: 5,
      validateInitialCount: true,
      overwriteInitial: false,
      allowedFileTypes: ['image'],
      showUpload: false,
      showRemove: false,
      initialPreviewAsData: true,
      maxFileSize : 8000,
      'msgSizeTooLarge': '檔案："{name}" (<b>{size} KB</b>)，檔案上限超過<b>{maxSize} KB</b>，請重新選擇',
      'msgFilesTooMany': '你選了{n}個檔案</b>，最多只能上傳<b>{m}</b>個檔案',
      uploadExtraData : {
        "_token": "{{ csrf_token() }}",
      },
      'msgInvalidFileType' : '"{name}"的檔案格式錯誤，只能上傳"{types}"',
      'msgInvalidFileExtension' : '"{name}"的檔案格式錯誤，只能用"{extensions}"',
      @if(ConfigHelper::getConfigValueByKey('login_pictures'))
      initialPreview: [
        @foreach(explode(',' , ConfigHelper::getConfigValueByKey('login_pictures')) as $picture)
          "{{UrlHelper::getLoginPictureUrl($picture)}}",
        @endforeach
      ],
      initialPreviewConfig: [
      @foreach(explode(',' , ConfigHelper::getConfigValueByKey('login_pictures')) as $picture)
      {
        caption : "{{$picture}}",
        url: '{{route("config/delete")}}',
        extra: {"_token" : "{{ csrf_token() }}",
          "file" : "{{$picture}}",
        },
      },
      @endforeach
      ],
      @endif
  }).on("filebatchselected", function(event, data, previewId, index) {
      $("#config_fileupload").fileinput("upload");
  }).on('filebatchuploadsuccess', function(event, data, previewId, index) {
  }).on('filepredelete ', function(event, data, previewId, index) {
  }).on('filedeleted ', function(event, data, previewId, index) {
  });

  $(document).on('change', '#form_config_company', function(event){
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('click', '#form_config_company .file-input', function(event){
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_smtp', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_google', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_slack', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_other :input").prop("disabled", true);
    });
    $(document).on('change', '#form_config_other', function(event){
        $("#form_config_company :input").prop("disabled", true);
        $("#form_config_smtp :input").prop("disabled", true);
        $("#form_config_google :input").prop("disabled", true);
        $("#form_config_slack :input").prop("disabled", true);
    });
    $(".reset").click(function() {
      $(":input").prop("disabled", false);
    });

    var $option = {'showUpload': false};

    @if( $config['company_logo'] != '')
    $option.initialPreview = ['{{ UrlHelper::getCompanyLogoUrl($config['company_logo']) }}'];
    @endif

    $option.initialPreviewAsData = true;
    $option.maxFileSize = 8000;
    $option.msgSizeTooLarge = '檔案："{name}" (<b>{size} KB</b>)，檔案上限超過<b>{maxSize} KB</b>，請重新選擇';

    $("#config_company_logo").fileinput($option);
});
</script>

@endif
@if(Request::is('sheet/search/index'))
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
  </script>
@endif
<!-- 專案項目設定 -->
@if(Request::is('sheet/project/*'))
<script>
$(function () {
  $('input[type="checkbox"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass: 'iradio_flat-blue'
  });

  /*主團隊 勾選checkbox時顯示子團隊*/
  $(".sub_team").hide();

  // 如果一開始就被選 就要顯示
  $(".main_team").each(function() {

    if($(this).prop("checked")){

      $(".show_team_"+$(this).val()).fadeToggle();

    }

  });

  // 一開始沒被選 被選要顯示
  $('.main_team').on("ifChanged", function() {

    var id = $(this).val();

    $(".show_team_"+id).fadeToggle();

  });

});

</script>
@endif

@if(Request::is('sheet/project/index'))
<script>
  // 切換狀態
  $(function () {
    $("input[name^=sheet_project]").on("change", function(){

      var id = $(this).val();
      var available = ($(".sheet_project_available" +id).prop("checked")) ? '1' : '0';

      $.ajax({
        type: "POST",
        url: "{{ route('sheet/project/update_ajax') }}",
        dataType: "json",
        data: {
          "_token": "{{ csrf_token() }}",
          id: id,
          available: available,
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
  });
</script>
@endif
@if(Request::is('sheet/calendar*'))
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
        //Random default events
        events: function(start, end, timezone, callback) {
          $.ajax({
              url: "{{route('sheet/calendar/ajax_sheet')}}",
              type: 'POST',
              dataType: 'json',
              data: {
                  // our hypothetical feed requires UNIX timestamps
                  "_token": "{{ csrf_token() }}",
                  id: {{$chosed_user_id}},
                  start: start.unix(),
                  end: end.unix()
              },
              success: function(data) {

                var events = [];

                $.each(data, function(index, value) {
                  events.push({
                      title: unescapeHtml(value['items']) + ' / ' + value['hour'] + '小時',
                      start: value['working_day'], // will be parsed
                  });
                });

                callback(events);
              }
          });
        },
        defaultDate: '{{Carbon\Carbon::now()->format("Y-m-d")}}}',
        locale: initialLocaleCode,
        navLinks: false, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        eventRender: function(event, element) {
          element.prop("title", event.title);
        }
      });
    });

    function unescapeHtml(safe) {
        return safe.replace(/&amp;/g, '&')
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&quot;/g, '"')
            .replace(/&#039;/g, "'");
    }

  </script>
@endif

