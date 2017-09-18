<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveDay;
use App\Type;
use App\User;
use Redirect;
use Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    public function getIndex()
    {
        $year = date('Y');

        $month = date('m');

    	$model = new LeaveDay;

    	$userModel = new User;

    	$typeModel = new Type;

    	$data_list = $model->search($year, $month);

    	$all_user = $userModel->getAllUsers();

    	$all_type = $typeModel->getAllTypes();

    	$report_list = self::getReport($all_type, $data_list);

    	$report_type_total = self::getTypeTotal($all_type, $data_list);

        return view('report', compact(
            'data_list',  'all_user', 'all_type', 'report_list', 'report_type_total'
        ));
    }

    public function postSearch(Request $request)
    {
        $input = $request->input('setting');
        $order_by = $request->input('order_by');

        $year = $input['year'];

        $month = $input['month'];

        $order_type = $order_by['order_by'];

        $order_way = $order_by['order_way'];

        $model = new LeaveDay;

        $userModel = new User;

        $typeModel = new Type;

        $data_list = $model->search($year, $month);

        $all_user_tmp = $userModel->getAllUsers();

        $all_user = [];
        foreach ($all_user_tmp as $key => $value) {
            $all_user[$value->id] = $value;
        }

        $all_type = $typeModel->getAllTypes();

        $compute_report_list = [];

        $report_list = self::getReport($all_type, $data_list);

        foreach ($report_list as $key => $value) {
            $compute_report_list[$key] = $value[$order_type];
        }

        if($order_way == "DESC"){
            arsort($compute_report_list);
        } else {
            asort($compute_report_list);
        }

        $new_user_sort = [];
        foreach ($compute_report_list as $user_id => $hours) {
            $new_user_sort[] = $user_id;
        }

        $all_user_tmp = $all_user;

        unset($all_user);

        $all_user_sort = [];
        foreach ($new_user_sort as $value) {
            $all_user[] = $all_user_tmp[$value];
        }

        $report_type_total = self::getTypeTotal($all_type, $data_list);

        return view('report', compact(
            'order_by', 'data_list',  'all_user', 'all_type', 'report_list', 'report_type_total'
        ));
    }

    private function getReport($all_type, $data_list)
    {
    	$sum = 0;

    	$result = [];

    	foreach ($data_list as $key => $value) {

    		if (empty($result[$value['user_id']][$value['type_id']])){

    			$result[$value['user_id']][$value['type_id']] = $value['hours'];

    		} else {

    			$result[$value['user_id']][$value['type_id']] += $value['hours'];

    		}

    		foreach ($all_type as $type_key => $type_value) {
    			if(empty($result[$value['user_id']][$type_value->id])) {
    				$result[$value['user_id']][$type_value->id] = "0";
    			}
    		}

    		if (empty($result[$value['user_id']]['sum'])){

    			$result[$value['user_id']]['sum'] = $value['hours'];

    		} else {

    			$result[$value['user_id']]['sum'] += $value['hours'];

    		}

    		if (!empty($value['deductions'])) {
    			if (empty($result[$value['user_id']][$value['deductions']])){
    				$result[$value['user_id']]['deductions'] = $value['hours'];
    			} else {
    				$result[$value['user_id']]['deductions'] += $value['hours'];
    			}
    		} else {
    			$result[$value['user_id']]['deductions'] = "0";
    		}
    	}

    	return $result;

    }

    private function getTypeTotal($all_type, $data_list)
    {
    	$sum = 0;

    	$result = [];

    	foreach ($data_list as $value) {

    		$sum += $value['hours'];

    		if (empty($result[$value['type_id']])){

    			$result[$value['type_id']] = $value['hours'];

    		} else {

    			$result[$value['type_id']] += $value['hours'];

    		}

    		foreach ($all_type as $type_key => $type_value) {
    			if(empty($result[$type_value->id])) {
    				$result[$type_value->id] = "0";
    			}
    		}

    		$result['sum'] = "$sum";

    		if(!empty($value['deductions'])) {
    			if (empty($result[$value['deductions']])){
    				$result['deductions'] = $value['hours'];
    			} else {
    				$result['deductions'] += $value['hours'];
    			}
    		} else {
    			$result['deductions'] = "0";
    		}
    	}

    	return $result;
    }
}
