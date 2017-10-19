<!DOCTYPE html>
<html>
<head>
	<title>report_annual_hours</title>
</head>
<body>
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr>
				<th width="3%"></th>
				<th>姓名</th>
				<th>到職日</th>
				<th>總額度</th>
				<th>使用額度</th>
				<th>剩餘額度</th>
			</tr>
		</thead>
		<tbody>
            @forelse($dataProvider as $annual_hour)
                @if($annual_hour->annual_hours>0)
    				<tr>
						<td></td>
                        <td>{{$annual_hour->fetchUser->nickname}}</td>
                        <td>{{TimeHelper::changeDateFormat($annual_hour->fetchUser->enter_date,'Y-m-d')}}</td>
						<td>{{$annual_hour->annual_hours}}</td>
						<td>{{$annual_hour->used_annual_hours}}</td>
						<td>{{$annual_hour->remain_annual_hours}}</td>
    				</tr>
                @endif
            @empty
                <tr class='clickable-row'>
                    <td colspan="6" align="center">
                    	<span class="glyphicon glyphicon-search"> 沒有查詢到相關結果</span>
                    </td>
                </tr>
             @endforelse
		</tbody>
            @if(count($dataProvider)>0)
			<tfoot>
				<tr class="text-red">
					<td></td>
					<td></td>
					<th class="pull-right">總計(Hr)</th>
					<td><span style="color: #FF0000;">{{$dataAll['annual_hours']}}</span></td>
					<td><span style="color: #FF0000;">{{$dataAll['used_annual_hours']}}</span></td>
					<td><span style="color: #FF0000;">{{$dataAll['remain_annual_hours']}}</span></td>
				</tr>
			</tfoot>
            @endif
	</table>
</body>
</html>