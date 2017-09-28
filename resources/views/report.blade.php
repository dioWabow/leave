@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 月/年報表
	<small>Monthly/Year Report</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>報表</li>
	<li class="active">月/年報表</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form name="frmSetting" id="frmSearch" action="{{ route('report/index')}}" method="POST">
							<div class="row">
								<div class="col-sm-5">
									<div class="label bg-blue" style="font-size:20px">{{$year}}-{{$month}}</div>
								</div>
								<div class="col-sm-7">
									<div class="pull-right">
										<label>
											時間：
											<select id="setting_year" name="setting[year]" class="form-control">
												@for($i=2015; $i <= date('Y'); $i++)
												<option value="{{$i}}" @if("$year" == "$i")selected="selected"@endif>{{$i}} 年</option>
												@endfor
											</select>
											<select id="setting_month" name="setting[month]" class="form-control">
												<option value="year" @if("$month" == "year")selected="selected"@endif>整年</option>
												@for($j=1; $j < 13; $j++)
												<option @if($j < 10)value=0{{$j}}@else value={{$j}} @endif @if("$month" == "$j")selected="selected"@endif>{{$j}}月</option>
												@endfor
											</select>
										</label>
										<label><button type="submit" id="settingSearch" class="btn btn-default"><i class="fa fa-search"></i></button></label>
										&nbsp;
										<input type="hidden" name="_token" value="{{ csrf_token() }}">
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
											<th><a>名稱</a></th>
											@foreach($all_type as $type_data)
											<th><a>{{$type_data->name}}</a></th>
											@endforeach
											<th><a>總計(Hr)</a></th>
											<th><a>扣薪</a></th>
										</tr>
									</thead>
									<tbody>
										@foreach($all_user as $user_data)
											<tr class="clickable-row" data-href="#">
												<td>
													<img src="{{UrlHelper::getUserAvatarUrl($user_data->avatar)}}" class="img-circle" alt="{{$user_data->nickname}}" width="60px">
												</td>
												<td>{{$user_data->nickname}}</td>
												@foreach($all_type as $type_data)
												<td><a href="{{ route('report/vacation') }}?year={{$year}}&month={{$month}}&user_id={{$user_data->id}}&type_id={{$type_data->id}}">{{$report_data[$user_data->id][$type_data->id]}}</a></td>
												@endforeach
												<td class="text-red">{{$report_data[$user_data->id]['sum']}}</td>
												<td><span class="label bg-red">{{$report_data[$user_data->id]['deductions']}}</span></td>
											</tr>
										@endforeach
									</tbody>
									<tfoot>
										<tr class="text-red">
											<th></th>
											<th class="pull-right">總計(Hr)</th>
                      						@foreach($all_type as $key => $type_data)
  											<td class="text-red">{{$report_total[$key]}}</td>
											@endforeach
					                    	<td class="text-red">{{$report_total['sum']}}</td>
					                    	<td><span class="label bg-red">{{$report_total['deductions']}}</span></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
