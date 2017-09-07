	<!-- /.tab-pane -->
  <div class="{{Request::is('leaves/my/upcoming/*') ? 'active' : ''}} tab-pane" id="upcoming">
  <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves_my_upcoming', ['user_id' => 1 ]) }}" method="POST">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
     @if(count($model->order_by)>0)
        <input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
      @else
        <input id="order_by" type="hidden" name="order_by[order_by]" value="">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="">
      @endif
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th><a href="javascript:void(0)" class="sort" sortname="type_id">假別</a></th>
                <th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
                <th><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
                <th width="13%">代理人</a></th>
                <th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
                <th width="8%"></th>
              </tr>
            </thead>
             {!!csrf_field()!!}
            <tbody>
            </form>
            @foreach ($dataProvider as $value)
            <tr class='clickable-row' data-href='leave_manager_view.html'>
                @foreach (App\Type::getLeavesTypeIdByTypeId($value->type_id) as $type_id)
                  <td>{{$type_id->name}}</td>
                @endforeach
                <td>{{$value->start_time}} ~ {{$value->end_time}}</td>
                <td>{{$value->reason}}</td>
                <td>
                  @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
                    <img src="{{route('root_path')}}/storage/avatar/{{$agent->user->avatar}}?v={{rand(1,99)}}" class="img-circle" alt="{{$agent->user->nickname}}" width="50px">
                  @endforeach
                </td>
                <td>{{$value->hours}}</td>
                <td class="text-red">@if($today->gt(Carbon\Carbon::parse($value->start_time))) 放假囉 @else 倒數{{$today->diffInDays(Carbon\Carbon::parse($value->start_time))}}天 @endif</td>
              </tr>
                @endforeach
                @if(count($dataProvider) == 0)
                <tr class="">
                  <td colspan="6" align="center"><span class="glyphicon glyphicon-search"> 沒有相關結果</span></td>
                </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<!-- /.tab-pane -->
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