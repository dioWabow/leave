@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar-plus-o"></i> @if(count($search)>0) {{ $search['working_day'] }}@else{{ TimeHelper::getNowDate() }}@endif
	<small>Work Sheet</small>
  </h1>
	 {{ Breadcrumbs::render('sheet/daily') }} 
</section>

<!-- Main content -->
<section class="content" id="calendar_content">
	<div class="row">
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
          <li @if($current_user == Auth::user()->id) class="active" @endif>
            <a href="{{ route('sheet/daily/index') }}">
              <img src="{{ UrlHelper::getUserAvatarUrl( Auth::user()->avatar ) }}" width="50px">
            <br>
              <span class="fonts">{{ Auth::user()->nickname }}</span>
            </a>
          </li>
        @foreach ($get_permission_user as $user)
					<li @if($current_user == $user->allow_user_id) class="active"@endif>
            <a href="{{ route('sheet/daily/index', [ 'current_user' => $user->allow_user_id ]) }}">
              <img src="{{ UrlHelper::getUserAvatarUrl( $user->fetchUser->avatar ) }}" width="50px">
            <br>
              <span class="fonts">{{ $user->fetchUser->nickname }}</span>
            </a>
          </li>
        @endforeach
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="list">
						<div class="dataTables_wrapper form-inline dt-bootstrap">
							<form name="frmOrderBy" id="frmOrderby" action="{{ route('sheet/daily/index', [ 'current_user' => $current_user ]) }}" method="POST">
								@if(count($model->order_by)>0)
									<input id="order_by" type="hidden" name="order_by[order_by]" value="{{ $model->order_by }}">
									<input id="order_way" type="hidden" name="order_by[order_way]" value="{{ $model->order_way }}">
								@else
									<input id="order_by" type="hidden" name="order_by[order_by]" value="">
									<input id="order_way" type="hidden" name="order_by[order_way]" value="">
								@endif
								<div class="row">
									<div class="col-sm-6">
										<div class="input-group input-group-sm">
											<span class="input-group-addon">
												前往
											</span>
											<input type="text" name="search[work_day]" id="search_work_day" value="@if(count($search)>2) {{ $search['work_day'] }}@endif" class="form-control single-date">
											<span class="input-group-btn">
											<button type="submit" class="btn btn-primary btn-flat">Go!</button>
											</span>
										</div>
										<button type="submit" class="btn btn-primary search-today">今日</button>
									</div>
									<div class="col-sm-6">
										<div class="pull-right">
											<!-- 新增按鈕 -->
                      @if ($current_user == Auth::user()->id)
                        @if ( count($search)>0 && TimeHelper::checkEditSheetDate($search['working_day']) )
                        <a href="{{ route('sheet/daily/create') }}">
                          <button type="button" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                          </button>
                        </a>
                        @elseif ( count($search)>0 && !TimeHelper::checkEditSheetDate($search['working_day']) && TimeHelper::checkHolidayDate($search['working_day']) )
                        <a href="{{ route('sheet/daily/create') }}">
                          <button type="button" class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                          </button>
                        </a>
                        @endif
                      @endif
										</div>
									</div>
								</div>
              </div>
                {!!csrf_field()!!}
							</form>
							<form action="{{ route('sheet/daily/copy') }}" method="POST">
								<div class="row">
									<div class="col-sm-12">
										<table class="table table-bordered table-striped table-hover footable footable-3 breakpoint breakpoint-lg rwd-table" data-toggle-selector=".footable-toggle" data-show-toggle="false" style="display: table;">
											<thead>
												<th width="3%"><input type="checkbox" id="checkall" name="checkall" class="flat-red" value="all"></th>
												<th>
													<a href="javascript:void(0)" class="sort" sortname="project_id">專案名稱</a>
												</th>
												<th>
													標題
												</th>
												<th data-breakpoints="xs sm">
													內文
												</th>
												<th>
													<a href="javascript:void(0)" class="sort" sortname="hour">時數</a>
												</th>
												<th>
													標籤
												</th>
											</thead>
											<tbody>
											@forelse($dataProvider as $value)
												<tr class="clickable-row" @if ($current_user != Auth::user()->id) data-href="#" @else data-href="{{route('sheet/daily/edit', [ 'id' => $value->id ])}}" @endif>
													<td>
														<input type="checkbox" name="time_sheet[id][]" id="work_check" class="flat-red check"  value="{{ $value->id }}">
													</td>
													<td data-th="專案名稱">
														{{ $value->fetchProject->name }}
													</td>
													<td  data-th="標題">
														{{ $value->items }}
													</td>
													<td data-th="內文">
														{{ $value->description }}
													</td>
													<td  data-th="時數">
														{{ $value->hour }}
													</td>
													<td data-breakpoints="xs sm"   data-th="標籤">
														@foreach(explode(',', $value->tag) as $tag) 
															<small class="label" style="background-color:#00AA00;">{{ $tag }}</small>
														@endforeach
													</td>
												</tr>
											@empty
												@if ((TimeHelper::getWeekNumberByDate($search['working_day']) == 6) || (TimeHelper::getWeekNumberByDate($search['working_day']) == 0))
													<tr>
														<td colspan="11" align="center"><span class="glyphicon glyphicon-remove"> 假日，不用填寫工作表唷~</span></td>
													</tr>
												@elseif(count($search)>0 && TimeHelper::checkHolidayDate($search['working_day']))
													<tr>
														<td colspan="11" align="center"><span class="fa fa-hand-spock-o"> 今天是補班，記得填寫本日內容哦</span></td>
													</tr>
												@else
													<tr>
														<td colspan="11" align="center"><span class="glyphicon glyphicon-remove"> 尚未填寫本日內容</span></td>
													</tr>
												@endif
											@endforelse
											</tbody>
										</table>
										<div class="row">
											<div class="col-md-3">
                      @if ($current_user == Auth::user()->id)
                        @if ( count($search)>0 && TimeHelper::checkEditSheetDate($search['working_day']) )
												<div class="input-group input-group-sm">
													<span class="input-group-addon">
														複製到
													</span>
													<input type="text" id="time_sheet_copy_date" name="time_sheet[copy_date]" disabled="disabled" class="form-control single-date">
													<span class="input-group-btn">
														<button type="submit" id="time_sheet_copy_to"  disabled="disabled" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">Go!</button>
													</span>
												</div>
												@elseif ( count($search)>0 && !TimeHelper::checkEditSheetDate($search['working_day']) && TimeHelper::checkHolidayDate($search['working_day']) )
												<div class="input-group input-group-sm">
													<span class="input-group-addon">
														複製到
													</span>
													<input type="text" id="time_sheet_copy_date" name="time_sheet[copy_date]" disabled="disabled" class="form-control single-date">
													<span class="input-group-btn">
														<button type="submit" id="time_sheet_copy_to"  disabled="disabled" class="btn btn-info" data-toggle="modal" data-target="#myModalConfirm">Go!</button>
													</span>
												</div>
                        @endif
                      @endif
											</div>
										</div>
									</div>
								</div>
							</div>
							{!!csrf_field()!!}
						</form>
					</div>
				</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
	</div>
</section>
@stop