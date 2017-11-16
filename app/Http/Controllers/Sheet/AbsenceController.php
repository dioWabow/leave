<?php

namespace App\Http\Controllers\Sheet;

use App\Absence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenceController extends Controller
{
    /**
     * 列表
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
    	$input = $request->input('setting');
        if (empty($input)) {

            $year = date('Y');
            $month = date('m');

        } else {

            $year = $input['year'];
            $month = $input['month'];

        }

        $dataAll = [];

        $model = new Absence;
        $dataProvider = $model->absenceReportSearch($year,$month);

        foreach ($dataProvider as $value) {
        	$dataAll[$value['user_id']] = $model->countUserId($value['user_id']);
        }

        return  view('absence_report', compact(
        	'year', 'month', 'dataProvider', 'dataAll'
        ));
    }
}
