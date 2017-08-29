<?php

namespace App\Http\Controllers;

use Redirect;
use Validator;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Holiday;
use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayPostRequest;


class HolidayController extends Controller
{
    /**
     * 搜尋
     *
     * @return \Illuminate\Http\Response
     */
    public static function getIndex (Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by'):[];
        $where = (!empty($request->input('search'))) ? $request->input('search'):[];

        if (!empty($order_by) || !empty($where)) {

            $request->session()->forget('holidays');
            $request->session()->push('holidays.where', $where);
            $request->session()->push('holidays.order_by', $order_by);
        } else {

            if (!empty($request->input('page')) && !empty(session()->get('holidays'))) {

                $where = $request->session()->get('holidays.where.0');
                $order_by = $request->session()->get('holidays.order_by.0');
            } else {

                $request->session()->forget('holidays');
            }
        }

        if (!empty($where['daterange'])) {

            $daterange = explode(" - ", $where['daterange']);

            $where['startTime'] = $daterange[0];
            $where['endTime'] = $daterange[1];
        }

        $model = new Holiday;

        $model->fill($order_by);

        $dataProvider = $model->search($where);

        $dataProvider = self::changeTypeName($dataProvider);

        return view('holidies', compact(
            'dataProvider', 'where', 'model'
        ));
    }

    /**
     * 新增
     *
     * @return \Illuminate\Http\Response
     */
    public static function getCreate(Request $request)
    {
        $model = new Holiday;
        $type_judge = 0;

        if ($request->old('holidies')) {
            $model->fill($request->old('holidies'));
        }

        return view('holidies_form', compact(
            'type_judge', 'model'
        ));
    }

    /**
     * 編輯
     *
     * @return \Illuminate\Http\Response
     */
    public static function getEdit(Request $request, $id)
    {
        $model = Holiday::find($id);
        $type_judge = ($model->type == 'holiday') ? '1' : '0';

        if ($request->old('holidies')) {
            $model->fill($request->old('holidies'));
        }

        $model->date = date('Y-m-d', strtotime($model->date));

        return view('holidies_form', compact(
            'type_judge', 'model'
        ));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return Redirect
     */
    public static function postInsert(HolidayPostRequest $request)
    {
        $input = $request->input('holidies');

        //儲存資料
        $model = new Holiday;
        $model->fill($input);

        if($model->saveOriginalOnly()) {
            return Redirect::to('holidies')->withErrors(['msg' => '新增成功']);
        }else{
            return Redirect::back()->withInput();
        }
    }

    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */
     public static function postUpdate(HolidayPostRequest $request)
     {
        $input = $request->all();

        //儲存資料
        $holiday = self::loadModel($input['id']);

        $holiday->fill($input['holidies']);

        if($holiday->save()) {
            return Redirect::to('holidies')->withErrors(['msg' => '更新成功']);
        } else {
            return Redirect::back()->withInput();
        }
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public static function postDelete ($id)
    {
        $result = Holiday::find($id)->delete();

        return redirect('holidies');

    }

    /**
     * 變更字串
     *
     * @return \Illuminate\Http\Response
     */
    private static function changeTypeName($data)
    {
        foreach ($data as $value) {

            ($value['type'] == 'holiday') ? $value['type'] = "國定假日" : $value['type'] = '上班日';

            $value['date'] = date('Y-m-d', strtotime($value['date']));
        }

        return $data;
    }

    /**
     * 找id
     *
     * @return \Illuminate\Http\Response
     */
    private static function loadModel($id)
    {
        $loadModel = Holiday::find($id);

        if($loadModel===false){
            throw new CHttpException(404,'資料不存在');
        }
        return $loadModel;
    }
}
