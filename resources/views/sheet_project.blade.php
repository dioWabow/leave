
@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="glyphicon glyphicon-file"></i> 專案項目
	<small>Project Management</small>
  </h1>
  {{ Breadcrumbs::render('sheet/project/index') }}
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="dataTables_wrapper form-inline dt-bootstrap">
						<div class="row">
							<div class="col-sm-3">
								<div class="dataTables_length">
                  <form name="frmSearch" action="{{ route('sheet/project/index') }}?page=1" method="POST">
									<label>
										每頁 
										<select name="search[pagesize]" class="form-control input-sm">
											<option value="25"@if( "{{ $model->pagesize }}" == "{{25}}")selected="selected"@endif>25</option>
                      <option value="50"@if( "{{ $model->pagesize }}" == "{{50}}")selected="selected"@endif>50</option>
                      <option value="100"@if( "{{ $model->pagesize }}" == "{{100}}")selected="selected"@endif>100</option>
										</select>
                    筆
									</label>
                </div>
              </div>
              <div class="col-sm-9">
                  <div class="pull-right">
                    <label>
                      團隊：
                      <select id="search_team" name="search[team]" class="form-control">
                        <option value="all" @if($model->team == 'all') selected="selected" @endif>全部</option>
                        @foreach($all_team as $team_data)
                          <option value="{{$team_data->id}}" @if($model->team == $team_data->id) selected="selected" @endif>{{$team_data->name}}</option>
                        @endforeach
                      </select>
                    </label>
                    &nbsp;
                    <label>
                      狀態：
                      <select name="search[status]" class="form-control">
                        <option value="all" @if($model->status == 'all') selected="selected" @endif>全部</option>
                        <option value="1" @if($model->status == '1') selected="selected" @endif>開啟</option>
                        <option value="0" @if($model->status == '0') selected="selected" @endif>關閉</option>
                      </select>
                    </label>
                    &nbsp;
                    <label>
                      關鍵字：
                      <input type="search" class="form-control" placeholder="請輸入專案進行查詢" name="search[keywords]" style="width:270px" value="{{$model->keywords}}">
                      <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                      <a href="{{ route('sheet/project/create') }}"><button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button></a>
                    </label>
                  </div>
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </form>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <table class="table table-bordered table-striped table-hover">
                  <thead>
                    <tr>
                      <th width="20%">專案</a></th>
                      <th width="20%">團隊</a></th>
                      <th width="4%">狀態</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($project as $project_data)
                      <tr class="clickable-row" data-href="{{ route('sheet/project/edit', ['id' => $project_data->id]) }}">
                        <td>{{$project_data->name}}</td>
                        <td>
                          @foreach (App\ProjectTeam::getProjectTeamByProjectId($project_data->id) as $team)
                            @if(!empty($team->fetchTeam))
                              <small class="label" style="background-color:{{$team->fetchTeam->color}};">{{$team->fetchTeam->name}}</small>
                            @endif
                          @endforeach
                        </td>
                        <td>
                          <input type="checkbox" name="sheet_project[status]" class="sheet_project_status" data-toggle="toggle" data-on="開啟" data-off="關閉" @if ($project_data->available == '1') checked="checked" @endif>
                        </td>
                      </tr>
                    @empty
                    <tr>
                      <td colspan="8" align="center"><span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span></td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
            {!! $project->render() !!}
          </div>
        </div>
			</div>
		</div>
	</div>
</section>
@stop