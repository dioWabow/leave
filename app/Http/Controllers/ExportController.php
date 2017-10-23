<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveDay;
use App\LeavedUser;
use App\Type;
use App\User;
use App\AnnualYear;
use App\AnnualHour;
use Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExportController extends Controller
{
	// 匯出報表
    public function ExportReport($year, $month)
    {
    	$GLOBALS['year'] = $year;
    	$GLOBALS['month'] = $month;

    	Excel::create('export_report', function($excel){

    		$excel->sheet('export_report', function($sheet){

    			$year = $GLOBALS['year'];
    			$month = $GLOBALS['month'];

    			$model = new LeaveDay;
        		$data_list = $model->search($year, $month);

    			$typeModel = new Type;
		        $all_type_temp = $typeModel->getAllType();

		        // 讓key 等同sql的id
		        $all_type = [];
		        foreach ($all_type_temp as $type_value) {
		            $all_type[$type_value->id] = $type_value;
		        }

		        $userModel = new User;
        		$all_user_tmp = $userModel->getAllUsers();

        		$all_user = [];
		        foreach ($all_user_tmp as $value) {
		            $all_user[$value->id] = $value;
		        }

		        $report_list = self::getReport($all_user, $all_type, $data_list);
        		$report_data = $report_list['result'];
        		$report_total = $report_list['resultTotal'];

    			$sheet->loadView('report_export', array('year' => $year, 'month' => $month, 'all_type' => $all_type, 'all_user' => $all_user, 'data_list' => $data_list, 'report_data' => $report_data, 'report_total' => $report_total));
    		});

    	})->export('xlsx');
    }

    // 匯出報表用的 function
    private function getReport($all_user, $all_type, $data_list=[])
    {
        $sum = 0;
        $deductSum = 0;

        $result = [];
        $resultTotal = [];

        foreach ($all_user as $user_key => $user_value) {

            $result[$user_key]['sum'] = 0;
            $result[$user_key]['deductions'] = 0;

            // 有資料的 判斷
            foreach ($data_list as $data_key => $data_value) {
                if ($user_key == $data_value['user_id']) {

                    // resultTotal 計算 有值的欄位加總
                    $sum += $data_value['hours'];

                    if (empty($resultTotal[$data_value['type_id']])) {

                        $resultTotal[$data_value['type_id']] = $data_value['hours'];

                    } else {

                        $resultTotal[$data_value['type_id']] += $data_value['hours'];

                    }

                    //把 user_key 的價別資料抓出&加總

                    if (empty($result[$user_key][$data_value['type_id']])) {

                        $result[$user_key][$data_value['type_id']] = $data_value['hours'];

                    } else {

                        $result[$user_key][$data_value['type_id']] += $data_value['hours'];

                    }

                    // 如果 是空的 價別 補 0

                    foreach ($all_type as $type_key => $type_value) {

                        // user 的補 0
                        if (empty($result[$user_key][$type_key])) {

                            $result[$user_key][$type_key] = 0;

                        }

                        // 補上 扣薪

                        $resultTotal['deductions'] = $deductSum;

                        if ($result[$user_key][$data_value['type_id']] == $type_key) {

                            if ($all_type[$data_value['type_id']]['deductions'] == 1) {

                                $result[$user_key]['deductions'] += $data_value['hours'];

                                // 補上 total 扣薪
                                if (empty($resultTotal['deductions'])) {

                                    $deductSum += $data_value['hours'];

                                }

                                $resultTotal['deductions'] = $deductSum;

                            }

                        }

                        // total 的補 0
                        if (empty($resultTotal[$type_key])) {

                            $resultTotal[$type_key] = 0;

                        }

                    }

                    // 補上 total
                    $result[$user_key]['sum'] += $data_value['hours'];

                    // 補上 total sum
                    $resultTotal['sum'] = $sum;

                }
            }

            // 沒資料的 判斷
            foreach ($all_type as $type_key => $type_value) {

                // user 的
                if (empty($result[$user_key][$type_key])) {

                    $result[$user_key][$type_key] = 0;

                }

                // total 的
                if (empty($resultTotal[$type_key])) {

                    $resultTotal[$type_key] = 0;

                }

                // user
                if (empty($result[$user_key]['sum'])) {

                    $result[$user_key]['sum'] = 0;

                }

                if (empty($result[$user_key]['deductions'])) {

                    $result[$user_key]['deductions'] = 0;

                }

                if (empty($resultTotal['sum'])) {

                    $resultTotal['sum'] = 0;

                }

                if (empty($resultTotal['deductions'])) {

                    $resultTotal['deductions'] = 0;

                }
            }
        }

        return [
            'result' => $result, 'resultTotal' => $resultTotal
        ];
    }

    // 匯出特休報表
    public function ExportAnnualReport($year)
    {
    	$GLOBALS['year'] = $year;

    	Excel::create('export_report', function($excel){

    		$excel->sheet('export_report', function($sheet){

    			$search['year'] = $GLOBALS['year'];

    			$dataAll = ['annual_this_years' => 0 ,'annual_next_years' => 0 , 'used_annual_hours' => 0  , 'remain_annual_hours' => 0 ];

		        $model = new AnnualYear;
		        $dataProvider = $model->search($search);

		        foreach ( $dataProvider as $data) {

	                $dataAll['annual_this_years'] += $data->annual_this_years;
	                $dataAll['annual_next_years'] += $data->annual_next_years;
	                $dataAll['used_annual_hours'] += $data->used_annual_hours;
	                $dataAll['remain_annual_hours'] += $data->remain_annual_hours;

		        }

    			$sheet->loadView('report_annual_export', array('search' => $search, 'model' => $model, 'dataProvider' => $dataProvider, 'dataAll' => $dataAll));
    		});

    	})->export('xlsx');
    }

    // 匯出特休結算
    public function ExportAnnualHoursReport($year)
    {
    	$GLOBALS['year'] = $year;

    	Excel::create('export_report', function($excel){

    		$excel->sheet('export_report', function($sheet){

    			$search['year'] = $GLOBALS['year'];

    			$dataAll = ['annual_hours' => 0 , 'used_annual_hours' => 0  , 'remain_annual_hours' => 0 ];

		        $model = New AnnualHour;
		        $dataProvider = $model->search($search);

		        foreach ( $dataProvider as $data) {

		            $dataAll['annual_hours'] += $data->annual_hours;
		            $dataAll['used_annual_hours'] += $data->used_annual_hours;
		            $dataAll['remain_annual_hours'] += $data->remain_annual_hours;

		        }

    			$sheet->loadView('report_annual_hours', array('search' => $search, 'model' => $model, 'dataProvider' => $dataProvider, 'dataAll' => $dataAll));
    		});

    	})->export('xlsx');
    }

    // 匯出特休結算(離職)
    public function ExportLeavedHoursReport($year)
    {
        $GLOBALS['year'] = $year;

        Excel::create('Leaved_Hour', function($excel){

            $excel->sheet('Leaved_Hour', function($sheet){

                $search['year'] = $GLOBALS['year'];

                $dataAll = ['annual_hours' => 0 , 'used_annual_hours' => 0  , 'remain_annual_hours' => 0 ];

                $model = New LeavedUser;
                $dataProvider = $model->search($search);

                foreach ( $dataProvider as $data) {

                    $dataAll['annual_hours'] += $data->annual_hours;
                    $dataAll['used_annual_hours'] += $data->used_annual_hours;
                    $dataAll['remain_annual_hours'] += $data->remain_annual_hours;

                }

                $sheet->loadView('report_leaved_hour', array('search' => $search, 'dataProvider' => $dataProvider, 'dataAll' => $dataAll));
            });

        })->export('xlsx');
    }
}
