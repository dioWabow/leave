<?php

namespace App\Http\Controllers;

use Auth;
use LeaveHelper;
use WebHelper;
use App\Leave;
use App\User;
use App\LeaveRespon;

use Redirect;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeavesHrController extends Controller
{
    /**
     * 列表-等待核准 Prvoe
     * HR可以看所有待核准的假單 tag 1,2,3,4
     *
     * @return \Illuminate\Http\Response
    */
    public function getProve(Request $request)
    {
        if (Auth::user()->role != 'hr') {

            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);

        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);
            
        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {

                $search['tag_id'] = [1,2,3,4];
                $request->session()->forget('leaves_hr');

            }
        }

        $model = new Leave;

        $search['tag_id'] = [1,2,3,4];
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }

     /**
     * 列表-即將放假 Upcoming 
     * HR可以看所有準假的假單 tag 9 (已準假)
     * 
     * @return \Illuminate\Http\Response
    */
    public function getUpcoming(Request $request)
    {
        if (Auth::user()->role != 'hr') {
            
            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);
            
        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);
            $search['tag_id'] = [9];

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {
                
                $search['tag_id'] = [9];
                $request->session()->forget('leaves_hr');

            }
        }

        $model = new Leave;
        $dataProvider = $model->fill($order_by)->search($search);

        return  view('leave_hr', compact(
            'search', 'model', 'dataProvider'
        ));
    }
    /**
     * 列表-歷史紀錄 History 
     * HR可以看所有的假單 tag 8,9
     *
     * @return \Illuminate\Http\Response
    */
    public function getHistory(Request $request)
    {
        if (Auth::user()->role != 'hr') {
            
            return Redirect::route('index')->withErrors(['msg' => '無權限可觀看']);
            
        }

        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('leaves_hr');
            $request->session()->push('leaves_hr.search', $search);
            $request->session()->push('leaves_hr.order_by', $order_by);
            
        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('leaves_hr')))) {

                $search = $request->session()->get('leaves_hr.search.0');
                $order_by = $request->session()->get('leaves_hr.order_by.0');

            } else {

                $search['tag_id'] = [8,9];
                $request->session()->forget('leaves_hr');

            }

        }
        
        if (!empty($search['daterange'])) {

            $daterange = explode(" - ", $search['daterange']);
            $search['start_time'] = $daterange[0];
            $search['end_time'] = $daterange[1];
            
            $order_by['start_time'] = $daterange[0];
            $order_by['end_time'] = $daterange[1];
            
        }

        $model = new Leave;
        $dataProvider= $model->fill($order_by)->search($search);

        return  view('leave_hr', compact(
            'dataProvider', 'search', 'model'
        ));
    }
}