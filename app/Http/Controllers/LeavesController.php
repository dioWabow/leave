<?php

namespace App\Http\Controllers;

use App\Leave;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesController extends Controller
{
   /**
     * 列表
     *
     * @return \Illuminate\Http\Response
    */
    public function getIndex(Request $request, $user_id)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves');
            $request->session()->push('leaves.search', $search);
            $request->session()->push('leaves.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves')))) {

                $search = $request->session()->get('leaves.search.0');
                $order_by = $request->session()->get('leaves.order_by.0');

            } else {

                $request->session()->forget('leaves');

            }
        }
        if (!empty($search['daterange'])) {
            
            $daterange = explode(" - ", $search['daterange']);

            $search['start_time'] = $daterange[0];
            $search['end_time'] = $daterange[1];
            
        }

        $model = new Leave;
        $model->fill($order_by, $user_id);
        $dataProvider = $model->search($search);
        
        return  view('leave', compact(
            'dataProvider', 'search', 'model'
        ));
    }

    private function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
            
        return $model;
    }

}
