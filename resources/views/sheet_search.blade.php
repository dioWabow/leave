@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-search"></i> 搜尋
  <small>Search</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">搜尋</li>
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
              <div class="col-sm-3">
                <div class="dataTables_length">
                    <form name="frmSearch" id="frmSearch" action="{{route('user/index')}}" method="POST">
                    @if(1!=1)
                    <input id="order_by" type="hidden" name="order_by[order_by]" value="{{$model->order_by}}">
                    <input id="order_way" type="hidden" name="order_by[order_way]" value="{{$model->order_way}}">
                    @endif
                    
                    {!!csrf_field()!!}
                  <label>
                    每頁 
                    <select name="order_by[pagesize]" class="form-control input-sm" onchange="javascript:changePageSize(this.value);">
                      <option value="25"selected="selected">25</option>
                      @if(1!=1)
                      <option value="25"@if($model->pagesize=="25")selected="selected"@endif>25</option>
                      <option value="50"@if($model->pagesize=="50")selected="selected"@endif>50</option>
                      <option value="100"@if($model->pagesize=="100")selected="selected"@endif>100</option>
                      @endif
                    </select> 
                  筆</label>
                  </div>
                </div>
                <div class="col-sm-9">
                    <div class="pull-right">
                      <label>
                        填寫人：
                        <select id="search_teams" name="search[teams]" class="form-control">
                          <option value="" selected="selected">全部</option>
                          <option value="">Tony</option>
                          <option value="">Dio</option>
                          <option value="">Carrie</option>
                          @if(1!=1)
                          @foreach($teams as $team)
                          <option value="{{$team->id}}" @if(count($search)>0 && $search['teams']==$team->id) selected="selected" @endif>{{$team->name}}</option>
                          @endforeach
                          @endif
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        專案：
                        <select id="search_teams" name="search[teams]" class="form-control">
                          <option value="" selected="selected">全部</option>
                          <option value="">Washop</option>
                          @if(1!=1)
                          @foreach($teams as $team)
                          <option value="{{$team->id}}" @if(count($search)>0 && $search['teams']==$team->id) selected="selected" @endif>{{$team->name}}</option>
                          @endforeach
                          @endif
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        區間：
                        @if(1!=1)
                          @if(!empty($model->start_time)){{$model->start_time}} - {{$model->end_time}}
                          @endif
                        @endif
                        <input type="text" id="search_daterange" placeholder="請選擇時間區間" name="search[daterange]" value=""  class="form-control">
                      </label>
                      &nbsp;
                      <label>
                        關鍵字：
                        <input type="search" class="form-control" placeholder="請輸入標籤、標題、內容、備註" style="width:270px" value="">
                        @if(1!=1)
                        <input type="search" class="form-control" placeholder="請輸入標籤、標題、內容、備註" name="search[keywords]" style="width:270px" value="@if(count($search)>0){{$search['keywords']}}@endif">
                        @endif
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
                      <tr >
                        <th width="3%" align="center"><a href="javascript:void(0)" onclick="changeSort('employee_no');">填寫人</a></th>
                        <th  width="5%"><a href="javascript:void(0)" onclick="changeSort('nickname');">專案</a></th>
                        <th width="15%"><a href="javascript:void(0)" onclick="changeSort('name');">標題</a></th>
                        <th  width="15%"><a href="javascript:void(0)" onclick="changeSort('name');">標籤</a></th>
                        <th width="25%"><a href="javascript:void(0)" onclick="changeSort('birthday');">內容</a></th>
                        <th width="4%"><a href="javascript:void(0)" onclick="changeSort('enter_date');">時數</a></th>
                        <th width="10%"><a href="javascript:void(0)" onclick="changeSort('leave_date');"> 備註</a></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class='clickable-row' data-href="">
                        <td align="center"><img src="{{UrlHelper::getUserAvatarUrl('Tony.jpg')}}" class="img-circle" alt="Tony" width="50px"></td>
                        <td>Washop</td>
                        <td>Eip請假系統</td>
                        <td><small class="label" style="background-color:#3C8DBC;">麵包屑</small>&nbsp;<small class="label" style="background-color:#3C8DBC;">class</small></td>
                        <td>修正麵包屑套件merge回develop之後會發生抓不到class的問題，原因為class被快取了，所以要清掉快取讓他重抓就好，已修正</td>
                        <td>3</td>
                        <td>不知道打什麼QQ</td>
                      </tr>
                      <tr class='clickable-row' data-href="">
                        <td align="center"><img src="{{UrlHelper::getUserAvatarUrl('Tony.jpg')}}" class="img-circle" alt="Tony" width="50px"></td>
                        <td>Washop</td>
                        <td>Eip工作日誌</td>
                        <td><small class="label" style="background-color:#3C8DBC;">權限皮</small>&nbsp;<small class="label" style="background-color:#3C8DBC;">搜尋皮</small></td>
                        <td>做搜尋跟權限頁面的皮，昨天討論之後的修改</td>
                        <td>3</td>
                        <td>備註...嗯...</td>
                      </tr>
                      @if(1!=1)
                      @forelse($test as $test1)
                      <tr class='clickable-row' data-href="{{ route('user/edit', ['id'=>$user->id]) }}">
                        <td align="center"><img src="{{UrlHelper::getUserAvatarUrl($user->avatar)}}" class="img-circle" alt="{{$user->nickname}}" width="50px"></td>
                        <td align="center">
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="center"></td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
                        </tr>
                      @endforelse
                      @endif
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
  <!-- /.content-wrapper -->

  <!-- Page script -->
@stop
