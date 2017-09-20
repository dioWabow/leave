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

        // dd($month);

        $order_by = $request->input('order_by');
        if (empty($order_by)) {

            $order_type = "";
            $order_way = "";

        } else {

            $order_type = $order_by['order_by'];
            $order_way = $order_by['order_way'];

        }

        $model = new LeaveDay;
        $data_list = $model->search($year, $month);

        $userModel = new User;
        $all_user_tmp = $userModel->getAllUsers();

        // 離職人員判斷
        foreach ($all_user_tmp as $key => $value) {

            if (!empty($value['leave_date'])) {
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
        $all_type_temp = $typeModel->getAllTypes();

        // 讓key 等同sql的id
        $all_type = [];
        foreach ($all_type_temp as $type_value) {
            $all_type[$type_value->id] = $type_value;
        }

        $compute_report_list = [];

        $report_list = self::getReport($all_user, $all_type, $data_list);
        $report_data = $report_list['result'];
        $report_total = $report_list['resultTotal'];

        // 如果是排序才要進入
        if(isset($order_by) && !empty($order_type)) {

            // report 是誰 order_type 該 type 的小時
            foreach ($report_data as $report_key => $report_value) {
                $compute_report_list[$report_key] = $report_value[$order_type];
            }

            if ($order_way == "DESC") {
                arsort($compute_report_list);
            } else {
                asort($compute_report_list);
            }

            $new_user_sort = [];
            foreach ($compute_report_list as $user_id => $hours) {
                $new_user_sort[] = $user_id;
            }

            $all_user_moment = $all_user;

            $all_user_sort = [];
            foreach ($new_user_sort as $value) {
                unset($all_user[$value]);
                $all_user[] = $all_user_moment[$value];
            }
        }

        return view('report', compact(
            'year', 'month','order_by', 'data_list',  'all_user', 'all_type', 'report_data', 'report_total'
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

                        $result[$user_key]['sum'] = 0;
                        $result[$user_key]['deductions'] = 0;

                        $resultTotal['sum'] = 0;
                        $resultTotal['deductions'] = 0;
            }
        } else {
            foreach ($all_user as $user_key => $user_value) {
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

                            // total 的補 0
                            if (empty($resultTotal[$type_key])) {

                                $resultTotal[$type_key] = 0;

                            }
                        }

                        // 補上 total

                        if (empty($result[$user_key]['sum'])) {

                            $result[$user_key]['sum'] = $data_value['hours'];

                        } else {

                            $result[$user_key]['sum'] += $data_value['hours'];

                        }

                        // 補上 扣薪

                        if (!empty($data_value['deductions'])) {

                            if (empty($result[$user_key]['deductions'])) {

                                $result[$user_key]['deductions'] = $data_value['hours'];

                            } else {

                                $result[$user_key]['deductions'] += $data_value['hours'];

                            }
                        } else {

                            $result[$user_key]['deductions'] = "0";

                        }

                        // 補上 total sum
                        $resultTotal['sum'] = $sum;

                        // 補上 total 扣薪
                        if (!empty($data_value['deductions'])) {

                            if (empty($resultTotal['deductions'])) {

                                $deductSum += $data_value['hours'];

                            }

                        }

                        $resultTotal['deductions'] = $deductSum;

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

        // dd($result);

        return [
            'result' => $result, 'resultTotal' => $resultTotal
        ];
    }

}
