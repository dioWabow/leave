
@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 假別管理
	<small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li class="active">假別管理</li>
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
									<label>
										每頁
                                        <select name="search_page" onchange="search_page(this.value)" class="form-control input-sm">
                                            <option value="#">請選擇</option>
                                            <option value="1"@if($pageSize=="1")selected="selected"@endif>25</option>
                                            <option value="2"@if($pageSize=="2")selected="selected"@endif>50</option>
                                            <option value="3"@if($pageSize=="3")selected="selected"@endif>100</option>
                                        </select>
									    筆</label>
									</div>
								</div>
								<div class="col-sm-9">
                                <form name="frmSearch" action="{{ route('search') }}" method="POST">
                                <input id="sort" type="hidden" name="search['sort']" value="{{$order_by}}">
                                <input id="sort_way" type="hidden" name="search['sort_way']" value="{{$order_way}}">
										<div class="pull-right">
											<label>
												形式：
												<select id="search_type" name="search[reset_time]"  class="form-control">
													<option value="all" selected="selected">全部</option>
													<option value="none" @if ($search['reset_time'] == 'none') selected="selected" @endif >不重置</option>
													<option value="week" @if ($search['reset_time'] == 'week') selected="selected" @endif>每週重置</option>
													<option value="month" @if ($search['reset_time'] == 'month') selected="selected" @endif>每月重置</option>
													<option value="season" @if ($search['reset_time'] == 'season') selected="selected" @endif>每季重置</option>
													<option value="year" @if ($search['reset_time'] == 'year') selected="selected" @endif>每年重置</option>
													<option value="other" @if ($search['reset_time'] == 'other') selected="selected" @endif>其他</option>
												</select>
											</label>
											&nbsp;
											<label>
												類型：
												<select id="search_kind" name="search[exception]" class="form-control">
													<option value="all" selected="selected">全部</option>
													<option value="normal" @if ($search['exception'] == 'normal') selected="selected" @endif>一般</option>
													<option value="job_seek" @if ($search['exception'] == 'job_seek') selected="selected" @endif>謀職假</option>
													<option value="sick" @if ($search['exception'] == 'sick') selected="selected" @endif>無薪病假</option>
													<option value="entertain" @if ($search['exception'] == 'entertain') selected="selected" @endif>善待假</option>
													<option value="annaul_leave" @if ($search['exception'] == 'annaul_leave') selected="selected" @endif>特休</option>
													<option value="lone_stay" @if ($search['exception'] == 'lone_stay') selected="selected" @endif>久任假</option>
													<option value="birthday" @if ($search['exception'] == 'birthday') selected="selected" @endif>生日假</option>
												</select>
											</label>
											&nbsp;
											<label>
												狀態：
												<select name="search[available]" class="form-control">
													<option value="all" selected="selected">全部</option>
													<option value="1" @if ($search['available'] == '1') selected="selected" @endif>開啟</option>
													<option value="0" @if ($search['available'] == '0') selected="selected" @endif>關閉</option>
												</select>
											</label>
											&nbsp;
											<label>
												關鍵字：
												<input type="search" class="form-control" placeholder="請輸入名稱進行查詢" name="search[keywords]" style="width:270px">
												<button type="submit" class="btn btn-default" onclick="location.href='leave_type'"><i class="fa fa-search"></i></button>
                                                <button type="button" class="btn btn-primary" onclick="location.href='{{ route('leave_type_create') }}'"><i class="fa fa-edit"></i></button>
											</label>
										</div>
                                        {{ csrf_field() }}
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th><a href onclick="changeSort('name');">名稱</a></th>
												<th width="15%"><a href onclick="changeSort('exception');">類型</a></th>
												<th width="15%"><a href onclick="changeSort('reset_time');">重置形式</a></th>
												<th width="15%"><a href onclick="changeSort('hours');">上限(HR)</a></th>
												<th width="10%"><a href onclick="changeSort('reason');">理由</a></th>
												<th width="10%"><a href onclick="changeSort('prove');">證明</a></th>
												<th width="10%"><a href onclick="changeSort('status');">狀態</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
                                        @foreach($types_list as $value)
                                            <tr class='clickable-row' data-href="{{ route('leave_type_view', [ 'id' => $value->id ]) }}">
                                                <td>{{ $value->name }}</td>
												<td>
                                                    @if ($value->exception == 'normal') 一般假別
                                                    @elseif ($value->exception == 'job_seek') 謀職假
                                                    @elseif ($value->exception == 'paid_sick') 有薪病假
                                                    @elseif ($value->exception == 'sick') 無薪病假
                                                    @elseif ($value->exception == 'entertain') 善待假
                                                    @elseif ($value->exception == 'annaul_leave') 特休
                                                    @elseif ($value->exception == 'lone_stay') 久任假
                                                    @elseif ($value->exception == 'birthday') 生日假
                                                    @endif
                                                </td>
												<td>
                                                    @if ($value->reset_time == 'none') 不重置
                                                    @elseif ($value->reset_time == 'week') 每週重置
                                                    @elseif ($value->reset_time == 'month') 每月重置
                                                    @elseif ($value->reset_time == 'season') 每季重置
                                                    @elseif ($value->reset_time == 'year') 每年重置
                                                    @endif
                                                </td>
												<td>{{ $value->hours }}</td>
												<td>
													<input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" @if ($value->reason == 1) checked="checked" @endif>
												</td>
												<td>
													<input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是"  data-off="否" @if ($value->prove == 1) checked="checked" @endif>
												</td>
												<td>
													<input type="checkbox" name="leave_type[status]" class="leave_type_status" data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($value->available == 1) checked="checked" @endif>
												</td>
												<td>
													<button type="submit"  class="btn btn-danger" @if($value->available == '1') disabled="disabled" @endif onclick="location.href='{{ route('leave_type_delete', [ 'id' => $value->id ]) }}'"><i class="fa fa-trash-o"></i></button>
												</td>
											</tr>
											</tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<ul class="pagination">
                                        <li class="paginate_button previous disabled">
                                            </li>
                                                @if ( count($types_list) > 0 ) 
                                                {{ $types_list->links() }}
                                                @endif
                                            </li>
                                        </li>
                                    </ul>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
</section>
<script>
    function search_page(pagesize){
        location.href="{{ route('leave_type') }}?pageSize="+pagesize;
    }
    
    function changeSort(sort){
        order_by = '{{$order_by}}';
        order_way = '{{$order_way}}';

        $('#sort').val(sort);

        if (order_by == sort && order_way == "DESC") {
            $('#sort_way').val("ASC");
        } else {
            $('#sort_way').val("DESC");
        }

        $("#frmSearch").submit();
    }
</script>
@stop
