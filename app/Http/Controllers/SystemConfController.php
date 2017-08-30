<?php

namespace App\Http\Controllers;

use App\Config;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;


class SystemConfController extends Controller
{
    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */

     public function postUpdate(Request $request)
     {
        $input = $request->input('config');

        $model = new Config();
        $error = false;
        foreach ($input as $key => $value) {
            if (!$model->updateConfigValueByKey($key,$value)) {
                $error = true;
            }
        }
        dd($results);

        $model->save();


        $record = array();
        $config_key = array();
        $input = $request->all();
        //  取得上傳檔案
        $file = $request->file('config')['company_logo'];
        // 確認檔案是否有上傳
        $checkfile = $request->hasFile('config');
        
        if ( $checkfile ) {

            $upload_logo = $_FILES['config'];
            $logo_name = basename( $upload_logo['name']['company_logo'] );
            
            $destination_path = public_path(). '/dist/img';
            $upload_success = $file->move( $destination_path, $logo_name );

            if ( $upload_success ) {
                $input['config']['company_logo'] = $logo_name;
            }
        }
        
        if (empty($input['config'])) {
            return Redirect::to('system_conf');
        } else {

            $config_key = $input['config'];
            foreach ($config_key as $key => $value) {
                $record['config_value'] = $value;
                $configs->fill($record);
                $results = $configs->where('config_key', $key)->update($value);
            }

            if($results) {
                return Redirect::to('/config/edit')->withErrors(['msg' => '更新成功']);
            }else{
                return Redirect::to('/config/edit')->withErrors(['msg' => '更新失敗']);
            }
        }
    }

    public function getIndex(Request $reques)
    {
        $config = new Config();
        return view('system_conf', compact('config'));
    }
   
}
