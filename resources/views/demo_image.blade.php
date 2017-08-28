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
							<label for="demo_image" class="col-sm-2 control-label">圖片</label>
							<div class="col-sm-10">
								<input id="demo_image" name="demo[image]" class="file" type="file" data-max-file-count="1" multiple>
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
var $option = {'showUpload': false};

@if($image_url != '')
$option.initialPreview = ['{{route('root_path')}}{{$image_url}}'];
$option.initialPreviewAsData = true;
@endif

$("#demo_image").fileinput($option);
</script>
@stop
