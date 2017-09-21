<div class="{{Request::is('leaves/manager/history/*') ? 'active' : ''}} tab-pane" id="list">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves/manager/history', [ 'role' => $getRole ]) }}" method="POST">
      @if(count($model->order_by)>0)
        <input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
      @else
        <input id="order_by" type="hidden" name="order_by[order_by]" value="">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="">
      @endif
      <div class="row">
        <div class="col-sm-3">
          <div class="dataTables_length">
            <label>
              每頁
              <select name="order_by[pagesize]" class="form-control input-sm" onchange="changePageSize(this.value);">
                <option value="25"@if(count($model->order_by) >0 && $model->pagesize == "25") selected="selected" @endif>25</option>
                  <option value="50"@if(count($model->order_by) >0 && $model->pagesize == "50") selected="selected" @endif>50</option>
                  <option value="100"@if(count($model->order_by) >0 && $model->pagesize == "100") selected="selected" @endif>100</option>
              </select>
            筆</label>
          </div>
        </div>
        <div class="col-sm-9">
          <div class="pull-right">
            <label>
              假別：
              <select id="search_leave_type" name="search[type_id]" class="form-control">
                <option value="" selected="selected">全部</option>
                <option value="normal" @if (count($search)>2 && $search['type_id'] == 'normal') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('normal') }}</option>
                <option value="job_seek" @if (count($search)>2 && $search['type_id'] == 'job_seek') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('job_seek') }}</option>
                <option value="paid_sick" @if (count($search)>2 && $search['type_id'] == 'paid_sick') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('paid_sick') }}</option>
                <option value="sick" @if (count($search)>2 && $search['type_id'] == 'sick') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('sick') }}</option>
                <option value="entertain" @if (count($search)>2 && $search['type_id'] == 'entertain') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('entertain') }}</option>
                <option value="annaul_leave" @if (count($search)>2 && $search['type_id'] == 'annaul_leave') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('annaul_leave') }}</option>
                <option value="lone_stay" @if (count($search)>2 && $search['type_id'] == 'lone_stay') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('lone_stay') }}</option>
                <option value="birthday" @if (count($search)>2 && $search['type_id'] == 'birthday') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('birthday') }}</option>
              </select>
              &nbsp;
              區間：
              <input type="text" id="search_daterange" name="search[daterange]" class="form-control pull-right">
              </label>
              &nbsp;
              <label>
              狀態：
              <select id="search_tag_id" name="search[tag_id]" class="form-control">
                <option value="8,9" selected="selected">全部</option>
                <option value="8" @if (count($search)>0 && $search['tag_id'] == '8') selected="selected" @endif>不准假</option>
                <option value="9" @if (count($search)>0 && $search['tag_id'] == '9') selected="selected" @endif>已准假</option>
              </select>
            </label>
            &nbsp;
            <label>
              <button type="submit" name="search_btn" class="btn btn-default"><i class="fa fa-search"></i></button>
            </label>
            &nbsp;
          </div>
        </div>
      </div>
      {!!csrf_field()!!}
    </form>
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-bordered table-striped table-hover">
          <thead>
            <tr>
              <th width="3%"><a href="javascript:void(0)" class="sort" sortname="tag_id">狀態</a></th>
              <th><a href="javascript:void(0)" class="sort" sortname="type_id">假別</a></th>
              <th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
              <th width="25%"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
              <th width="16%">代理人</a></th>
              <th width="9%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
            </tr>
          </thead>
          <tbody>
          @foreach ($dataProvider as $value)
            <tr class="clickable-row" data-href="leave_view.html" @if ($value->tag_id == 7) style="text-decoration:line-through" @endif>
              <td>
                <button type="button"
                  @if($value->tag_id == 8) class="btn bg-maroon"
                  @elseif($value->tag_id == 9) class="btn bg-navy"
                  @endif>
                  {{ WebHelper::getLeaveTagsLabelForHistory($value->tag_id) }}
                </button>
              </td>
              @foreach (App\User::getLeavesUserIdByUserId($value->user_id) as $user)
                <td>
                  <img src="{{ UrlHelper::getUserAvatarUrl($user->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $user->nickname }}" width="50px">
                </td>
              @endforeach
              <td>{{ $value->fetchType->name }}</td>
              <td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
              <td>{{ $value->reason }}</td>
              <td>
                @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
                  <img src="{{ UrlHelper::getUserAvatarUrl($agent->fetchUser->avatar)}}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $agent->fetchUser->nickname }}" width="50px">
                @endforeach
              </td>
              <td id="hours">{{ $value->hours }}</td>
            </tr>
            @endforeach
            @if(count($dataProvider) == 0)
            <tr class="">
              <td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
            </tr>
            @endif
          </tbody>
          <tfotter>
            <tr class="text-red">
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th class="pull-right">總計(Hr)</th>
              <th>{{ $leaves_totle_hours }}</th>
            </tr>
          </tfotter>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <ul class="pagination">
          <li class="paginate_button previous disabled">
            <li>
              {{ $dataProvider->links() }}
            </li>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
<script>
$('.sort').on('click', function() {

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

function changePageSize(pagesize)
{
  $("#frmOrderby").submit();
}
</script>