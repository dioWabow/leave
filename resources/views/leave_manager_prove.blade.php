<div class="{{(Request::is('leaves_manager/prove/*')) ? 'active' : ''}} tab-pane" id="prove">
  <div class="dataTables_wrapper form-inline dt-bootstrap">
    <form name="frmOrderby" id="frmOrderby" action="{{ route('leaves_manager/prove', ['role' => $getRole ]) }}" method="POST">
      @if(count($model->order_by)>0)
        <input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
      @else
        <input id="order_by" type="hidden" name="order_by[order_by]" value="">
        <input id="order_way" type="hidden" name="order_by[order_way]" value="">
      @endif
      {!!csrf_field()!!}
    </form>
    <form name="frmSetting" id="frmSetting" action="{{ route('leaves_manager/insert', ['role' => $getRole ]) }}" method="POST">
      <div class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">
          <div class="col-sm-12">
            <table class="table table-bordered table-striped table-hover" data-toggle-selector=".footable-toggle" data-show-toggle="false">
              <thead>
                <tr>
                  <th width="3%"><input id="checkall" type="checkbox" name="checkall" class="flat-red" value=""></th>
                  <th width="5%"><a href="javascript:void(0)" class="sort" sortname="user_id">請假者</a></th>
                  <th data-breakpoints="xs sm"><a href="javascript:void(0)" class="sort" sortname="type_id">假別</a></th>
                  <th><a href="javascript:void(0)" class="sort" sortname="start_time">時間</a></th>
                  <th width="25%" data-breakpoints="xs sm"><a href="javascript:void(0)" class="sort" sortname="reason">原因</a></th>
                  <th width="16%" data-breakpoints="xs sm">代理人</a></th>
                  <th width="8%"><a href="javascript:void(0)" class="sort" sortname="hours">時數(HR)</a></th>
                  <th width="8%" data-breakpoints="xs sm"></th>
                </tr>
              </thead>
            <tbody>
              @foreach ($dataProvider as $value)
              <tr class="clickable-row" data-href="{{ route('leave/edit', [ 'id' => $value->id ]) }}">
                <td>
                  <input type="checkbox" name="leave[leave_id][]" class="flat-red check" value="{{ $value->id }}">
                </td>
                  @foreach (App\User::getLeavesUserIdByUserId($value->user_id) as $user)
                    <td>
                      <img src="{{ UrlHelper::getUserAvatarUrl($user->avatar) }}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $user->nickname }}" width="50px">
                    </td>
                  @endforeach
                <td>{{ $value->fetchType->name }}</td>
                <td>{{ TimeHelper::changeViewTime($value->start_time, $value->end_time, $value->id) }}</td>
                <td>{{ $value->reason }}</td>
                <td>
                  @foreach (App\LeaveAgent::getLeaveIdByAgentId($value->id) as $agent)
                    <img src="{{ UrlHelper::getUserAvatarUrl($agent->fetchUser->avatar)}}?v={{ rand(1,99) }}" class="img-circle" alt="{{ $agent->fetchUser->nickname }}" width="50px">
                  @endforeach
                </td>
                <td>{{ $value->hours }}</td>
                <td @if ( LeaveHelper::getDiffDaysLabel($value->start_time) <= 1)class="text-red" @else class="text-black" @endif>
                  @if ($value->start_time > Carbon\Carbon::now()) 倒數{{ LeaveHelper::getDiffDaysLabel($value->start_time) }}天 @endif
                </td>
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
          <input type="text" id="leave_reason" name="leave[memo]" class="form-control pull-right" placeholder="請填寫原因(可不填）">
        </div>
        <button type="button" class="btn btn-danger" id="disagree" data-toggle="modal" data-target="#myModalConfirm">不允許放假</button>
        <button type="button" class="btn btn-info" id="agree" data-toggle="modal" data-target="#myModalConfirm">允許放假</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body change-body-text">
      <!--文字寫變換在head_css內-->
        <h1></h1>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="btn_agree" name="leave[agree]" value="1">
{!!csrf_field()!!}
</form>