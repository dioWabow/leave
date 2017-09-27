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
    var $label_leave_spent_hours  = $('#label_leave_spent_hours');
    var $label_leave_dayrange     = $('#label_leave_dayrange');
    var $div_leave_spent_hours    = $('#div_leave_spent_hours');
    var $div_leave_dayrange       = $('#div_leave_dayrange');
    var $input_leave_type_id      = $("input[name='leave\[type_id\]']");
    var $input_leave_notic_person = $("input[name='leave\[notic_person\]\[\]']");
    var $div_leave_notic_person   = $("#div_leave_notic_person");

    var leave_type_arr = ['kindness-leave','birthday-leave','annual-leave','special-leave'];
    var leave_type_single_arr = ['kindness-leave','birthday-leave','special-leave'];
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
        fetchDaterangepicker();
        if($.inArray($(this).val(), leave_type_arr) !== -1){
          $div_leave_spent_hours.hide();
          $label_leave_spent_hours.hide();
        }else{
          $div_leave_dayrange.hide();
          $label_leave_dayrange.hide();
        }
      }
    });

    //請假類別檢查
    $input_leave_type_id.on('ifChecked', function(event){
      var mydata = $(this).val();
      if($.inArray(mydata, leave_type_arr) !== -1) {
        daterangepicker_type = 'isDate';
        if($.inArray(mydata, leave_type_single_arr) !== -1) daterangepicker_type = 'isSingleDate';

        //只要選到單一天，則將請假時段全開，並預設選擇 allday
        $("input[name='leave\[dayrange\]']").iCheck('enable'); 
        $leave_dayrange_allday.iCheck('check');

        //遇到善待假則 allday 不可選擇
        if($(this).val() == 'kindness-leave') {
          $leave_dayrange_allday.iCheck('disable');
          $leave_dayrange_allday.iCheck('uncheck');
          $leave_dayrange_morning.iCheck('check');
        }

        $div_leave_spent_hours.hide();
        $label_leave_spent_hours.hide();

        $div_leave_dayrange.show();
        $label_leave_dayrange.show();
      }else{
        $div_leave_spent_hours.show();
        $label_leave_spent_hours.show();

        $div_leave_dayrange.hide();
        $label_leave_dayrange.hide();

        daterangepicker_type = 'isDatetime';
      }

      fetchDaterangepicker();
    });

    //代理人、通知對象
    $(".select2").select2({width: '100%'});

    //日期選擇器
    function fetchDaterangepicker(){
      var options = {};
      
      options.locale = {format: 'YYYY-MM-DD'};
      if(daterangepicker_type == 'isSingleDate') options.singleDatePicker = true;
      if(daterangepicker_type == 'isDatetime') {
        options.timePicker = true;
        options.timePickerIncrement = 30;
        options.timePicker24Hour = true;
        options.locale = {format: 'YYYY-MM-DD HH:mm'};
      }

      $leave_timepicker.daterangepicker(options);
      $leave_timepicker.val('');
      $leave_spent_hours.val('');

      $leave_timepicker.on('apply.daterangepicker', function(ev, picker) {
        var myStartDate = new Date(picker.startDate);
        var myEndDate = new Date(picker.endDate);

        //計算小時
        var hour = Math.round((myEndDate - myStartDate) / (1000*60*60));
        $leave_spent_hours.val(hour);

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
      });
    }
  });