@if(session()->has('success'))
    <div class="alert alert-success msg_alert">
    <h4><i class="icon fa fa-check"></i> 成功</h4>
    <ul>
        <li>{{ session()->get('success') }}</li>
    </ul>
    </div>
@elseif(($errors->any()))
 	<div class="alert alert-danger msg_alert">
	<h4><i class="icon fa fa-ban"></i> 錯誤</h4>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
  </div>
@endif