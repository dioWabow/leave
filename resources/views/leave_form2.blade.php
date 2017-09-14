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
<form action="{{route('leave/insert')}}" method="POST" enctype="multipart/form-data">
{!!csrf_field()!!}
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
							@if($type->exception!='paid_sick')
								<label>
									<input type="radio" name="leave[type_id]" class="flat-red" @if ($model->type_id == $type->id) checked="checked" @elseif($loop->first) checked="checked" @endif value="{{$type->id}}" hour="4">
									{{$type->name}}
								</label>&emsp;
							@endif
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
							<input type="text" id="leave_timepicker" name="leave[timepicker]" value="{{$model->timepicker}}" class="form-control pull-right" date="{{$model->timepicker}}">
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
							<input type="text" id="leave_spent_hours" value="{{$model->hours}}" class="form-control pull-right" disabled="disabled">
							<input type="hidden" id="leave_spent_hours_hide" name="leave[hours]" value="{{$model->hours}}" class="form-control pull-right">
							<span class="input-group-addon">HR</span>
						</div>
					</div>
					<div class="col-md-11" id="div_leave_dayrange">
						<div class="input-group">
							<label>
								<input type="radio" id="leave_dayrange_allday" name="leave[dayrange]" class="flat-red" value="allday" @if($model->dayrange=="allday") checked @endif>
								全天
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_morning" name="leave[dayrange]" class="flat-red" value="morning" @if($model->dayrange=="morning") checked @endif> 
								上午
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_afternoon"  name="leave[dayrange]" class="flat-red" value="afternoon" @if($model->dayrange=="afternoon") checked @endif> 
								下午
							</label>&emsp;
							<input type="hidden" id="keep_dayrange" name="keep_dayrange" value="{{$model->dayrange}}">
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
							<input type="text" name="leave[reason]" class="form-control pull-right" value="{{$model->reason}}">
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>代理人</label>
					</div>
					<div class="col-md-11">
						@forelse($user_agents as $user_agent)
							@if($user_agent->user->status != 0)
								<label>
								<input type="checkbox" @if((count($model->agent)>0)&&in_array($user_agent->user->id,$model->agent)) checked="checked" @endif name="leave[agent][]" class="flat-red" value="{{$user_agent->user->id}}"> 
									{{$user_agent->user->nickname}}
								</label>&emsp;
							@endif
						@empty
							<label>
								<input type="hidden" name="leave[agent][]" class="flat-red" value=""> 
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
						<input id="leave_fileupload" name="fileupload[]" class="file" type="file" multiple data-max-file-count="5">
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>通知對象</label>
					</div>
					<div class="col-md-11">
						<select class="form-control select2" id="leave_notice_person" name="leave[notice_person][]" multiple="multiple" data-placeholder="請選擇需另行通知的夥伴">
							@foreach($teams as $team)
	              <optgroup label="{{$team->name}}">
	                @foreach($team_users as $team_user)
	                  @if($team->id==$team_user->team_id&&$team_user->user->status!=0)
	                    <option value="{{$team_user->user_id}}" @if((count($model->notice_person)>0)&&in_array($team_user->user->id,$model->notice_person)) selected="selected" @endif>{{$team_user->user->nickname}}</option>
	                  @endif
	                @endforeach
	              </optgroup>
              @endforeach

              @if(count($user_no_team)>0)
                <optgroup label="NOGROUP">
                  @foreach($user_no_team as $user)
                  	@if($user->status!=0)
                    	<option value="{{$user->id}}" @if((count($model->notice_person)>0)&&in_array($user->id,$model->notice_person)) selected="selected" @endif >{{$user->nickname}}</option>
                    @endif
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
	    				$('#leave_spent_hours_hide').val(element);
	    			} else {
	    				$("#ajax_switch").val(0);
	    			}
	      });
	    }
    });
	}
}

$("#leave_fileupload").fileinput({
	initialPreviewAsData: true,
  showUpload: false,
});

</script>
@stop