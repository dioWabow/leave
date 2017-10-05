<?php

namespace App\Http\Controllers;

use App\Config;
use App\User;
use App\Notifications\AgentNoticeEmail;
use ImageHelper;
use ConfigHelper;
use UrlHelper;
use EmailHelper;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;


class SystemConfController extends Controller
{
    protected $image_path;

    /**
    * Instantiate a new UserController instance.
    */
    public function __construct()
    {
        $this->image_path = '';
    }
    /**
     * 更新
     *
     * @param Request $request
     * @return Redirect
     */

     public function postUpdate(Request $request)
     {
        $input = $request->input('config');
        $remove_image = $request->input('remove_file');

        $company_logo_before = ConfigHelper::getConfigValueByKey("company_logo");

        $image_url = ImageHelper::uploadImages("company_logo",$this->image_path,"company_logo");
        if (!empty($image_url)) {

            if ( $company_logo_before != $image_url ) {

                ImageHelper::deleteFile($company_logo_before , $this->image_path);

            }

            $input["company_logo"] = $image_url;

        }elseif ( $remove_image == "true") {

            if ( $company_logo_before != $image_url ) {

                ImageHelper::deleteFile($company_logo_before , $this->image_path);

            }

            $input["company_logo"] = "";

        }


        foreach ($input as $key => $value) {

            if ( in_array( $key , ["company_website" , "company_rules"] ) ) {

                if ( !preg_match('/^(http:\/\/)/', $input[$key] ) && !preg_match('/^(https:\/\/)/', $input[$key] ) ) {

                    $input[$key] = 'http://' . $input[$key];

                }

            }

        }

        $model = new Config();
        $error = false;
        foreach ($input as $key => $value) {

            if (!empty($value)) {

                if (!$model->updateConfigValueByKey($key,$value)) {

                    $error = true;

                }

            }else{


                if (!$model->updateConfigValueByKey($key,"")) {

                    $error = true;

                }

            }

        }

        if (!$error) {

            return Redirect::route('config/edit');

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }

    public function getIndex(Request $request)
    {
        $input = $request->old('config');

        $config = Config::getAllConfigValueArray();

        if (!empty($input)) {

            foreach ($input as $key => $value) {

                $config[$key] = $value;

            }

        }
        return view('system_conf', compact('config'));
    }
   
}
