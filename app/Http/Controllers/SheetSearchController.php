<?php

namespace App\Http\Controllers;

use App\Timesheet;
use App\Leave;
use App\UserTeam;
use App\ProjectTeams;
use App\TimesheetPermission;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SheetSearchController extends Controller
{
    /**
     * 首頁
     *
     */
    public static function getIndex(Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];
        if (!empty($search) || !empty($order_by)) {

            $request->session()->forget('timesheets');
            $request->session()->push('timesheets.search', $search);
            $request->session()->push('timesheets.order_by', $order_by);

        } else {

            if (!empty($request->input('page') && !empty($request->session()->get('timesheets')))) {

                $search = $request->session()->get('timesheets.search.0');
                $order_by = $request->session()->get('timesheets.order_by.0');

            } else {

                $request->session()->forget('timesheets');

            }
        }

        if (!empty($search['daterange'])) {

            $daterange = explode(" - ", $search['daterange']);
            $search['start_time'] = $daterange[0];
            $search['end_time'] = $daterange[1];

            $order_by['start_date'] = $daterange[0];
            $order_by['end_date'] = $daterange[1];

        }

        $allow_users = [];
        $allow_users_id = [];
        $allow_users_not_self = TimesheetPermission::getAllowUserIdByUserId( Auth::user()->id );
        if ( !empty($allow_users_not_self) ) {

            foreach ($allow_users_not_self as $key => $value) {

                $allow_users[] = $value;
                $allow_users_id[] = $value->allow_user_id;

            }

        }

        $allow_users_id[] = Auth::user()->id;

        $model = new TimeSheet;
        $dataProvider = $model->fill($order_by)->searchForTimeSheetSearch($search,$allow_users_id);

        if ( empty($search) && empty($order_by) && empty($request->input('page') ) ) {
            $dataProvider = [];
        }
        foreach ($dataProvider as $key => $value) {

            $dataProvider[$key]->tag = explode(",",$value->tag);

        }

        $team_id = UserTeam::getTeamIdByUserId( Auth::user()->id );
        $projects = ProjectTeams::getProjectByArrayTeamId($team_id);

        return  view('sheet_search', compact(
            'search', 'model', 'dataProvider' , 'allow_users' , 'projects'
        ));
    }

}
