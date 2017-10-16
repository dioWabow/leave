@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="fa fa-sitemap"></i> 權限設定
  <small>Auth Setting</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li class="active">權限設定</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      
      <form action="{{ route('teams/memberSet')}}" method="POST" name="member_form">
        <div class="box box-info">
          <div class="box-body" id="member_set">
            <div class="col-md-12" align="right">
              團隊：
              <select>
                <option>Washop</option>
              </select>
            </div>

          @if(1!=1)
          @foreach($team_result as $team_data)
            <div class="form-group member_list" id="member_match_manager" team_id="{{$team_data->id}}" team_name="{{$team_data->name}}"><div class="row">
              <div class="col-md-2">
                @if (empty($team_data->parent_id))
                  <label>{{$team_data->name}}</label>
                @else
                  <label>{{$team_data->parent_name}} / {{$team_data->name}}</label>
                @endif
              </div>
              <div class="col-md-10">
                <label>人員</label>
                <select class="form-control select2  team_member" name="teams[{{$team_data->id}}][]" multiple="multiple" data-placeholder="請選擇隸屬人員" id="member_{{$team_data->id}}" member_id="{{$team_data->id}}">
                @foreach($user_result as $user_data)
                  @if(array_key_exists("$team_data->id", $team_user_list))
                    @if(in_array($user_data->id, $team_user_list[$team_data->id]))
                      <option value="{{$user_data->id}}" selected="">{{$user_data->nickname}}</option>
                    @else
                      <option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
                    @endif
                  @else
                    <option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
                  @endif
                @endforeach
                </select>
              </div>
            </div></div>
          @endforeach
          @else
          <div class="form-group member_list" id="member_match_manager"><div class="row">
              <div class="col-md-2">
                <label>Tony</label>
              </div>
              <div class="col-md-10">
                <label>人員</label>
                <select class="form-control select2  team_member" name="teams[]" multiple="multiple">
                  <option selected>Dio</option>
                  <option>Eno</option>
                  <option selected>Carrie</option>
                  <option>Michael</option>
                  <option>Evan</option>
                </select>
              </div>
            </div></div>
            <div class="form-group member_list" id="member_match_manager"><div class="row">
              <div class="col-md-2">
                <label>Eno</label>
              </div>
              <div class="col-md-10">
                <label>人員</label>
                <select class="form-control select2  team_member" name="teams[]" multiple="multiple">
                  <option selected>Dio</option>
                  <option>Tony</option>
                  <option selected>Carrie</option>
                  <option>Michael</option>
                  <option>Evan</option>
                </select>
              </div>
            </div></div>
          @endif
          </div>
          <div class="box-footer">
            <div class="pull-right">
              <button type="reset" class="btn btn-default" onclick="history.go();"><i class="fa fa-undo"></i> 取消</button>
              <button type="submit" class="btn btn-primary" id="data_post"><i class="fa fa-send-o"></i> Send</button>
            </div>
          </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
      </form>
    </div>
  </div>
</section>
<!-- /.content -->
@stop

