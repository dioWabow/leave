@extends('default')

@section('content')
<section class="content-header">
  <h1>
  <i class="fa fa-anchor"></i> 國定假日/補班資料{{ $model->id > 0 ? '修改' : '新增' }}
  <small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
  <li><a href="{{ route('index') }}"><i class="fa fa-dashboard"></i> Home</a></li>
  <li>假期設定</li>
  <li><a href="{{ route('holidies') }}">國定假日/補班</a></li>
  <li class="active">資料{{ $model->id > 0 ? '修改' : '新增' }}</li>
  </ol>
</section>

<!-- Main content -->
<form action="{{ route($model->id > 0 ? 'holidayUpdate' : 'holidayCreate') }}" method="POST" enctype="multipart/form-data">
  <section class="content">
    <div class="box box-info">
      <div class="box-header with-border">
        <h3 class="box-title">{{$model->name}} {{ $model->id > 0 ? '修改' : '新增' }}資料</h3>
      </div>
      <div class="box-body">
        <div class="form-group"><div class="row">
          <div class="col-md-1">
            <label>類型</label>
          </div>
          <input type="hidden" name="holidies[id]" value="{{$model->id}}">
          <div class="col-md-11">
            <label>
              <input type="radio" name="holidies[type]" class="flat-red" value="holiday"@if( "{{$model->type}}" == "{{holiday}}")checked="checked"@endif>
              國定假日
            </label>&emsp;
            <label>
              <input type="radio" name="holidies[type]" class="flat-red" value="work"@if( "{{$model->type}}" == "{{work}}")checked="checked"@endif>
              工作日
            </label>&emsp;
          </div>
        </div></div>

        <div class="form-group"><div class="row">
          <div class="col-md-1">
            <label>名稱</label>
          </div>
          <div class="col-md-11">
            <input type="text" id="holidies_title" name="holidies[name]" class="form-control pull-right" value="{{$model->name}}">
          </div>
        </div></div>
        <div class="form-group"><div class="row">
          <div class="col-md-1">
            <label>日期</label>
          </div>
          <div class="col-md-11">
            <input type="text" id="holidies_date" name="holidies[date]" class="form-control pull-right" @if("{{$model->date}}" > "{{0}}")date="{{ Carbon\Carbon::parse($model->date)->format('Y-m-d') }} @endif ">
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
  <!-- laravel post需要不然會有in VerifyCsrfToken.php error -->
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
</form>
<!-- /.content -->
@stop
