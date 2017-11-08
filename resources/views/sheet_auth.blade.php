@extends('default')

@section('content')
    <!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  <i class="glyphicon glyphicon-eye-open"></i> 權限設定
  <small>Sheet Authority</small>
  </h1>
  {{ Breadcrumbs::render('sheet/auth/index') }}
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      
      <form action="{{ route('sheet/auth/update')}}" method="POST" name="member_form">
        <div class="box box-info">
          <div class="box-body" id="member_set">

          <div class="form-group member_list" id="member_match_manager">
            <div class="row">
              <div class="col-md-2">
                <label>團隊</label>
              </div>
              <div class="col-md-2">
                <label>姓名</label>
              </div>
              <div class="col-md-8">
                  <label>可觀看名單</label>
              </div>
            </div>
          </div>
          @if(!empty($team_result) )
          @foreach($team_result as $team_data)
            <div class="form-group member_list" id="member_match_manager" team_id="{{$team_data->id}}" team_name="{{$team_data->name}}">
              @if( !empty($user_team_result[$team_data->id]) )
                @foreach($user_team_result as $team_id => $user_team)
                @if( $team_id ==  $team_data->id)
                  @foreach($user_team as $user_id)
                  <div class="row">
                    <div class="col-md-2">
                      @if ($user_team->first() == $user_id )
                        @if (empty($team_data->parent_id))
                          <label>{{$team_data->name}}</label>
                        @else
                          <label>{{$team_data->fetchParentTeam[0]->name}} / {{$team_data->name}}</label>
                        @endif
                      @else
                        <label></label>
                      @endif
                    </div>
                    <div class="col-md-2">
                      <label>{{$user_result[$user_id]->name}}</label>
                    </div>
                    <div class="col-md-8">
                      <select class="form-control select2  team_member" name="teams[{{$user_id}}][]" multiple="multiple" data-placeholder="請選擇隸屬人員" id="member_{{$user_id}}" member_id="{{$user_id}}">
                        @foreach($user_result as $user_data)
                        @if( in_array( $user_data->id, $timesheet_permission_result[$user_id]->pluck("allow_user_id")->toArray() ) )
                          <option value="{{$user_data->id}}" selected>{{$user_data->nickname}}</option>
                        @elseif($user_data->id == $user_id)
                        @else
                          <option value="{{$user_data->id}}">{{$user_data->nickname}}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                  @endforeach
                @endif
                @endforeach
              @endif
            </div>
          @endforeach
          @else
          <div class="form-group member_list" id="member_match_manager"><div class="row">
            <div class="col-md-2">
              <label>團隊</label>
            </div>
            <div class="col-md-2">
              <label>姓名</label>
            </div>
            <div class="col-md-8">
                <label>可觀看名單</label>
            </div>
          </div></div>
          <div class="form-group member_list" id="member_match_manager"><div class="row">
              <div class="col-md-2">
                <label>Washop</label>
              </div>
              <div class="col-md-2">
                <label>Tony</label>
              </div>
              <div class="col-md-8">
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
                <label></label>
              </div>
              <div class="col-md-2">
                <label>Carrie</label>
              </div>
              <div class="col-md-8">
                <select class="form-control select2  team_member" name="teams[]" multiple="multiple">
                  <option selected>Dio</option>
                  <option>Eno</option>
                  <option selected>Tony</option>
                  <option>Michael</option>
                  <option>Evan</option>
                </select>
              </div>
            </div></div>
            <div class="form-group member_list" id="member_match_manager"><div class="row">
              <div class="col-md-2">
                <label>Waca</label>
              </div>
              <div class="col-md-2">
                <label>Vic</label>
              </div>
              <div class="col-md-8">
                <select class="form-control select2  team_member" name="teams[]" multiple="multiple">
                  <option selected>Suzy</option>
                  <option>Henry</option>
                  <option>Rita</option>
                </select>
              </div>
            </div></div>
            <div class="form-group member_list" id="member_match_manager"><div class="row">
              <div class="col-md-2">
                <label>Waca Sales</label>
              </div>
              <div class="col-md-2">
                <label>Jerry</label>
              </div>
              <div class="col-md-8">
                <select class="form-control select2  team_member" name="teams[]" multiple="multiple">
                  <option selected>Judy</option>
                  <option selected>Rock</option>
                  <option>Luby</option>
                </select>
              </div>
            </div></div>
          @endif
          </div>
          <div class="box-footer">
            <div class="pull-right">
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

