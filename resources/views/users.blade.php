@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-users"></i> 員工管理
  <small>Staff Management</small>
  </h1>
  {{ Breadcrumbs::render('user') }}
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-body">
          <div class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
              <div class="col-sm-3">
                <div class="dataTables_length">
                    <form name="frmSearch" id="frmSearch" action="{{route('user/index')}}" method="POST">
                    <input id="order_by" type="hidden" name="order_by[order_by]" value="{{$model->order_by}}">
                    <input id="order_way" type="hidden" name="order_by[order_way]" value="{{$model->order_way}}">
                    
                    {!!csrf_field()!!}
                  <label>
                    每頁 
                    <select name="order_by[pagesize]" class="form-control input-sm" onchange="javascript:changePageSize(this.value);">
                      <option value="25"@if($model->pagesize=="25")selected="selected"@endif>25</option>
                      <option value="50"@if($model->pagesize=="50")selected="selected"@endif>50</option>
                      <option value="100"@if($model->pagesize=="100")selected="selected"@endif>100</option>
                    </select> 
                  筆</label>
                  </div>
                </div>
                <div class="col-sm-9">
                    <div class="pull-right">
                      <label>
                        團隊：
                        <select id="search_teams" name="search[teams]" class="form-control">
                          <option value="" selected="selected">全部</option>
                          @foreach($teams as $team)
                          <option value="{{$team->id}}" @if(count($search)>0 && $search['teams']==$team->id) selected="selected" @endif>{{$team->name}}</option>
                          @endforeach
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        狀態：
                        <select name="search[status]" class="form-control">
                          <option value="" selected="selected">全部員工</option>
                          <option value="1" @if(count($search)>0 && $search['status']==="1") selected="selected" @endif>在職員工</option>
                          <option value="0" @if(count($search)>0 && $search['status']==="0") selected="selected" @endif>離職員工</option>
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        關鍵字：
                        <input type="search" class="form-control" placeholder="請輸入員編、英文名、中文名進行查詢" name="search[keywords]" style="width:270px" value="@if(count($search)>0){{$search['keywords']}}@endif">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      </label>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <table class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th width="3%"></th>
                        <th width="5%"><a href="javascript:void(0)" onclick="changeSort('employee_no');">編號</a></th>
                        <th><a href="javascript:void(0)" onclick="changeSort('nickname');">稱呼</a></th>
                        <th><a href="javascript:void(0)" onclick="changeSort('name');">姓名</a></th>
                        <th width="8%"><a href="javascript:void(0)" onclick="changeSort('birthday');">生日</a></th>
                        <th width="8%"><a href="javascript:void(0)" onclick="changeSort('enter_date');">到職日</a></th>
                        <th width="8%"><a href="javascript:void(0)" onclick="changeSort('leave_date');">離職日</a></th>
                        <th width="8%"><a href="javascript:void(0)" onclick="changeSort('arrive_time');">上班時間</a></th>
                        <th width="11%">代理人</th>
                        <th width="10%">團隊</th>
                        <th width="4%"><a href="javascript:void(0)" onclick="changeSort('status');">狀態</a></th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($dataProvider as $user)
                      <tr class='clickable-row' data-href="{{ route('user/edit', ['id'=>$user->id]) }}">
                        <td align="center"><img src="{{UrlHelper::getUserAvatarUrl($user->avatar)}}" class="img-circle" alt="{{$user->nickname}}" width="50px"></td>
                        <td align="center">
                          <div>{{$user->employee_no}}</div>
                          <div>
                            <small class="label bg-red">
                              {{UserHelper::getRoleByUserId($user->id)}}
                            </small>
                          </div>
                        </td>
                        <td>{{$user->nickname}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->birthday}}</td>
                        <td>{{date('Y-m-d', strtotime($user->enter_date))}}</td>
                        <td>
                          @if ($user->leave_date == "")
                            -
                          @else
                            {{date('Y-m-d', strtotime($user->leave_date))}}
                          @endif
                        </td>
                        <td>
                          @if ($user->arrive_time == "0900")
                            09:00 - 18:00
                          @else
                            09:30 - 18:30
                          @endif
                        </td>
                        <td>
                          @foreach (App\UserAgent::getUserAgentByUserId($user->id) as $agent)
                            @if($agent->fetchUser->status == 1)
                            <img src="{{UrlHelper::getUserAvatarUrl($agent->fetchUser->avatar)}}" class="img-circle" alt="{{$agent->fetchUser->avatar}}" width="50px">
                            @endif
                          @endforeach
                        </td>
                        <td>
                          @foreach (App\UserTeam::getUserTeamByUserId($user->id) as $user_team)
                            @if(!empty($user_team->fetchTeam))
                              <small class="label" style="background-color:{{$user_team->fetchTeam->color}};">{{$user_team->fetchTeam->name}}</small>
                            @endif
                          @endforeach
                        </td>
                        <td align="center">
                          @if ($user->status == "1")
                            <small class="badge bg-green" title="在職中">on</small>
                          @else
                            <small class="badge bg-dark" title="已離職">OFF</small>
                          @endif
                        </td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="11" align="center">無資料</td>
                        </tr>
                      @endforelse

                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row">
                {{ $dataProvider->links() }}
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</section>
  <!-- /.content-wrapper -->

  <!-- Page script -->


@stop
