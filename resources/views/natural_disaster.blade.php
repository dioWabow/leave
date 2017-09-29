

@extends('default')

@section('content')
  <!-- Page script -->
<script>
$(function () {
    $('#natural_search').on('click', function(){
        $("#natural_search_frm").submit();
    });

    var default_pre_date = "{{$input["date"]}}";
    var default_date = new Date(default_pre_date);
    $('.single-date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        locale: {format: 'YYYY-MM-DD'},
        startDate: default_date
    }).each(function(){
        $(this).val($(this).attr('date'));
    }).on('change', function(){ 
        $('#' + $(this).attr('id') + '_type option:eq(1)').prop('selected', true);
    });
    $("#natural_date").val(default_pre_date);
});
</script>
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-cloud"></i> 天災假單調整
	<small>Natural Disaster Modify</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">天災假單調整</li>
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
							<div class="col-sm-12">
								<form id="natural_search_frm" name="natural_search_frm" action="{{ route('natural/edit') }}" method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
									<div class="pull-left">
										<label>
											類型：
											<select id="natural_type_id" name="natural[type_id]" class="form-control">
                                            @if ( count($natural_disasters) > 0 )
                                                @foreach( $natural_disasters as $natural_disaster)
                                                    <option value="{{$natural_disaster->id}}" @if ( $natural_disaster->id == $input["type_id"] ) selected @endif>{{$natural_disaster->name}}</option>
                                                @endforeach
                                            @else
                                                <option value="">無天災假</option>
                                            @endif
											</select>
										</label>
										&nbsp;
										<label>
											開始時間：
											<input type="text" id="natural_date" name="natural[date]" class="form-control single-date">
										</label>
										&nbsp;
										<label>
											<select id="natural_range" name="natural[range]" class="form-control">
                                                @if ( empty($input["range"]) ) 
												<option value="">請選擇</option>
                                                @endif
                                                <option value="all_day" @if ( "all_day" == $input["range"] ) selected @endif>整天</option>
                                                <option value="morning" @if ( "morning" == $input["range"] ) selected @endif>上午</option>
												<option value="afternoon" @if ( "afternoon" == $input["range"] ) selected @endif>下午</option>
											</select>
										</label>
                                        <label>
                                            <button type="button" id="natural_search" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </label>
									</div>
								</form>
							</div>
						</div>
						<div class="row naturalDisasterList">
							<div class="col-sm-6">
                            @if ( Request::is('natural/edit') && !empty($natural_cancel) )
                                <form id="natural_cancel_frm" name="natural_cancel_frm" action="{{ route('natural/update') }}" method="POST">
                                    @foreach($input as $key => $input_one)
                                    　<input type="hidden" id="natural_{{$key}}" name="natural[{{$key}}]" value="{{$input_one}}">
                                    @endforeach
                                    <input type="hidden" id="natural_update" name="natural[update]" value="cancel">
                                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
    								<table class="table table-bordered table-striped table-hover">
    									<thead>
    										<tr>
    											<th width="3%"></th>
    											<th>名稱</th>
    											<th width="50%">請假日期</th>
    											<th width="10%">請假時數</th>
    											<th width="10%">天災時數</th>
    										</tr>
    									</thead>
    									<tbody>
                                            <tr>
                                                <td>
                                                    <img src="{{route('root_path')}}/dist/img/users/default.png" width="50px">
                                                </td>
                                                <td>全體員工</td>
                                                <td>{{ TimeHelper::changeViewTime($natural_cancel_total["start_time"], $natural_cancel_total["end_time"], 1) }}</td>
                                                <td>0</td>
                                                <td>{{$natural_cancel_total["hours"]}}</td>
                                            </tr>

                                            @foreach($natural_cancel as $natural_cancel_one)
                                            <tr>
                                                <td>
                                                    <img src="{{UrlHelper::getUserAvatarUrl($natural_cancel_one->avatar)}}" class="img-circle" width="50px">
                                                </td>
                                                <td>{{$natural_cancel_one->nickname}}</td>
                                                <td>{{ TimeHelper::changeViewTime($natural_cancel_one->start_time, $natural_cancel_one->end_time, 1) }}</td>
                                                <td>{{$natural_cancel_one->hours }}</td>
                                                <td>{{$natural_cancel_one->natural_hours}}</td>
                                            </tr>
                                            @endforeach
    									</tbody>
    								</table>
    								<div class="col-md-2 col-md-offset-5">
    									<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> 收回天災調整</button>
    								</div>
                                </form>
                            @endif
							</div>

							<div class="col-sm-6">
                            @if ( Request::is('natural/edit') && empty($natural_cancel) )
                                <form id="natural_add_frm" name="natural_add_frm" action="{{ route('natural/update') }}" method="POST">
                                    @foreach($input as $key => $input_one)
                                    　<input type="hidden" id="natural_{{$key}}" name="natural[{{$key}}]" value="{{$input_one}}">
                                    @endforeach
                                    <input type="hidden" id="natural_update" name="natural[update]" value="add">
                                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
    								<table class="table table-bordered table-striped table-hover">
    									<thead>
    										<tr>
    											<th width="3%"></th>
    											<th>名稱</th>
    											<th width="50%">請假日期</th>
    											<th width="10%">請假時數</th>
    											<th width="10%">天災時數</th>
    											<th width="10%">調整時數</th>
    										</tr>
    									</thead>
                                        @if ( empty($natural_cancel) && count($natural_add) > 0 ) 
                                            <tbody>
                                                @foreach($natural_add as $natural_add_one)
                                                <tr>
                                                    <td>
                                                        <img src="{{UrlHelper::getUserAvatarUrl($natural_add_one->avatar)}}" class="img-circle" alt="Dio" width="50px">
                                                    </td>
                                                    <td>{{$natural_add_one->nickname}}</td>
                                                    <td>{{ TimeHelper::changeViewTime($natural_add_one->start_time, $natural_add_one->end_time, 1) }}</td>
                                                    <td>{{$natural_add_one->hours}}</td>
                                                    <td>{{$natural_add_one->natural_hours}}</td>
                                                    <td class="text-red">{{ ($natural_add_one->hours - $natural_add_one->natural_hours) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfooter>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th class="pull-right">結餘</th>
                                                    <th>{{$natural_add_total["leave_hour_before"]}}</th>
                                                    <th>{{$natural_add_total["natural_hour"]}}</th>
                                                    <th class="text-red">{{$natural_add_total["leave_hour_after"]}}</th>
                                                </tr>
                                            </tfooter>
                                        @elseif( empty($natural_cancel) && count($natural_add) == 0 )
                                            <tbody>
                                                <tr>
                                                    <td colspan="6">
                                                        無人請假
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endif
    								</table>
    								<div class="col-md-2 col-md-offset-5">
    									<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> 確定送出調整</button>
    								</div>
                                </form>
                            @endif
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop

