@extends('default')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-plane"></i> 我要放假
	<small>Taken a lot of time off</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">我要放假</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">放假單</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>假別</label>
					</div>
					<div class="col-md-11">
						@foreach( $types as $type)
							<label>
								<input type="radio" name="leave[type_id]" class="flat-red" @if($loop->first) checked="checked" @endif value="{{$type->id}}" hour="4"> 
								{{$type->name}}
							</label>&emsp; 
						@endforeach
					</div>
				</div></div>
				<div class="form-group" id="group_timepicker"><div class="row">
					<div class="col-md-1">
						<label>日期</label>
					</div>
					<div class="col-md-11">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							<input type="text" id="leave_timepicker" name="leave[timepicker]" class="form-control pull-right">
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label id="label_leave_spent_hours">請假時數</label>
						<label id="label_leave_dayrange">請假時段</label>
					</div>
					<div class="col-md-11" id="div_leave_spent_hours">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-hourglass-3"></i>
							</div>
							<input type="text" id="leave_spent_hours" name="leave[spent_hours]" class="form-control pull-right" disabled="disabled">
							<span class="input-group-addon">HR</span>
						</div>
					</div>
					<div class="col-md-11" id="div_leave_dayrange">
						<div class="input-group">
							<label>
								<input type="radio" id="leave_dayrange_allday" name="leave[dayrange]" class="flat-red" value="allday" checked>
								全天
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_morning" name="leave[dayrange]" class="flat-red" value="morning"> 
								上午
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_afternoon"  name="leave[dayrange]" class="flat-red" value="afternoon"> 
								下午
							</label>&emsp; 
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>理由</label>
					</div>
					<div class="col-md-11">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-commenting-o"></i>
							</div>
							<input type="text" name="leave[reason]" class="form-control pull-right">
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>代理人</label>
					</div>
					<div class="col-md-11">
						@forelse($user_agents as $user_agent)
							<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="{{$user_agent->user->id}}"> 
								{{$user_agent->user->nickname}}
							</label>&emsp;
						@empty
							<label>
								<input type="hidden" name="leave[agent]" class="flat-red" value=""> 
									<font style="color: red">無代理人</font>
							</label>&emsp;
						@endforelse
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>檔案上傳</label>
					</div>
					<div class="col-md-11">
						<input id="leave_fileupload" name="leave[fileupload][]" class="file" type="file" multiple data-min-file-count="1">
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>通知對象</label>
					</div>
					<div class="col-md-11">
						<select class="form-control select2" id="leave_notic_person" name="leave[notic_person]" multiple="multiple" data-placeholder="請選擇需另行通知的夥伴">
							@foreach($teams as $team)
	              <optgroup label="{{$team->name}}">
	                @foreach($team_users as $team_user)
	                    @if($team->id==$team_user->team_id)
	                      <option value="{{$team_user->user_id}}">{{$team_user->user->nickname}}</option>
	                    @endif
	                @endforeach
	              </optgroup>
              @endforeach
              @if(count($user_no_team)>0)
                <optgroup label="NOGROUP">
                  @foreach($user_no_team as $user)
                    <option value="{{$user->id}}">{{$user->name}}</option>
                  @endforeach
                </optgroup>
              @endif
						</select>
					</div>
				</div></div>
			</div>
			<div class="box-footer">
				<div class="pull-right">
					<button type="reset" class="btn btn-default"><i class="fa fa-undo"></i> 取消</button>
					<button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
				</div>
			</div>
		</div>
	</section>
		<input type="hidden" id="ajax_switch" value="0">
</form>
<!-- /.content -->

<script>
	function calculate_hours() {
		if ($("#leave_timepicker").val()) {
		$.ajax({
	        url: '{{route("leave/calculate_hours")}}',
	        type: 'POST',
	        data: {"_token": "{{ csrf_token() }}", date_range:$("#leave_timepicker").val()},
	        dataType: 'JSON',
	        success: function (data) { 
	        	$.each(data, function(index, element) {
	        			if ($("#ajax_switch").val() == 0) {
	        				$('#leave_spent_hours').val(element);
	        			} else {
	        				$("#ajax_switch").val(0);
	        			}
		        });
	        }
	    });
		}
	}
</script>
@stop