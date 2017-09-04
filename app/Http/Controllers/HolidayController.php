<?php

namespace App\Http\Controllers;

// 自行載入
use Redirect;
use App\Holiday;
use App\Http\Requests\HolidayPostRequest;
use Illuminate\Support\Facades\Input;

// 預設載入
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class HolidayController extends Controller
{
    /**
     * 搜尋
     *
     * @return \Illuminate\Http\Response
     */
    public static function getIndex (Request $request)
    {
        $order_by = (!empty($request->input('order_by'))) ? $request->input('order_by') : [];
        $search = (!empty($request->input('search'))) ? $request->input('search') : [];

        if (!empty($order_by) || !empty($search)) {

            $request->session()->forget('holidays');
            $request->session()->push('holidays.search', $search);
            $request->session()->push('holidays.order_by', $order_by);

        } else {

            if (!empty($request->input('page')) && !empty(session()->get('holidays'))) {

                $search = $request->session()->get('holidays.search.0');
                $order_by = $request->session()->get('holidays.order_by.0');

            } else {

                $request->session()->forget('holidays');

            }
        }

        if (!empty($search['daterange'])) {

            $daterange = explode(" - ", $search['daterange']);
            $search['start_time'] = $daterange[0];
            $search['end_time'] = $daterange[1];

            $order_by['start_date'] = $daterange[0];
            $order_by['end_date'] = $daterange[1];

        }

        $model = new Holiday;

        $model->fill($order_by);

        $dataProvider = $model->search($search);

        $dataProvider = self::changeTypeName($dataProvider);

        return view('holidies', compact(
            'search', 'model', 'dataProvider'
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

        $data = $request->old('holidies');

        if (!empty($data)) {

            $model->fill($request->old('holidies'));

        }

        return view('holidies_form', compact(
            'model'
        ));
    }

    /**
     * 編輯
     *
     * @return \Illuminate\Http\Response
     */
    public static function getEdit(Request $request, $id)
    {
        $model = self::loadModel($id);

        $data = $request->old('holidies');

        if (!empty($data)) {

            $model->fill($data);

        }

        $model->date = date('Y-m-d', strtotime($model->date));

        return view('holidies_form', compact(
            'model'
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

        // 儲存資料
        $model = new Holiday;

        $model->fill($input);

        if ($model->save()) {

            return Redirect::route('holidies')->withErrors(['msg' => '新增成功']);

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '新增失敗']);

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
        $input = $request->input('holidies');

        //儲存資料
        $model = self::loadModel($input['id']);

        $model->fill($input);

        if ($model->save()) {

            return Redirect::route('holidies')->withErrors(['msg' => '更新成功']);

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }

    /**
     * 刪除
     *
     * @return \Illuminate\Http\Response
     */
    public static function postDelete ($id)
    {
        $result = self::loadModel($id)->delete();

        return Redirect::route('holidies')->withErrors(['msg' => '刪除成功']);

    }

    /**
     * 變更字串
     *
     * @return \Illuminate\Http\Response
     */
    private static function changeTypeName($data)
    {
        foreach ($data as $value) {

            $value['type'] = ($value['type'] == 'holiday') ? "國定假日" : "上班日";

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
        $model = Holiday::find($id);

        if ($model===false) {

            throw new CHttpException(404,'資料不存在');

        }
        return $model;
    }
}
