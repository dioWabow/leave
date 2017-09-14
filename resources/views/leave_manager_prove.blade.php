<div class="{{(Request::is('leaves/manager/prove/*')) ? 'active' : ''}} tab-pane" id="prove">
  <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves_manager_prove', ['user_id' => Auth::user()->id, 'role' => $getRole ]) }}" method="POST">
    <div class="dataTables_wrapper form-inline dt-bootstrap">
        @if(count($model->order_by)>0)
          <input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
          <input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
        @else
          <input id="order_by" type="hidden" name="order_by[order_by]" value="">
          <input id="order_way" type="hidden" name="order_by[order_way]" value="">
        @endif
      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered table-striped table-hover" data-toggle-selector=".footable-toggle" data-show-toggle="false">
              <thead>
                <tr>
                  <th width="3%"><input id="checkall" type="checkbox" name="checkall" class="flat-red" value="all"></th>
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
              <tr class="clickable-row" data-href='leave_manager_view.html'>
                <td>
                  <input type="checkbox" name="check" class="flat-red check" value="">
                </td>
                  @foreach (App\User::getLeavesUserIdByUserId($value->user_id) as $user)
                    <td>
                      <img src="{{ UrlHelper::getUserAvatarUrl($user->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $user->nickname }}" width="50px">
                    </td>
                  @endforeach
                <td>{{$value->fetchType->name}}</td>
                <td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
                <td>{{ $value->reason }}</td>
                <td>
                  @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
                    <img src="{{ UrlHelper::getUserAvatarUrl($agent->fetchUser->avatar)}}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $agent->fetchUser->nickname }}" width="50px">
                  @endforeach
                </td>
                <td>{{ $value->hours }}</td>
                <td class="text-red">
                  {{ LeaveHelper::getDiffDaysLabel($value->start_time) }}
                </td>
                <td><span class="footable-toggle fooicon fooicon-plus"></span></td>
              </tr>
              @endforeach
              @if(count($dataProvider) == 0)
                <tr class="">
                  <td colspan="9" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
                </tr>
              @endif
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="input-group">
          <div class="input-group-addon">
            <i class="fa fa-commenting-o"></i>
          </div>
          <input type="text" id="leave_reason" name="leave[reason]" class="form-control pull-right" placeholder="請填寫原因(可不填）">
        </div>
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModalConfirm">不允許放假</button>
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">允許放假</button>
      </div>
    </div>
  </div>
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