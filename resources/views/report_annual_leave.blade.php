@extends('default')

@section('content')
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 特休報表
	<small>Annual Leave Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>報表</li>
	<li class="active">特休報表</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form name="frmOrderby" action="{{ route('annual_report/index') }}" method="POST">
            {!!csrf_field()!!}
							<div class="row">
								<div class="col-sm-5">
									<div class="label bg-blue" style="font-size:20px">{{$search['year']}}年</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											年份：
											<select id="setting_year" name="search[year]" class="form-control">
                        @for ($i = 2015; $i <= Carbon\Carbon::parse()->format('Y'); $i++)
                        <option value="{{$i}}" @if($search['year']==$i)selected="selected"@endif>{{$i}} 年</option>
                        @endfor
											</select>
										</label>
										<label><button type="submit" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button></label>
										&nbsp;
									</div>
								</div>
							</div>
						</form>
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th width="3%"></th>
											<th width="10%"><a href="javascript:void(0)">姓名</a></th>
											<th width="13%"><a href="javascript:void(0)">到職日</a></th>
											<th><a href="javascript:void(0)">{{ $search['year'] }}年額度</a></th>
											<th><a href="javascript:void(0)">{{ $search['year'] + 1 }}年額度</a></th>
											<th><a href="javascript:void(0)">使用額度</a></th>
											<th><a href="javascript:void(0)">剩餘額度</a></th>
										</tr>
									</thead>
									<tbody>
										@forelse ($dataProvider as $value)
                      <tr class="clickable-row" data-href="{{  route('annual_report/view', ['id' => $value->user_id, 'year' => $search['year'] ] ) }}">
											<td>
												<img src="{{ UrlHelper::getUserAvatarUrl($value->fetchUser->avatar) }}" class="img-circle" alt="{{ $value->fetchUser->nickname }}" width="50px">
											</td>
											<td>{{ $value->fetchUser->name }}</td>
											<td>{{ TimeHelper::changeDateFormat($value->fetchUser->enter_date,'Y-m-d') }}</td>
											<td>{{ $value->annual_this_years }}</td>
											<td>{{ $value->annual_next_years }}</td>
											<td>{{ $value->used_annual_hours }}</td>
											<td>{{ $value->remain_annual_hours }}</td>
										</tr>
                    @empty
                    <tr class="clickable-row" data-href="#">
                      <td colspan="7" align="center">
                        無資料
                      </td>
                    </tr>
                    @endforelse
									</tbody>
                  @if(count($dataProvider)>0)
									<tfoot>
										<tr class="text-red">
											<th></th>
											<th></th>
											<th class="pull-right">總計(Hr)</th>
											<td>{{ $dataAll['annual_this_years'] }}</td>
											<td>{{ $dataAll['annual_next_years'] }}</td>
											<td>{{ $dataAll['used_annual_hours'] }}</td>
											<td>{{ $dataAll['remain_annual_hours'] }}</td>
										</tr>
									</tfoot>
                  @endif
								</table>
								<a href="{{  route('export_annual_excel' ,['year' => $search['year']])}}"><button class="label bg-blue" style="font-size:20px">匯出報表</button></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop