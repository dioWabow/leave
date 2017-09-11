<div class="{{(Request::is('leaves/manager/upcoming/*')) ? 'active' : ''}} tab-pane" id="upcoming">
  <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves_manager_upcoming', ['user_id' => 1 ]) }}" method="POST">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
      @if(count($model->order_by)>0)
          <input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
          <input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
        @else
          <input id="order_by" type="hidden" name="order_by[order_by]" value="">
          <input id="order_way" type="hidden" name="order_by[order_way]" value="">
        @endif
      <table class="table table-bordered table-striped table-hover"  data-toggle-selector=".footable-toggle" data-show-toggle="false">
        <thead>
          <tr>
            <th width="3%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
            <th data-breakpoints="xs sm"><a href="javascript:void(0)" class="sort" sortname="type_id">假別</a></th>
            <th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
            <th data-breakpoints="xs sm"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
            <th width="3%" data-breakpoints="xs sm">代理人</a></th>
            <th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
            <th width="8%" data-breakpoints="xs sm"></th>
            <th data-breakpoints="lg md"></th>
          </tr>
        </thead>
        {!!csrf_field()!!}
    </form>
    <tbody>
      @foreach ($dataProvider as $value)
        <tr class='clickable-row' data-href='leave_manager_view.html'>
          @foreach (App\User::getLeavesUserIdByUserId($value->user_id) as $user)
            <td><img src="{{ UrlHelper::getUserAvatarUrl($user->avatar)}}?v={{rand(1,99)}}" class="img-circle" alt="{{$user->nickname}}" width="50px"></td>
          @endforeach
          <td>{{$value->type->name}}</td>
          <td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
          <td>{{ $value->reason }}</td>
          <td>
          @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
            <img src="{{UrlHelper::getUserAvatarUrl($agent->user->avatar)}}?v={{rand(1,99)}}" class="img-circle" alt="{{$agent->user->nickname}}" width="50px">
          @endforeach
          </td>
          <td>{{ $value->hours }}</td>
          <td class="text-red">
            {{ LeaveHelper::getDiffDaysLabel($value->start_time) }}
          </td>
          <td><span class="footable-toggle fooicon fooicon-plus"></span></td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
<script>
$('.sort').on('click', function(){
	var $sortname = $(this).attr('sortname');
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
</script>