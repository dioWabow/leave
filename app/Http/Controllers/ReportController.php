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
    	$model = new LeaveDay;

    	$userModel = new User;

    	$typeModel = new Type;

    	$data_list = $model->search();

    	$all_user = $userModel->getAllUsers();

    	$all_type = $typeModel->getAllTypes();

    	$sum = 0;

    	$report_list = self::getReport($all_type, $data_list);

    	$report_type_total = self::getTypeTotal($all_type, $data_list);

        return view('report', compact(
            'data_list',  'all_user', 'all_type', 'report_list', 'report_type_total'
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
