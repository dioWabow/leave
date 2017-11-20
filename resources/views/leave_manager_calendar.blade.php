<div class="{{(Request::is('leaves_manager/calendar/*')) ? 'active' : ''}} tab-pane" id="calendar">
    <div id="calendar"></div>
    <input type="hidden" name="role" value="{{$getRole}}" id="role_input">
    <script>
  $(function () {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev, next, today',
        center: 'title',
        right: ''
      },
      displayEventEnd: {
        month: true
      },
      //Random default events
      events: function(start, end, timezone, callback) {
        $.ajax({
            url: '{{url("leaves_manager/calendar")}}',
            type: 'POST',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                "_token": "{{ csrf_token() }}",
                start: start.unix(),
                end: end.unix(),
                role: $('#role_input').val()
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

              $.each(data.holidies, function(index, value) {
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
</div>