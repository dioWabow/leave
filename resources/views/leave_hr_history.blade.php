<div class="{{(Request::is('leaves_hr/history')) ? 'active' : ''}} tab-pane">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves_hr/history') }}" method="POST">
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
              <select id="search_leave_type" name="search[exception]" class="form-control">
                <option value="" selected="selected">全部</option>
                <option value="normal" @if (count($model->order_by) >0 && $model->exception == "normal") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('normal') }}</option>
                <option value="job_seek" @if (count($model->order_by) >0 && $model->exception == "job_seek") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('job_seek') }}</option>
                <option value="paid_sick" @if (count($model->order_by) >0 && $model->exception == "paid_sick") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('paid_sick') }}</option>
                <option value="sick" @if (count($model->order_by) >0 && $model->exception == "sick") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('sick') }}</option>
                <option value="entertain" @if (count($model->order_by) >0 && $model->exception == "entertain") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('entertain') }}</option>
                <option value="annual_leave" @if (count($model->order_by) >0 && $model->exception == "annual_leave") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('annaul_leave') }}</option>
                <option value="lone_stay" @if (count($model->order_by) >0 && $model->exception == "lone_stay") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('lone_stay') }}</option>
                <option value="birthday" @if (count($model->order_by) >0 && $model->exception == "birthday") selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('birthday') }}</option>
              </select>
              &nbsp;
              區間：
              <input type="text" id="search_daterange" name="search[daterange]" value="@if(!empty($model->start_time)) {{$model->start_time}} - {{$model->end_time}}@endif" class="form-control pull-right">
              </label>
              &nbsp;
              <label>
              狀態：
              <select id="search_tag_id" name="search[tag_id]" class="form-control">
                <option value="8,9" selected="selected">全部</option>
                <option value="8" @if (count($search)>2 && $search['tag_id'] == '8') selected="selected" @endif>不准假</option>
                <option value="9" @if (count($search)>2 && $search['tag_id'] == '9') selected="selected" @endif>已准假</option>
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
              <th width="5%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
              <th width="8%"><a href="javascript:void(0)" class="sort" sortname="type_id">假別</a></th>
              <th width="18%"><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
              <th width="30%"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
              <th width="8%">代理人</a></th>
              <th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
            </tr>
          </thead>
          <tbody>
           @foreach ($dataProvider as $value)
            <tr class="clickable-row" data-href="{{ route('leave/edit',[ 'id' => $value->id ]) }}">
              <td>
                <button type="button"
                  @if($value->tag_id == 8) class="btn bg-maroon"
                  @elseif($value->tag_id == 9) class="btn bg-navy"
                  @endif>
                  {{ WebHelper::getLeaveTagsLabelForHistory($value->tag_id) }}
                </button>
              </td>
            <td>
              <img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{$value->fetchUser->nickname}}" width="50px">
            </td>
            <td>{{ $value->fetchType->name }}</td>
            <td>{{ TimeHelper::changeViewTime($value->start_time, $value->end_time, $value->id) }}</td>
            <td>{{ $value->reason }}</td>
              <td>
                @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
                  <img src="{{ UrlHelper::getUserAvatarUrl($agent->fetchUser->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{$agent->fetchUser->nickname}}" width="50px">
                @endforeach
              </td>
              <td id="hours">{{ $value->hours }}</td>
            </tr>
            @endforeach
            @if(count($dataProvider) == 0)
            <tr class="">
              <td colspan="7" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <ul class="pagination">
          <li class="paginate_button previous disabled">
            {{ $dataProvider->links() }}
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>