@extends('default')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<i class="fa fa-plane"></i> 我要放假
	<small>Taken a lot of time off</small>
  </h1>
  <ol class="breadcrumb">
	<li><a href="./index.html"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">我要放假</li>
  </ol>
</section>

<!-- Main content -->
<form action="" method="POST" enctype="multipart/form-data">
	<section class="content">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">放假單</h3>
			</div>
			<div class="box-body">
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>假別</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="kindness-leave" hour="4"> 
							善待假
						</label>&emsp; 
						<label>
							<input type="radio" id="aaa" name="leave[type_id]" class="flat-red" value="birthday-leave" hour="8">
							生日假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="annual-leave" checked="checked"  hour="100">
							特休
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="special-leave" hour="8">
							久任假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="personal-leave" hour="112">
							事假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="sick-leave" hour="100">
							病假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value="marriage-leave" hour="100">
							婚假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" maternity-leave" hour="100">
							產假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" pre-maternity-leave" hour="100">
							產檢假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" paternity-leave" hour="100">
							陪產假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" funeral-leave" hour="100">
							喪假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" occupational-sickness-leave" hour="100">
							公傷病假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" family-care-leave" hour="100">
							家庭照顧假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" menstruation-leave" hour="8">
							生理假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" maternity-leave" hour="999">
							公假
						</label>&emsp; 
						<label>
							<input type="radio" name="leave[type_id]" class="flat-red" value=" compensatory-leave" hour="0">
							補休
						</label>&emsp; 
					</div>
				</div></div>
				<div class="form-group" id="group_timepicker"><div class="row">
					<div class="col-md-1">
						<label>日期</label>
					</div>
					<div class="col-md-11">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-clock-o"></i>
							</div>
							<input type="text" id="leave_timepicker" name="leave[timepicker]" class="form-control pull-right">
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label id="label_leave_spent_hours">請假時數</label>
						<label id="label_leave_dayrange">請假時段</label>
					</div>
					<div class="col-md-11" id="div_leave_spent_hours">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-hourglass-3"></i>
							</div>
							<input type="text" id="leave_spent_hours" name="leave[spent_hours]" class="form-control pull-right" disabled="disabled">
							<span class="input-group-addon">HR</span>
						</div>
					</div>
					<div class="col-md-11" id="div_leave_dayrange">
						<div class="input-group">
							<label>
								<input type="radio" id="leave_dayrange_allday" name="leave[dayrange]" class="flat-red" value="allday" checked> 
								全天
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_morning" name="leave[dayrange]" class="flat-red" value="morning"> 
								上午
							</label>&emsp; 
							<label>
								<input type="radio" id="leave_dayrange_afternoon"  name="leave[dayrange]" class="flat-red" value="afternoon"> 
								下午
							</label>&emsp; 
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>理由</label>
					</div>
					<div class="col-md-11">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-commenting-o"></i>
							</div>
							<input type="text" id="leave_timepicker" name="leave[timepicker]" class="form-control pull-right">
						</div>
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>代理人</label>
					</div>
					<div class="col-md-11">
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="毛毛"> 
							毛毛
						</label>&emsp; 
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="壽司"> 
							壽司
						</label>&emsp; 
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="Lube"> 
							Lube
						</label>&emsp; 
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="Dio"> 
							Dio
						</label>&emsp; 
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="Eno"> 
							Eno
						</label>&emsp; 
						<label>
							<input type="checkbox" name="leave[agent]" class="flat-red" value="Vic"> 
							Vic
						</label>&emsp; 
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>檔案上傳</label>
					</div>
					<div class="col-md-11">
						<input id="leave_fileupload" name="leave[fileupload][]" class="file" type="file" multiple data-min-file-count="1">
					</div>
				</div></div>
				<div class="form-group"><div class="row">
					<div class="col-md-1">
						<label>通知對象</label>
					</div>
					<div class="col-md-11">
						<select class="form-control select2" id="leave_notic_person" name="leave[notic_person]" multiple="multiple" data-placeholder="請選擇需另行通知的夥伴">
							<optgroup label="Ｗaca-Team">
								<option value="毛毛">毛毛</option>
								<option value="rita">Rita</option>
								<option value="lube">Lube</option>
								<option value="wei">Wei</option>
								<option value="rock">Rock</option>
							</optgroup>
							<optgroup label="Ｗaca-Engineer-Team">
								<option value="suzy">Suzy</option>
								<option value="rita">Rita</option>
								<option value="sheng">Sheng</option>
								<option value="henry">Henry</option>
							</optgroup>
							<optgroup label="Washop-Team">
								<option value="dio">Dio</option>
								<option value="eno">Eno</option>
								<option value="carol">Carol</option>
							</optgroup>
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
	</section>
</form>
<!-- /.content -->
@stop