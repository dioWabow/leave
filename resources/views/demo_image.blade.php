@extends('default')

@section('content')
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">圖片上傳 DEMO</h3>
				</div>
				<form id="form_image" action="" class="form-horizontal" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div class="box-body">
						<div class="form-group">
							<label for="demo_image" class="col-sm-2 control-label">多筆圖片</label>
							<div class="col-sm-10">
								<input id="demo_image" name="demo_image[]" class="file" type="file" data-max-file-count="2" multiple>
							</div>
						</div>

						<div class="form-group">
							<label for="demo_image2" class="col-sm-2 control-label">單筆圖片</label>
							<div class="col-sm-10">
								<input id="demo_image2" name="demo_image2" class="file" type="file" data-max-file-count="1" multiple>
							</div>
						</div>
					</div>
					<!-- /.box-body -->
					<div class="box-footer">
						<button type="submit" class="btn btn-info pull-right">送出</button>
					</div>
					<!-- /.box-footer -->
				</form>
			</div>
		</div>
	</div>
</section>

<script>
//多筆圖片
var $option = {'showUpload': false};

@if($result)
var $initialPreview = [];
@foreach ($result as $filename)
$initialPreview.push('{{route('root_path')}}{{$image_path}}{{$filename}}');
@endforeach

$option.initialPreview = $initialPreview;
$option.initialPreviewAsData = true;
@endif

$("#demo_image").fileinput($option);

//單筆圖片
var $option2 = {'showUpload': false};

@if($single_filename)
$option2.initialPreview = ['{{route('root_path')}}{{$image_path2}}{{$single_filename}}'];
$option2.initialPreviewAsData = true;
@endif

$("#demo_image2").fileinput($option2);
</script>
@stop
