@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="glyphicon glyphicon-thumbs-down"></i> 缺填日誌
	<small>Missing Sheet Report</small>
  </h1>
  {{ Breadcrumbs::render('absense_report/index') }}
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form name="frmSetting" action="{{ route('absense_report/index') }}" method="POST">
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
											<th width="20%"><a href="#sort_name">姓名</a></th>
											<th width="20%"><a href="#sort_total">缺填次數</a></th>
										</tr>
									</thead>
									<tbody>
										@forelse($dataProvider as $leave)
										<tr>
											<td>
												<img src="{{UrlHelper::getUserAvatarUrl($leave->fetchUser->avatar)}}" class="img-circle" alt="{{$leave->fetchUser->avatar}}" width="50px">
											</td>
											<td>{{$leave->fetchUser->nickname}}</td>
											<td>{{$dataAll[$leave->user_id]}}</td>
										</tr>
										@empty
										<tfotter>
								            <tr class="clickable-row" data-href="#">
				                      			<tr>
													<td colspan="3" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
												</tr>
				                    		</tr>
										</tfotter>
										@endforelse
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