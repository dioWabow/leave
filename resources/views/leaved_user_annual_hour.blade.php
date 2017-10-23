@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-line-chart"></i> 特休結算(離職)
	<small>Leaved User Annual Hours</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{route('index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>月/年報表</li>
	<li class="active">特休結算(離職)</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<form id="frmSearch" name="frmSearch" action="{{route('leaved_user_annual_leave_calculate/index')}}" method="POST">
            {!!csrf_field()!!}
              <input id="order_by" type="hidden" name="order_by[order_by]" value="{{$model->order_by}}">
              <input id="order_way" type="hidden" name="order_by[order_way]" value="{{$model->order_way}}">
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
						
						<div class="row">
							<div class="col-sm-12">
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th width="3%"></th>
											<th><a href="javascript:void(0)">姓名</a></th>
                      <th><a href="javascript:void(0)">到職日</a></th>
											<th><a href="javascript:void(0)">總額度</a></th>
											<th><a href="javascript:void(0)">使用額度</a></th>
											<th><a href="javascript:void(0)">剩餘額度</a></th>
										</tr>
									</thead>
									<tbody>
                    @forelse($dataProvider as $annual_hour)
                      @if($annual_hour->annual_hours>0)
    										<tr class='clickable-row' data-href='{{route("leaved_user_annual_leave_calculate/view" , ["id" => $annual_hour->user_id ,"year" => $search["year"]])}}'>
    											<td>
    												<img src="{{UrlHelper::getUserAvatarUrl($annual_hour->fetchUser->avatar)}}" class="img-circle" alt="{{$annual_hour->fetchUser->nickname}}" width="50px">
    											</td>
                          <td>{{$annual_hour->fetchUser->nickname}}</td>
                          <td>{{TimeHelper::changeDateFormat($annual_hour->fetchUser->enter_date,'Y-m-d')}}</td>
    											<td>{{$annual_hour->annual_hours}}</td>
    											<td>{{$annual_hour->used_annual_hours}}</td>
    											<td>{{$annual_hour->remain_annual_hours}}</td>
    										</tr>
                      @endif
                    @empty
                    <tr class='clickable-row' data-href='#'>
                      <td colspan="6" align="center">
                        <span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span>
                      </td>
                    </tr>
                    @endforelse
									</tbody>
                  @if(count($dataProvider)>0)
									<tfoot>
										<tr class="text-red">
											<td></td>
                      <td></td>
											<th class="pull-right">總計(Hr)</th>
											<td>{{$dataAll['annual_hours']}}</td>
											<td>{{$dataAll['used_annual_hours']}}</td>
											<td>{{$dataAll['remain_annual_hours']}}</td>
										</tr>
									</tfoot>
                  @endif
								</table>
							</div>
						</div>
            </form>
            <a href="{{  route('export_leaved_hour_excel' ,['year' => $search['year']])}}"><button class="label bg-blue" style="font-size:20px">匯出報表</button></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop

