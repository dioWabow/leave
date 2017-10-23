<!DOCTYPE html>
<html>
<head>
	<title>report_export 報表</title>
	<meta charset="utf-8">
</head>
<body>
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th><a>名稱</a></th>
				@foreach($all_type as $type_data)
				<th><a>{{$type_data->name}}</a></th>
				@endforeach
				<th><a>總計(Hr)</a></th>
				<th><a>扣薪</a></th>
			</tr>
		</thead>
		<tbody>
			@foreach($all_user as $user_data)
				<tr class="clickable-row">
					<td>{{$user_data->nickname}}</td>
					@foreach($all_type as $type_data)
					<td>
						{{$report_data[$user_data->id][$type_data->id]}}
					</td>
					@endforeach
					<td class="text-red">{{$report_data[$user_data->id]['sum']}}</td>
					<td><span class="label bg-red" style="color: #FF0000;">{{$report_data[$user_data->id]['deductions']}}</span></td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr class="text-red">
				<th class="pull-right">總計(Hr)</th>
					@foreach($all_type as $key => $type_data)
					<td class="text-red">{{$report_total[$key]}}</td>
				@endforeach
            	<td class="text-red">{{$report_total['sum']}}</td>
            	<td><span class="label bg-red" style="color: #FF0000;">{{$report_total['deductions']}}</span></td>
			</tr>
		</tfoot>
	</table>
</body>
</html>