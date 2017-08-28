@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-sitemap"></i> 團隊設定
	<small>Teams Setting</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li>基本設定</li>
	<li class="active">團隊設定</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">團隊清單</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="form-group"><div class="row">

						<div class="col-md-4">
							<form class="form-inline" id="menu-add" action="" method="POST">
								<div class="form-group">
									<input type="text" class="form-control" id="addInputName" placeholder="團隊名稱" required>
								</div>
								<button class="btn btn-info" id="addButton">新增</button>
							</form>
							<form class="form-inline" id="menu-editor" style="display: none;" action="" method="POST">
								<h3>修改 "<span id="currentEditName"></span>" 名稱</h3>
								<div class="form-group">
									<input type="text" class="form-control" id="editInputName" placeholder="團隊名稱" required>
								</div>
								<button class="btn btn-info" id="editButton">修改</button>
							</form>
						</div>
						<div class="col-md-8">
							<div class="dd nestable" id="nestable">
								<ol class="dd-list">
									<!--- Item1 --->
									<li class="dd-item" data-id="1" data-name="WACA-Team" data-new="0" data-deleted="0">
										<div class="dd-handle">WACA-Team</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="1">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="1">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>

										<!--- Item1 children --->
										<ol class="dd-list">
											<!--- Item4 --->
											<li class="dd-item" data-id="4" data-name="工程小組" data-new="0" data-deleted="0">
												<div class="dd-handle">工程小組</div>
												<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="4">
													<i class="fa fa-times-circle-o" aria-hidden="true"></i>
												</span>
												<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="4">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</span>
											</li>

											<!--- Item5 --->
											<li class="dd-item" data-id="5" data-name="業務小組" data-new="0" data-deleted="0">
												<div class="dd-handle">業務小組</div>
												<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="5">
													<i class="fa fa-times-circle-o" aria-hidden="true"></i>
												</span>
												<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="5">
													<i class="fa fa-pencil" aria-hidden="true"></i>
												</span>
											</li>
										</ol>
									</li>

									<!--- Item2 --->
									<li class="dd-item" data-id="2" data-name="WASHOP-Team" data-new="0" data-deleted="0">
										<div class="dd-handle">WASHOP-Team</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="2">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="2">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>
									</li>

									<!--- Item3 --->
									<li class="dd-item" data-id="3" data-name="PM" data-new="0" data-deleted="0">
										<div class="dd-handle">PM</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="3">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="3">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>
									</li>

									<!--- Item6 --->
									<li class="dd-item" data-id="6" data-name="SYSTEM" data-new="0" data-deleted="0">
										<div class="dd-handle">SYSTEM</div>
										<span class="button-delete btn btn-default btn-xs pull-right" data-owner-id="6">
											<i class="fa fa-times-circle-o" aria-hidden="true"></i>
										</span>
										<span class="button-edit btn btn-default btn-xs pull-right" data-owner-id="6">
											<i class="fa fa-pencil" aria-hidden="true"></i>
										</span>
									</li>
								</ol>
							</div>
						</div>
					</div></div>
				</div>
			</div>
		</div>

		<div class="col-md-12">
			<form action="" method="POST">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title">夥伴設定</h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>WACA-Team</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
						</div></div>

						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>WACA-Team / 工程小組</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
						</div></div>

						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>WACA-Team / 業務小組</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
						</div></div>

						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>WASHOP-Team</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
						</div></div>

						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>PM</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
						</div></div>

						<div class="form-group"><div class="row">
							<div class="col-md-2">
								<label>System</label>
							</div>
							<div class="col-md-8">
								<label>人員</label>
								<select class="form-control select2" name="teams[users][]" multiple="multiple" data-placeholder="請選擇隸屬人員">
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
								</select>
							</div>
							<div class="col-md-2">
								<label>主管</label>
								<select class="form-control select2" name="teams[users_manager][]" data-placeholder="請選擇主管">
									<option value="">請選擇主管</option>
									<option value="毛毛">毛毛</option>
									<option value="rita">Rita</option>
									<option value="lube">Lube</option>
									<option value="wei">Wei</option>
									<option value="rock">Rock</option>
									<option value="suzy">Suzy</option>
									<option value="rita">Rita</option>
									<option value="sheng">Sheng</option>
									<option value="henry">Henry</option>
									<option value="dio">Dio</option>
									<option value="eno">Eno</option>
									<option value="carol">Carol</option>
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
			</form>
		</div>
	</div>
<!-- /.content -->
@stop