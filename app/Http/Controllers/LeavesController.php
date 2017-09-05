<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;

use Carbon\Carbon;
use Redirect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesController extends Controller
{
   /**
     * 列表-等待核准 tag 0,1,2,3,4
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
        
        $model = new Leave;
        
        $model->user_id = $user_id;
        $model->tag_id = [1,2,3,4,5,6];
        $model->fill($order_by);
        $dataProvider = $model->search($search);
        

        return  view('leave', compact(
            'dataProvider', 'search', 'model'
        ));
    }

     /**
     * 列表-即將放假 tag 7
     *
     * @return \Illuminate\Http\Response
    */
    public function getAccessLeaves(Request $request, $user_id)
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
        
        $model = new Leave;
        
        $model->user_id = $user_id;
        $model->tag_id = [7];
        $model->fill($order_by);
        $dataProvider = $model->search($search);

        return  view('leave', compact(
            'dataProvider', 'search', 'model'
        ));
    }

    /**
     * 列表-即將放假 tag select tag_id from leaves where user_id = id
     *
     * @return \Illuminate\Http\Response
    */
    public function getAllLeaves(Request $request, $user_id)
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
        
        $model->user_id = $user_id;
        $model->tag_id = [1,7,8];
        $model->fill($order_by);
        $dataProvider = $model->search($search);
        // $data = $this->checkDiffDays($dataProvider);

        return  view('leave', compact(
            'dataProvider', 'search', 'model'
        ));
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
     public function postDelete(Request $request, $id)
     {
         $model = $this->loadModel($id)->delete();
         
         return Redirect::route('leave')->withErrors(['msg' => '刪除完畢。']);
     }

    private function loadModel($id)
    {
        $model = Leave::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
            
        return $model;
    }

    // function checkDiffDays($data)
    // {
    //     $today = strtotime(date("Y-n-j"));

    //     foreach ($data as $value) {
    //         $tdehu = strtotime(Carbon::parse($value['start_time'])->format('Y-m-d'));
    //         dd($tdehu);
    //         $diff = ($tdehu - $today) / 86400;
    //         dd($diff);
    //     }
        
        
       
    // }
}
