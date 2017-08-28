@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-hand-spock-o"></i> 協助申請請假
	<small>Taken a lot of time off</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">協助申請請假</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">請選擇欲請假對象</h3>
			</div>
			<div class="box-body">
				<ul class="mailbox-attachments clearfix">
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/neo.png" class="img-circle" alt="Neo"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Neo</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/default.png" class="img-circle" alt="毛毛"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> 毛毛</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/suzy.png" class="img-circle" alt="Suzy"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Suzy</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/rita.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Rita</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/sheng.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Sheng</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/henry.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Henry</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/default.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Stephanie</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/wei.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Wei</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/rock.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Rock</a>
						</div>
					</li>
					<li class='clickable-row' data-href='leave_form3.html'>
						<span class="mailbox-attachment-icon has-img"><img src="dist/img/users/jerry.png" class="img-circle"></span>

						<div class="mailbox-attachment-info">
							<a href="#" class="mailbox-attachment-name"><i class="fa fa-user"></i> Jerry</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
</form>
<!-- /.content -->
@stop