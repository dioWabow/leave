@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-github-alt"></i> 特休假單列表(離職)
  <small>Leaved User Annual Leave List</small>
  </h1>
  {{ Breadcrumbs::render('leaved_user_annual_leave_calculate/view') }}
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-body">
          <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped table-hover">
                  <form name="vacationlist" id="vacation_list" action="{{ route('annual_leave_calculate/view',['id'=>$id,'year'=>$year])}}" method="POST">
                    <input type="hidden" name="year" value="{{$year}}">
                    <input type="hidden" name="user_id" value="{{$id}}">
                  </form>
                  <thead>
                    <tr>
                      <th width="8%"><a href="javascript:void(0)" >請假者</a></th>
                      <th><a href="javascript:void(0)" >假別</a></th>
                      <th><a href="javascript:void(0)" >時間</a></th>
                      <th><a href="javascript:void(0)">原因</a></th>
                      <th width="8%"><a href="javascript:void(0)">時數(HR)</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($dataProvider as $leave)
                    <tr class="clickable-row" data-href="{{ route('leaved_user_annual_leave_calculate/leave_detail', [ 'id' => $leave->id ]) }}">
                      <td><img src="{{UrlHelper::getUserAvatarUrl($leave->fetchUser->avatar)}}" class="img-circle" alt="{{$leave->fetchUser->avatar}}" width="50px"></td>
                      <td>{{$leave->fetchType->name}}</td>
                      <td>{{ TimeHelper::changeViewTime($leave->start_time, $leave->end_time, $leave->user_id) }}</td>
                      <td>{{$leave->reason}}</td>
                      <td>{{$leave->hours}}</td>
                    </tr>
                    @empty
                      <tr class="">
                        <td colspan="4" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
                      </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
@stop