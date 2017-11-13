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

            return Redirect::route('holidies/index')->with('success', '新增成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['error' => '新增失敗 !']);

        }
    }

    /**
     * 從台北開放API
     *
     * @param Request $request
     * @return Redirect
     */
    public static function postInsertFromTaipeiData(Request $request)
    {

        $input = $request->input('input');
        $data = [];//國定假日資料放置
        $data_count = 0;//國定假日資料數量
        $curl = [];//國定假日未處理資料
        $input_year = !empty($input["year"]) ? $input["year"] : 2018;//匯入年份
        $error = false;//國定假日資料放置
        $url = "http://data.taipei/opendata/datalist/apiAccess?scope=resourceAquire&rid=c9b60d40-cb14-4796-9a6f-276fc1525128";
        $curl_json = self::curl($url, $params = false, $ispost = 0, $https = 0);
        if ($curl_json) {
            $curl = json_decode($curl_json);
            dd($curl);
            foreach ($curl->result->results as $key => $value) {
                if ( in_array($value->holidayCategory, array("放假之紀念日及節日", "調整放假日","補行上班日","補假","特定節日") ) //類型屬於要匯入的類型
                    && substr( $value->date , 0 , 4 ) == $input_year //指定年份
                    && !in_array($value->name, array("軍人節") ) //軍人節除外
                    && (!in_array( date("w",strtotime( $value->date ) ) , array("0","6") ) || $value->isHoliday == "否") //假日則星期六日除外 補班則不除外
                ) {
                    $data["name"] = !empty( $value->name ) ? $value->name : $value->holidayCategory;//若有則取節日名,否則取類別名
                    $data["type"] = ($value->isHoliday == "是") ? "holiday" : "work";//國定假日or補班
                    $data["date"] = date( "Y-m-d",strtotime( $value->date ) );//日期改格式

                    // 儲存資料
                    $model = new Holiday;

                    if ( !Holiday::isDayExist( $data["date"] ) ) {

                        $model->fill($data);

                        if ( !$model->save() ) {

                            $error = true;

                        }else{
                            $data_count++;
                        }
                    }
                }

            }

            if ( !$error ) {
                if ($data_count == 0) {
                    return Redirect::route('holidies/index')->with('success', '無資料需要匯入，或政府尚未更新');
                }else{

                    return Redirect::route('holidies/index')->with('success', '匯入成功 !');
                }
            }else{
                return Redirect::back()->withInput()->withErrors(['error' => '匯入失敗，可能為政府網頁異常，請稍候再試']);
            }
        }else{

            return Redirect::back()->withInput()->withErrors(['error' => '匯入失敗，可能為政府網頁異常，請稍候再試']);

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

            return Redirect::route('holidies/index')->with('success', '更新成功 !');

        } else {

            return Redirect::back()->withInput()->withErrors(['error' => '更新失敗 !']);

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

        if ($result) {

            return Redirect::route('holidies/index')->with('success', '刪除成功 !');

        } else {

            return Redirect::route('holidies/index')->withErrors(['error' => '刪除失敗 !']);

        }

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

    /**
     * curl function
     * @param $url 請求網址
     * @param bool $params 請求參數
     * @param int $ispost 請求方式
     * @param int $https https協議
     * @return bool|mixed
     */
    public static function curl($url, $params = false, $ispost = 0, $https = 0)
    {
        $httpInfo = array();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($https) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 對認證證書來源的檢查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 從證書中檢查SSL加密算法是否存在
        }
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }

        $response = curl_exec($ch);

        if ($response === FALSE) {
            //echo "cURL Error: " . curl_error($ch);
            return false;
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
        curl_close($ch);
        return $response;
    }
}
