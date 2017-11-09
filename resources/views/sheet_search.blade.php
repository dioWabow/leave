@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-search"></i> 搜尋
  <small>Search</small>
  </h1>
  {{ Breadcrumbs::render('sheet/search/index') }}
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
                    <form name="frmSearch" id="frmSearch" action="{{route('sheet/search/index')}}" method="POST">
                    @if(1!=1)
                    <input id="order_by" type="hidden" name="order_by[order_by]" value="{{$model->order_by}}">
                    <input id="order_way" type="hidden" name="order_by[order_way]" value="{{$model->order_way}}">
                    @endif
                    
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
                        填寫人：
                        <select id="search_user_id" name="search[user_id]" class="form-control">
                          <option value="">全部</option>
                          @if( !empty($allow_users) )
                          @foreach($allow_users as $allow_user)
                          <option value="{{$allow_user->fetchUser->id}}" @if(!empty($search['user_id']) && $search['user_id']==$allow_user->fetchUser->id) selected="selected" @endif >{{$allow_user->fetchUser->nickname}}</option>
                          @endforeach
                          @endif
                          <option value="{{Auth::user()->id}}" @if(!empty($search['user_id']) && $search['user_id']==Auth::user()->id) selected="selected" @endif >{{Auth::user()->nickname}}</option>
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        專案：
                        <select id="search_project_id" name="search[project_id]" class="form-control">
                          <option value="" selected="selected">全部</option>
                          @if( !empty($projects) )
                          @foreach($projects as $project)
                          <option value="{{$project->fetchProject->id}}" @if(count($search)>0 && $search['project_id']==$project->fetchProject->id) selected="selected" @endif>{{$project->fetchProject->name}}</option>
                          @endforeach
                          @endif
                        </select>
                      </label>
                      &nbsp;
                      <label>
                        區間：
                        <input type="text" id="search_daterange" placeholder="請選擇時間區間" name="search[daterange]" value="@if(!empty($search['daterange'])){{$search['start_time']}} - {{$search['end_time']}} @endif"  class="form-control">
                      </label>
                      &nbsp;
                      <label>
                        關鍵字：
                        <input type="search" class="form-control" placeholder="請輸入標籤、標題、內容、備註" name="search[text]" style="width:270px" value="@if(count($search)>0) {{$search['text']}} @endif">
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
                        <th width="3%" align="center">填寫人</th>
                        <th width="5%">日期</th>
                        <th width="5%">專案</th>
                        <th width="15%">標題</th>
                        <th width="15%">標籤</th>
                        <th width="30%">內容</th>
                        <th width="4%">時數</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse ($dataProvider as $value)
                      <tr class='clickable-row' data-href="">
                        <td align="center"><img src="{{UrlHelper::getUserAvatarUrl($value->fetchUser->avatar)}}" class="img-circle" alt="Tony" width="50px">{{$value->fetchUser->name}}</td>
                        <td>{{$value->working_day}}</td>
                        <td>{{$value->fetchProject->name}}</td>
                        <td>{{$value->items}}</td>
                        <td>
                          @foreach ($value->tag as $tag_one)
                           <small class="label" style="background-color:#3C8DBC;">{{$tag_one}}</small> 
                          @endforeach 
                        </td>
                        <td>{{$value->description}}</td>
                        <td>{{$value->hour}}</td>
                      </tr>
                      @empty
                        <tr>
                          <td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
      </div>
      @if (!empty($dataProvider) )
      <div class="row">
        <div class="col-sm-12">
          <ul class="pagination">
            <li class="paginate_button previous disabled">
              {{ $dataProvider->links() }}
            </li>
          </ul>
        </div>
      </div>
      @endif
    </div>
  </div>
</section>
  <!-- /.content-wrapper -->

  <!-- Page script -->
@stop
