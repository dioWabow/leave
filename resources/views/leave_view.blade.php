@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-calendar"></i> 假單檢視
	<small>View My Leave</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="{{route('index')}}"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>
  @if(!empty($http_referer))
    <a href="{{$pre_url}}">

    @if($http_referer == 'leaves_my')
      我的假單

    @elseif($http_referer == 'agent_approve')
      同意代理嗎?

    @elseif($http_referer == 'leaves_hr')
      團隊假單

    @elseif($http_referer == 'leaves_manager')
      團隊假單

    @elseif($http_referer == 'report')
      報表

    @elseif($http_referer == 'annual_report')
      特休假單列表

    @elseif($http_referer == 'annual_leave_calculate')
      特休假單列表

    @elseif($http_referer == 'leaved_user_annual_leave_calculate')
      特休假單列表(離職)

    @elseif($http_referer == 'agent')
      我是代理人

    @endif
    </a>
  @else
    <a href="{{route('leaves_my/prove')}}">
    我的假單
    </a>
  @endif
  </li>
	<li class="active">假單檢視</li>
  </ol>
<!--   @if(in_array($http_referer,['leaves_manager','report']))
    {{ Breadcrumbs::render('leave/view',$http_referer,$pre_url) }}
  @elseif(!empty($http_referer))
    {{ Breadcrumbs::render('leave/view',$http_referer) }}
  @else
    {{ Breadcrumbs::render('leave/view','') }}
  @endif -->
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-5">

			<!-- Profile Image -->
			<div class="box box-primary">
				<div class="box-body box-profile">
					<img class="profile-user-img img-responsive img-circle" src="{{UrlHelper::getUserAvatarUrl($model->fetchUser->avatar)}}" alt="{{$model->fetchUser->nickname}}">
          <h3 class="profile-username text-center">{{$model->fetchUser->nickname}}</h3>
          <h3 class="text-center">
            <span class="label label-default bg-green">
            @if($model->tag_id == 7)
              已取消
            @elseif($model->tag_id == 8)
              不准假
            @elseif($model->tag_id == 9)
              核准
            @else
              待核准
            @endif
            </span>
          </h3>
          <br />
					<div id="wizard" class="form_wizard wizard_horizontal">
            <ul class="wizard_steps">
              @php ($index = 1)
              @foreach($leave_prove_process as $key => $leave_prove)
                <li>
                  <a @if(!in_array($leave_prove_tag_name[$key]['id'],$leave_response->pluck('tag_id')->toArray())) class="disabled" @else class="on" @endif>
                    <span class="step_no">
                      <img src="{{UrlHelper::getUserAvatarUrl($leave_prove->avatar)}}" title="{{$leave_prove->nickname}}" alt="{{$leave_prove->nickname}}" @if(!in_array($leave_prove_tag_name[$key]['id'],$leave_response->pluck('tag_id')->toArray())) class="pic_gray"  @endif>
                    </span>
                    <span class="step_descr @if(!in_array($leave_prove_tag_name[$key]['id'],$leave_response->pluck('tag_id')->toArray())) disabled @endif">
                        Step {{$index}}<br />
                        <small>
                        {{$leave_prove_tag_name[$key]['name']}}
                        </small>
                    </span>
                  </a>
                </li>
                @php ($index += 1)
              @endforeach
            </ul>
          </div>
					<ul class="list-group list-group-unbordered">
						<li class="list-group-item">
							<b>假別</b> <font style="color: #3C8DBC;" class="pull-right">{{$model->fetchType->name}}</font>
						</li>
						<li class="list-group-item">
							<b>開始時間</b> <font style="color: #3C8DBC;" class="pull-right">{{TimeHelper::changeTimeByArriveTime($model->start_time, $model->user_id, '+')}}</font>
						</li>
						<li class="list-group-item">
							<b>結束時間</b> <font style="color: #3C8DBC;" class="pull-right">{{TimeHelper::changeTimeByArriveTime($model->end_time, $model->user_id, '+')}}</font>
						</li>
						<li class="list-group-item">
							<b>代理人</b> <font style="color: #3C8DBC;" class="pull-right">@if (!empty($leave_prove_process['agent'])){{$leave_prove_process['agent']->nickname}}@endif</font>
						</li>
						<li class="list-group-item">
							<b>原因</b> <font style="color: #3C8DBC;" class="pull-right">{{$model->reason}}</font>
						</li>
						<li class="list-group-item">
							<b>額外通知</b>
              <font style="color: #3C8DBC;" class="pull-right">
                @foreach($leave_notice as $notice)
                  @if($loop->last)
                    {{$notice->fetchUser->nickname}}
                  @else
                    {{$notice->fetchUser->nickname}}、
                  @endif
                @endforeach
              </font>
						</li>
						<li class="list-group-item">
							<b>建立時間</b> <font style="color: #3C8DBC;" class="pull-right">{{\Carbon\Carbon::parse($model->created_at)->format('Y-m-d H:i:s')}}</font>
						</li>
					</ul>

          <form action="{{route('leave/update')}}" method="POST">
            {!!csrf_field()!!}
            <input type="hidden" name="leave_response[leave_id]" value="{{$model->id}}">
            <input type="hidden" id="leave_status" name="leave_response[status]" value="1">

            @if(in_array($model->tag_id,[1,2]) && Auth::getUser()->id == $model->user_id)
              <a href="#" class="btn btn-danger btn-block" id="cancel" data-toggle="modal" data-target="#myModalConfirm"><b>我要取消</b></a>

            @elseif($model->tag_id == 1 && in_array(Auth::getUser()->id,$leave_agent->pluck('agent_id')->toArray()))
              <div class="form-group"><div class="row">
              <div class="col-md-2">說點話</div>
              <div class="col-md-10">
                <input type="text" id="leave_memo" name="leave_response[memo]" class="form-control pull-right">
              </div>
              </div></div>
              <div class="form-group"><div class="row">
                <div class="col-md-6">
                  <a href="#" class="btn btn-danger btn-block" id='disagree_agent' data-toggle="modal" data-target="#myModalConfirm"><b>不同意代理</b></a>
                </div>
                <div class="col-md-6">
                  <a href="#" class="btn btn-info btn-block" id='agree_agent' data-toggle="modal" data-target="#myModalConfirm"><b>同意代理</b></a>
                </div>
              </div></div>
            @elseif(in_array($model->tag_id,[2]) && !empty($leave_prove_process['minimanager']) &&in_array(Auth::getUser()->id,[$leave_prove_process['minimanager']->id]))
              <div class="form-group"><div class="row">
              <div class="col-md-2">說點話</div>
              <div class="col-md-10">
                <input type="text" id="leave_memo" name="leave_response[memo]" class="form-control pull-right">
              </div>
              </div></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <a href="#" class="btn btn-danger btn-block" id="disagree" data-toggle="modal" data-target="#myModalConfirm"><b>不允許</b></a>
                  </div>
                  <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block" id="agree" data-toggle="modal" data-target="#myModalConfirm"><b>允許放假</b></a>
                  </div>
                </div>
              </div>
            @elseif(in_array($model->tag_id,[2,3]) && !empty($leave_prove_process['manager']) && in_array(Auth::getUser()->id,[$leave_prove_process['manager']->id]))
              <div class="form-group"><div class="row">
              <div class="col-md-2">說點話</div>
              <div class="col-md-10">
                <input type="text" id="leave_memo" name="leave_response[memo]" class="form-control pull-right">
              </div>
              </div></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <a href="#" class="btn btn-danger btn-block" id="disagree" data-toggle="modal" data-target="#myModalConfirm"><b>不允許</b></a>
                  </div>
                  <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block" id="agree" data-toggle="modal" data-target="#myModalConfirm"><b>允許放假</b></a>
                  </div>
                </div>
              </div>
            @elseif($model->tag_id == '9' && !empty($leave_prove_process['manager']) && in_array(Auth::getUser()->id,[$leave_prove_process['manager']->id]))
              <div class="form-group"><div class="row">
              <div class="col-md-2">說點話</div>
              <div class="col-md-10">
                <input type="text" id="leave_memo" name="leave_response[memo]" class="form-control pull-right">
              </div>
              </div></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                <a href="#" class="btn btn-danger btn-block" id="cancel" data-toggle="modal" data-target="#myModalConfirm"><b>取消此假單</b></a>
                  </div>
                </div>
              </div>
            @elseif($model->tag_id == 4 && !empty($leave_prove_process['admin']) && Auth::getUser()->id == $leave_prove_process['admin']->id)
              <div class="form-group"><div class="row">
              <div class="col-md-2">說點話</div>
              <div class="col-md-10">
                <input type="text" id="leave_memo" name="leave_response[memo]" class="form-control pull-right">
              </div>
              </div></div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <a href="#" class="btn btn-danger btn-block" id="disagree" data-toggle="modal" data-target="#myModalConfirm"><b>不允許</b></a>
                  </div>
                  <div class="col-md-6">
                    <a href="#" class="btn btn-info btn-block" id="agree" data-toggle="modal" data-target="#myModalConfirm"><b>允許放假</b></a>
                  </div>
                </div>
              </div>
            @endif
            <!-- Modal -->
            <div class="modal fade" id="myModalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                      <h1></h1>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
				</div>

			<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
		<!-- /.col -->
		<div class="col-md-7">
			<div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#timeline" data-toggle="tab">Timeline</a></li>
				<li><a href="#settings" data-toggle="tab">證明（補）</a></li>
			</ul>
			<div class="tab-content">
				<!-- /.tab-pane -->
				<div class="active tab-pane" id="timeline">
				<!-- The timeline -->
					<ul class="timeline timeline-inverse">
            <!-- timeline time label -->
            <li class="time-label">
              <span class="bg-red">
                {{ TimeHelper::changeDateFormat($model->start_time,'Y-m-d') }}
              </span>
            </li>
            <!-- /.timeline-label -->
            @foreach($leave_response_reverse as $key => $leave_response)
              @foreach($leave_response as $response)
              <!-- timeline item -->
              <li>
                <i class="fa bg-blue">
                  <img class="profile-user-img img-responsive img-circle" src="{{UrlHelper::getUserAvatarUrl($response->fetchUser->avatar)}}" alt="Neo">
                </i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i>{{\Carbon\Carbon::parse($response->created_at)->format(' H:i:s')}}</span>

                  <h3 class="timeline-header"><a href="#">{{$response->fetchUser->nickname}}</a> {{$response->fetchTag->name}}</h3>
                  @if (!empty($response->memo))
                  <div class="timeline-body">
                    {{$response->memo}}
                  </div>
                  @endif
                </div>
              </li>
              <!-- END timeline item -->
              @endforeach
            <!-- timeline time label -->
            <li class="time-label">
              <span class="bg-green">
                {{$key}}
              </span>
            </li>
            <!-- /.timeline-label -->
            @endforeach

						<li>
							<i class="fa fa-clock-o bg-gray"></i>
						</li>
					</ul>
				</div>
				<!-- /.tab-pane -->

          <div class="tab-pane" id="settings">
            <form action="{{route('leave/upload')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
              {!!csrf_field()!!}
              <input type="hidden" name="leave_view[id]" value="{{$model->id}}">
              <input id="leave_view_fileupload" name="fileupload[]" class="file-loading" type="file" multiple data-max-file-count="5">
            </form>
          </div>

				<!-- /.tab-pane -->
			</div>
			<!-- /.tab-content -->
			</div>
			<!-- /.nav-tabs-custom -->
		</div>
		<!-- /.col -->
	</div>
	<!-- /.row -->

</section>
@stop

