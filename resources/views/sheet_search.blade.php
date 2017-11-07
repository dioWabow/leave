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
                          <option value="" selected="selected">全部</option>
                          @if( !empty($allow_users) )
                          @foreach($allow_users as $allow_user)
                          <option value="{{$allow_user->fetchUser->id}}" @if(!empty($search['allow_user']) && $search['allow_user']==$allow_user->fetchUser->id) selected="selected" @endif >{{$allow_user->fetchUser->name}}</option>
                          @endforeach
                          @endif
                          <option value="{{Auth::user()->id}}" @if(!empty($search['allow_user']) && $search['allow_user']==Auth::user()->id) selected="selected" @endif >{{Auth::user()->name}}</option>
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
                        @if(1!=1)
                          @if(!empty($model->start_time)){{$model->start_time}} - {{$model->end_time}}
                          @endif
                        @endif
                        <input type="text" id="search_daterange" placeholder="請選擇時間區間" name="search[daterange]" value="@if(!empty($model->start_time)){{$model->start_time}} - {{$model->end_time}} @endif"  class="form-control">
                      </label>
                      &nbsp;
                      <label>
                        關鍵字：
                        <input type="search" class="form-control" id="search_text" name="search[text]" placeholder="請輸入標籤、標題、內容、備註" style="width:270px" value="">
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
                        <th width="3%" align="center"><a href="javascript:void(0)" class="sort" sortname="user_id">填寫人</a></th>
                        <th width="5%"><a href="javascript:void(0)" class="sort" sortname="working_day"> 日期</a></th>
                        <th  width="5%"><a href="javascript:void(0)" class="sort" sortname="project_id">專案</a></th>
                        <th width="15%"><a href="javascript:void(0)" class="sort" sortname="items">標題</a></th>
                        <th  width="15%"><a href="javascript:void(0)" class="sort" sortname="tag">標籤</a></th>
                        <th width="30%"><a href="javascript:void(0)" class="sort" sortname="description">內容</a></th>
                        <th width="4%"><a href="javascript:void(0)" class="sort" sortname="hour">時數</a></th>
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
</section>
  <!-- /.content-wrapper -->

  <!-- Page script -->
@stop
