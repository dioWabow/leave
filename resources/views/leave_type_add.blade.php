@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-anchor"></i> 假別資料修改
	<small>Vacation Category Management</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>假期設定</li>
	<li><a href="./users.html">假別管理</a></li>
	<li class="active">資料修改</li>
  </ol>
</section>


    <!-- Main content -->
    <form action="{{ route('add') }}" method="POST" enctype="multipart/form-data">
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">新增假別資料</h3>
                </div>
                <div class="box-body">
                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>名稱</label>
                        </div>
                        <div class="col-md-11">
                            <input type="text" id="leave_type_name" name="leave_type[name]" class="form-control pull-right" value="">
                        </div>
                    </div></div>

                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>類型</label>
                        </div>
                        <div class="col-md-11">
                            <label>
                                <input type="radio" name="leave_type[exception]" class="flat-red" value="normal" checked="checked">
                                一般
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[exception]" class="flat-red" value="job_seek">
                                謀職假
                            </label>&emsp;
                                <input type="radio" id="leave_type_kind" name="leave_type[exception]" class="flat-red" value="paid_sick">
                                有薪病假
                            </label>&emsp;
                            <label>
                                <input type="radio" id="leave_type_kind" name="leave_type[exception]" class="flat-red" value="sick">
                                無薪病假
                            </label>&emsp;
                            <label>
                                <input type="radio" id="leave_type_kind" name="leave_type[exception]" class="flat-red" value="entertain">
                                善待假
                            </label>&emsp;
                            <label>
                                <input type="radio" id="leave_type_kind" name="leave_type[exception]" class="flat-red" value="annaul_leave">
                                特休
                            </label>&emsp;
                            <label>
                                <input type="radio" id="leave_type_kind" name="leave_type[exception]" class="flat-red" value="birthdayyear">
                                生日假
                            </label>&emsp;
                        </div>
                    </div></div>

                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>重置形式</label>
                        </div>
                        <div class="col-md-11">
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="none" checked="checked">
                                不重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="week">
                                每週重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="month">
                                每月重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="season">
                                每季重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="season">
                                每年重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="year">
                                每季重置
                            </label>&emsp;
                            <label>
                                <input type="radio" name="leave_type[reset_time]" class="flat-red" value="other">
                                其他
                            </label>&emsp;
                        </div>
                    </div></div>

                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>上限（HR)</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" id="leave_type_hours" name="leave_type[hours]" class="form-control pull-right" value="">
                        </div>
                        <div class="col-md-6">
                            <label class="text-red">(0 為無上限)</label>
                        </div>
                    </div></div>

                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>理由</label>
                        </div>
                        <div class="col-md-11">
                            {{--  <input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否" >  --}}
                            <input type="checkbox" name="leave_type[reason]" class="leave_type_reason" data-toggle="toggle" data-on="是" data-off="否">
                        </div>
                    </div></div>
                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>證明</label>
                        </div>
                        <div class="col-md-11">
                            <input type="checkbox" name="leave_type[prove]" class="leave_type_prove" data-toggle="toggle" data-on="是" data-off="否" >
                        </div>
                    </div></div>
                    <div class="form-group"><div class="row">
                        <div class="col-md-1">
                            <label>狀態</label>
                        </div>
                         <div class="col-md-11">
                             <input type="checkbox" name="leave_type[available]" class="leave_type_available" data-toggle="toggle" data-on="開啟" data-off="關閉" >
                        </div>
                    </div></div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <button type="reset" class="btn btn-default" onclick="history.go(-1)"><i class="fa fa-undo"></i> 取消</button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-send-o"></i> Send</button>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </form>
    <!-- /.content -->
@stop
