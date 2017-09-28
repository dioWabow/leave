<?php

namespace App\Http\Controllers;

use App\Leave;
use App\LeaveDay;
use App\Type;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{
    public function postIndex(Request $request)
    {
        $input = $request->input('setting');
        if (empty($input)) {

            $year = date('Y');
            $month = date('m');

        } else {

            $year = $input['year'];
            $month = $input['month'];

        }

        $model = new LeaveDay;
        $data_list = $model->search($year, $month);

        $userModel = new User;
        $all_user_tmp = $userModel->getAllUsers();

        // 離職人員判斷
        foreach ($all_user_tmp as $key => $value) {

            if (!empty($value['leave_date'])) {

                if (date('Y',strtotime($value['leave_date'])) < $year) {
                    unset($all_user_tmp[$key]);
                }

                if (date('m', strtotime($value['leave_date'])) < $month) {
                    unset($all_user_tmp[$key]);
                }
            }
        }

        // 讓key == user_id
        $all_user = [];
        foreach ($all_user_tmp as $value) {
            $all_user[$value->id] = $value;
        }

        $typeModel = new Type;
        $all_type_temp = $typeModel->getAllType();

        // 讓key 等同sql的id
        $all_type = [];
        foreach ($all_type_temp as $type_value) {
            $all_type[$type_value->id] = $type_value;
        }

        $compute_report_list = [];

        $report_list = self::getReport($all_user, $all_type, $data_list);
        $report_data = $report_list['result'];
        $report_total = $report_list['resultTotal'];

        return view('report', compact(
            'year', 'month', 'data_list',  'all_user', 'all_type', 'report_data', 'report_total'
        ));
    }

    public function getUserData()
    {
        $user_id = (!empty($_GET['user_id'])) ? $_GET['user_id'] : "";
        $type_id = (!empty($_GET['type_id'])) ? $_GET['type_id'] : "";
        $year = (!empty($_GET['year'])) ? $_GET['year'] : "";
        $month = (!empty($_GET['month'])) ? $_GET['month'] : "";

        $model = new Leave;
        $user_vacation_list = $model->userVacationList($user_id, $type_id, $year, $month);

        $typeModel = new Type;
        $all_type_temp = $typeModel->getAllType();

        $all_type = [];
        foreach ($all_type_temp as $type_value) {
            $all_type[$type_value->id] = $type_value;
        }

        return view('report_vacation',compact(
            'user_id', 'type_id', 'year', 'month', 'user_vacation_list', 'all_type'
        ));
    }

    private function getReport($all_user, $all_type, $data_list=[])
    {
        $sum = 0;
        $deductSum = 0;

        $result = [];
        $resultTotal = [];

        if (count($data_list) < 1) {
            foreach ($all_user as $user_key => $user_value) {

                foreach ($all_type as $type_key => $type_value) {

                    if (empty($result[$user_key][$type_key])) {

                        // user 的時數
                        $result[$user_key][$type_key] = 0;

                        // type 的時數
                        $resultTotal[$type_key] = 0;

                    }
                }
                        // 補 總和 跟 扣薪 的值
                        $result[$user_key]['sum'] = 0;
                        $result[$user_key]['deductions'] = 0;

                        $resultTotal['sum'] = 0;
                        $resultTotal['deductions'] = 0;
            }
        } else {
            foreach ($all_user as $user_key => $user_value) {

                $result[$user_key]['deductions'] = 0;
                $result[$user_key]['sum'] = 0;

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

                            if ($result[$user_key][$data_value['type_id']] == $type_key) {

                                if ($all_type[$data_value['type_id']]['deductions'] == 1) {

                                    $result[$user_key]['deductions'] += $data_value['hours'];

                                    // 補上 total 扣薪
                                    if (empty($resultTotal['deductions'])) {

                                        $deductSum += $data_value['hours'];

                                    }

                                    $resultTotal['deductions'] = $deductSum;

                                }

                            } else {

                                $resultTotal['deductions'] = $deductSum;

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
                        
                    } else {

                        // 沒有架別資料的人 都補0

                        foreach ($all_type as $type_key => $type_value) {

                            // user 的
                            if (empty($result[$user_key][$type_key])) {

                                $result[$user_key][$type_key] = 0;

                            }

                            // total 的
                            if (empty($resultTotal[$data_value['type_id']])) {

                                $resultTotal[$data_value['type_id']] = 0;

                            }
                        }

                            // user
                            if (empty($result[$user_key]['sum'])) {
                                $result[$user_key]['sum'] = 0;
                            }
                            if (empty($result[$user_key]['deductions'])) {
                                $result[$user_key]['deductions'] = 0;
                            }
                    }
                }
            }
        }
        
        return [
            'result' => $result, 'resultTotal' => $resultTotal
        ];
    }

}
