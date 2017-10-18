
@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 假別管理
	<small>Vacation Category Management</small>
  </h1>
  {{ Breadcrumbs::render('leave_type') }}
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
								<form name="frmSearch" id="frmSearch" action="{{ route('leave_type') }}" method="POST">
									@if(count($model->order_by)>0)
											<input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
											<input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
									@else
											<input id="order_by" type="hidden" name="order_by[order_by]" value="">
											<input id="order_way" type="hidden" name="order_by[order_way]" value="">
									@endif
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
												形式：
												<select id="search_type" name="search[reset_time]"  class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="none" @if (count($search)>0 && $search['reset_time'] == 'none') selected="selected" @endif >不重置</option>
													<option value="week" @if (count($search)>0 && $search['reset_time'] == 'week') selected="selected" @endif>每週重置</option>
													<option value="month" @if (count($search)>0 && $search['reset_time'] == 'month') selected="selected" @endif>每月重置</option>
													<option value="season" @if (count($search)>0 && $search['reset_time'] == 'season') selected="selected" @endif>每季重置</option>
													<option value="year" @if (count($search)>0 && $search['reset_time'] == 'year') selected="selected" @endif>每年重置</option>
													<option value="other" @if (count($search)>0 && $search['reset_time'] == 'other') selected="selected" @endif>其他</option>
												</select>
											</label>
											&nbsp;
											<label>
												類型：
												<select id="search_kind" name="search[exception]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="normal" @if (count($search)>0 && $search['exception'] == 'normal') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('normal') }}</option>
													<option value="job_seek" @if (count($search)>0 && $search['exception'] == 'job_seek') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('job_seek') }}</option>
													<option value="paid_sick" @if (count($search)>0 && $search['exception'] == 'paid_sick') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('paid_sick') }}</option>
													<option value="sick" @if (count($search)>0 && $search['exception'] == 'sick') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('sick') }}</option>
													<option value="entertain" @if (count($search)>0 && $search['exception'] == 'entertain') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('entertain') }}</option>
													<option value="annual_leave" @if (count($search)>0 && $search['exception'] == 'annual_leave') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('annual_leave') }}</option>
													<option value="lone_stay" @if (count($search)>0 && $search['exception'] == 'lone_stay') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('lone_stay') }}</option>
													<option value="birthday" @if (count($search)>0 && $search['exception'] == 'birthday') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('birthday') }}</option>
													<option value="natural_disaster" @if (count($search)>0 && $search['exception'] == 'natural_disaster') selected="selected" @endif>{{ WebHelper::getTypesExceptionLabel('natural_disaster') }}</option>
												</select>
											</label>
											&nbsp;
											<label>
												狀態：
												<select name="search[available]" class="form-control">
													<option value="" selected="selected">全部</option>
													<option value="1" @if (count($search)>0 && $search['available'] == '1') selected="selected" @endif>開啟</option>
													<option value="0" @if (count($search)>0 && $search['available'] == '0') selected="selected" @endif>關閉</option>
												</select>
											</label>
											&nbsp;
											<label>
												關鍵字：
												<input type="search" class="form-control" placeholder="請輸入名稱進行查詢" name="search[name]" style="width:270px" value="@if(count($search)>0){{$search['name']}}@endif" >
												<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        <button type="button" class="btn btn-primary" onclick="location.href='{{ route('leave_type/create') }}'"><i class="fa fa-edit"></i></button>
											</label>
										</div>
											{!!csrf_field()!!}
									</form>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th width="15%"><a href="javascript:void(0)" onclick="changeSort('name');">名稱</a></th>
												<th width="15%"><a href="javascript:void(0)" onclick="changeSort('exception');">類型</a></th>
												<th width="15%"><a href="javascript:void(0)" onclick="changeSort('reset_time');">重置形式</a></th>
												<th width="13%"><a href="javascript:void(0)" onclick="changeSort('hours');">上限(HR)</a></th>
												<th width="10%"><a href="javascript:void(0)" onclick="changeSort('reason');">扣薪</a></th>
												<th width="10%"><a href="javascript:void(0)" onclick="changeSort('reason');">理由</a></th>
												<th width="10%"><a href="javascript:void(0)" onclick="changeSort('prove');">證明</a></th>
												<th width="10%"><a href="javascript:void(0)" onclick="changeSort('available');">狀態</a></th>
												<th width="5%"></th>
											</tr>
										</thead>
										<tbody>
											@foreach ($dataProvider as $value)
												<tr class="clickable-row" data-href="{{ route('leave_type/edit', [ 'id' => $value->id ]) }}">
													<td>{{ $value->name }}</td>
														<td>
															@if ($value->exception == 'normal') 一般假別
															@elseif ($value->exception == 'job_seek') 謀職假
															@elseif ($value->exception == 'paid_sick') 有薪病假
															@elseif ($value->exception == 'sick') 無薪病假
															@elseif ($value->exception == 'entertain') 善待假
															@elseif ($value->exception == 'annual_leave') 特休
															@elseif ($value->exception == 'lone_stay') 久任假
															@elseif ($value->exception == 'natural_disaster') 天災假
															@elseif ($value->exception == 'birthday') 生日假
															@endif
														</td>
														<td>
															@if ($value->reset_time == 'none') 不重置
															@elseif ($value->reset_time == 'week') 每週重置
															@elseif ($value->reset_time == 'month') 每月重置
															@elseif ($value->reset_time == 'season') 每季重置
															@elseif ($value->reset_time == 'year') 每年重置
															@elseif ($value->reset_time == 'other') 其他
															@endif
														</td>
													<td>{{ $value->hours }}</td>
													<td>
														<input type="checkbox" name="leave_type[deductions]" value="{{$value->id}}" class="leave_type_deductions{{$value->id}}"  data-toggle="toggle"  data-on="是" data-off="否" @if ($value->deductions == 1) checked="checked" @endif>
													</td>
													<td>
														<input type="checkbox" name="leave_type[reason]" value="{{$value->id}}" class="leave_type_reason{{$value->id}}"  data-toggle="toggle"  data-on="是" data-off="否" @if ($value->reason == 1) checked="checked" @endif>
													</td>
													<td>
														<input type="checkbox" name="leave_type[prove]" value="{{$value->id}}" class="leave_type_prove{{$value->id}}"   data-toggle="toggle" data-on="是"  data-off="否" @if ($value->prove == 1) checked="checked" @endif>
													</td>
													<td>
														<input type="checkbox" name="leave_type[available]" value="{{$value->id}}" class="leave_type_available{{$value->id}}"  data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($value->available == 1) checked="checked" @endif>
													</td>
													<td>
														<a href="{{ route('leave_type/delete', [ 'id' => $value->id ]) }}">
															<button type="button" class="btn btn-danger"  @if(count(App\Leave::getTypeIdByLeaves($value->id))>0) disabled="disabled" @endif >
																<i class="fa fa-trash-o"></i>
															</button>
														</a>
													</td>
                        </tr>
                      </tr>
                      @endforeach
                      @if(count($dataProvider) == 0)
											<tr class="">
												<td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
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
                        </li>
                            {{ $dataProvider->links() }}
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
@stop