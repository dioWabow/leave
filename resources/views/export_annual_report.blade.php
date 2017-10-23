<!DOCTYPE html>
<html>
<head>
	<title>report_annual_export 特休報表</title>
</head>
<body>
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th width="10%">姓名</th>
				<th width="13%">到職日</th>
				<th>{{ $search['year'] }}年額度</th>
				<th>{{ $search['year'] + 1 }}年額度</th>
				<th>使用額度</th>
				<th>剩餘額度</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($dataProvider as $value)
	            <tr>
					<td>{{ $value->fetchUser->name }}</td>
					<td>{{ TimeHelper::changeDateFormat($value->fetchUser->enter_date,'Y-m-d') }}</td>
					<td>{{ $value->annual_this_years }}</td>
					<td>{{ $value->annual_next_years }}</td>
					<td>{{ $value->used_annual_hours }}</td>
					<td>{{ $value->remain_annual_hours }}</td>
				</tr>
            @empty
                <tr class="clickable-row">
                  <td colspan="6" align="center">
                    無資料
                  </td>
                </tr>
            @endforelse
		</tbody>
            @if(count($dataProvider)>0)
				<tfoot>
					<tr class="text-red">
						<th></th>
						<th class="pull-right">總計(Hr)</th>
						<td><span style="color: #FF0000;">{{ $dataAll['annual_this_years'] }}</span></td>
						<td><span style="color: #FF0000;">{{ $dataAll['annual_next_years'] }}</span></td>
						<td><span style="color: #FF0000;">{{ $dataAll['used_annual_hours'] }}</span></td>
						<td><span style="color: #FF0000;">{{ $dataAll['remain_annual_hours'] }}</span></td>
					</tr>
				</tfoot>
            @endif
	</table>
</body>
</html>