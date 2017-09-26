@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-github-alt"></i> 特休假單列表
  <small>Report Vacation List</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li><a href="{{ route('annual_report/index') }}">特休報表</a></li>
  <li class="active">特休假單列表</li>
  </ol>
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
                      <th width="8%">請假者</th>
                      <th><a href="javascript:void(0)" >假別</a></th>
                      <th><a href="javascript:void(0)" >時間</a></th>
                      <th><a href="javascript:void(0)">原因</a></th>
                      <th width="8%"><a href="javascript:void(0)">時數(HR)</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($dataProvider as $data)
                    <tr class='clickable-row' data-href='#'>
                      <td><img src="{{UrlHelper::getUserAvatarUrl($data->fetchUser->avatar)}}" class="img-circle" alt="{{$data->fetchUser->avatar}}" width="50px"></td>
                      <td>{{$data->fetchType->name}}</td>
                      <td>{{ Carbon\Carbon::parse($data->start_time)->format('Y-m-d H:i:s') }} ~ {{ Carbon\Carbon::parse($data->end_time)->format('Y-m-d H:i:s') }}</td>
                      <td>{{$data->reason}}</td>
                      <td>{{$data->hours}}</td>
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