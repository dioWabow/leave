@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar"></i> 我的請假單
	<small>My Leave List</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">我的請假單</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active"><a href="#prove" data-toggle="tab"  onclick="location.href='{{ route('leave', ['user_id' => 1 , 'tag' => '1,2,3,4,5' ]) }}#prove'">等待核准<span data-toggle="tooltip" title="" class="badge bg-red" data-original-title="3 New Messages">4</span></a></li>
					<li><a href="#upcoming" data-toggle="tab" onclick="location.href='{{ route('leave', ['user_id' => 1 , 'tag' => '6,7']) }}#upcoming'">即將放假 <span data-toggle="tooltip" title="" class="badge bg-green" data-original-title="3 New Messages">3</span></a></li>
					<li><a href="#list" data-toggle="tab" onclick="location.href='{{ route('leave', ['user_id' => 1 , 'tag' => '0,1,2,3,4,5,6,7']) }}#list'">歷史紀錄</a></li>
				</ul>
				<div class="tab-content">
					<!-- /.tab-pane -->
					<div class="active tab-pane" id="prove">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
                                <form name="frmOrderby" id="frmOrderby" action="{{ route('search',  ['user_id'=>$model->user_id] )}}" method="POST">
                                	@if(count($model->order_by)>0)
											<input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
											<input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
									@else
											<input id="order_by" type="hidden" name="order_by[order_by]" value="">
											<input id="order_way" type="hidden" name="order_by[order_way]" value="">
									@endif
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="14%"><a onclick="changeSort('tag_id');">狀態</a></th>
												<th><a onclick="changeSort('type_id');">假別</a></th>
												<th><a onclick="changeSort('start_time');">時間</a></th>
												<th><a onclick="changeSort('reason');">原因</a></th>
												<th width="13%">代理人</a></th>
												<th width="8%"><a onclick="changeSort('hours');">時數(HR)</a></th>
												<th width="8%"></th>
											</tr>
										</thead>
                                        {!!csrf_field()!!}
									</form>
										<tbody>
                                        @foreach ($dataProvider as $value)
											<tr class='clickable-row' data-href="leave_manager_view.html">
												<td>
                                                    @foreach (App\Tag::getLeavesTagIdByTagId($value->tag_id) as $tag)
													<button id="tag_button" type="button" class="btn bg-blue">
                                                        {{$tag->name}}
                                                    </button>
                                                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o"></i></button>
                                                    @endforeach
												</td>
                                                
                                                @foreach (App\Type::getLeavesTypeIdByTypeId($value->type_id) as $type_id)
                                                <td>{{$type_id->name}}</td>
                                                @endforeach
												<td>{{ $value->start_time }} ~ {{ $value->end_time }}</td>
												<td>{{ $value->reason }}</td>
                                                @foreach (App\UserAgent::getUserAgentByUserId($value->user_id) as $agent)
												<td>
													<img src="{{route('root_path')}}/storage/avatar/{{$agent->user->avatar}}" class="img-circle" alt="{{$agent->agent_id}}" width="50px">
												</td>
                                                @endforeach
												<td>{{ $value->hours }}</td>
												<td class="text-red">倒數1天</td>
											</tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->

					<!-- /.tab-pane -->
					<div class="tab-pane" id="upcoming">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th><a onclick="changeSort('type_id');">假別</a></th>
												<th><a onclick="changeSort('start_time');">時間</a></th>
												<th><a onclick="changeSort('reason');">原因</a></th>
												<th width="13%">代理人</a></th>
												<th width="8%"><a onclick="changeSort('hours');">時數(HR)</a></th>
												<th width="8%"></th>
											</tr>
										</thead>
										<tbody>
                                        @foreach ($dataProvider as $value)
											<tr class='clickable-row' data-href='leave_manager_view.html'>
                                                @foreach (App\Type::getLeavesTypeIdByTypeId($value->type_id) as $type_id)
                                                <td>{{$type_id->name}}</td>
                                                @endforeach
												<td>{{$value->start_time}} ~ {{$value->end_time}}</td>
												<td>{{$value->reason}}</td>
												@foreach (App\UserAgent::getUserAgentByUserId($value->user_id) as $agent)
												<td>
													<img src="{{route('root_path')}}/storage/avatar/{{$agent->user->avatar}}" class="img-circle" alt="{{$agent->agent_id}}" width="50px">
												</td>
                                                @endforeach
												<td>{{$value->hours}}</td>
												<td class="text-red">倒數1天</td>
											</tr>
                                        @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /.tab-pane -->

					<!-- /.tab-pane -->
					<div class="tab-pane" id="list">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<form name="frmSetting" action="{{ route('search', ['user_id' => $model->user_id ]) }}" method="POST">
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
												<select id="search_leave_type" name="search[leave_type]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="1">一般</option>
													<option value="2">謀職假</option>
													<option value="3">無薪病假</option>
													<option value="4">善待假</option>
													<option value="5">特休</option>
													<option value="6">久任假</option>
													<option value="7">生日假</option>
												</select>
												&nbsp;
												區間：
												<input type="text" id="search_daterange" name="search[daterange]" class="form-control pull-right">
												</label>
												&nbsp;
												<label>
												狀態：
												<select id="search_tag_id" name="search[tag_id]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="0">已取消</option>
													<option value="2">不准假</option>
													<option value="1">已准假</option>
												</select>
											</label>
											&nbsp;
											<label>
												<button type="submit" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button>
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
												<th width="3%"><a onclick="changeSort('tag_id');">狀態</a></th>
												<th><a onclick="changeSort('type_id');">假別</a></th>
												<th><a onclick="changeSort('start_time');">時間</a></th>
												<th><a onclick="changeSort('reason');">原因</a></th>
												<th width="13%">職代</a></th>
												<th width="9%"><a onclick="changeSort('hours');">時數(HR)</a></th>
											</tr>
										</thead>
										<tbody>
                                         @foreach ($dataProvider as $value)
											<tr class='clickable-row' data-href='leave_view.html'>
                                                 @foreach (App\Tag::getLeavesTagIdByTagId($value->tag_id) as $tag_id)
												<td>
													<button type="button" class="btn bg-navy">
                                                        {{$tag_id->name}}
                                                    </button>
												</td>
                                                @endforeach
                                                @foreach (App\Type::getLeavesTypeIdByTypeId($value->type_id) as $type_id)
                                                <td>{{$type_id->name}}</td>
                                                @endforeach
												<td>
												<td>{{$value->reason}}</td>
												@foreach (App\UserAgent::getUserAgentByUserId($value->user_id) as $agent)
												<td>
													<img src="{{route('root_path')}}/storage/avatar/{{$agent->user->avatar}}" class="img-circle" alt="{{$agent->agent_id}}" width="50px">
												</td>
                                                @endforeach
												<td id="hours">{{$value->hours}}</td>
											</tr>
                                        @endforeach
										</tbody>
										<tfotter>
											<tr class="text-red">
												<th></th>
												<th></th>
												<th></th>
												<th></th>
												<th class="pull-right">總計(Hr)</th>
												<th class="vTotal">87</th>
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
					<!-- /.tab-pane -->

				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
<script>
function changePageSize(pagesize)
{
    $("#frmOrderby").submit();
}

function changeSort(sort)
{
	order_by = "{{ $model->order_by }}";
	order_way = "{{ $model->order_way }}";

	$("#order_by").val(sort);

	if (order_by == sort && order_way == "DESC") {
			$("#order_way").val("ASC");
	} else {
			$("#order_way").val("DESC");
	}

	$("#frmOrderby").submit();
}

function ShowValue(id){                               
    var v = document.getElementById("hours").value ;
    alert(v);
}


$('#myTab a').click(function(e) {
  e.preventDefault();
  $(this).tab('show');
});

// store the currently selected tab in the hash value
$("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
  var id = $(e.target).attr("href").substr(1);
  window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');
</script>
@stop
