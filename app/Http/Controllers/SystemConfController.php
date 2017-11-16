<?php

namespace App\Http\Controllers;

use App\Config;
use App\User;
use App\Notifications\AgentNoticeEmail;
use ImageHelper;
use ConfigHelper;
use UrlHelper;
use EmailHelper;
use AttachHelper;

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

    public function postUpload(Request $request)
    {
        $login_pictures = '';
        $response = [];
        $login_pictures = ConfigHelper::getConfigValueByKey('login_pictures');

        if (Input::hasFile('fileupload')) {

            foreach (Input::file('fileupload') as $key => $value) {

                do {

                $filename = 'wabow-team' . rand(10,99);

                } while (is_file(substr_replace(Storage::url('login_pictures/' . $filename. '.' . strtolower(Input::file('fileupload')[$key]->getClientOriginalExtension())), '', 0, 1)));

                $file_name[$key] = AttachHelper::uploadFiles('fileupload','login_pictures',$filename,$key);

            }

            if (!empty($file_name)) {

                if (!empty($login_pictures)) {

                    $login_pictures .= ',' . implode(',' , $file_name);

                } else {

                    $login_pictures = implode(',' , $file_name);

                }

                $model = new Config;

                if ($model->updateConfigValueByKey('login_pictures',$login_pictures)) {
                    $initialPreview = [];
                    $initialPreviewConfig = [];
                    foreach ($file_name as $value) {

                        $initialPreview[] = UrlHelper::getLoginPictureUrl($value);
                        $initialPreviewConfig[] = [
                            'caption' => $value,
                            'url' => route("config/delete"),
                            'extra' => ["_token" => csrf_token(),
                            "file" => $value,
                            ],
                        ];

                    }

                    $response['initialPreview'] = $initialPreview;
                    $response['initialPreviewConfig'] = $initialPreviewConfig;

                    return response()->json($response); 
                } else {

                    $response = [
                        'message' => '更新資料庫失敗',
                    ];
                    return response()->json($response); 

                }

            } else {

                $response = [
                    'message' => '上傳證明失敗',
                ];
                return response()->json($response); 

            }
        }
    }

    public function postDelete(Request $request)
    {
        $login_pictures = explode(',', ConfigHelper::getConfigValueByKey('login_pictures'));

        $filename = $request->all()['file'];

        if (in_array($filename, $login_pictures)) unset($login_pictures[array_search($filename, $login_pictures)]);

        if (AttachHelper::deleteFile($filename,'login_pictures')) {

            $model = new Config;

            if ($model->updateConfigValueByKey('login_pictures',implode(',' , $login_pictures))) {

                $response = [
                    'message' => '刪除成功',
                ];
                return response()->json($response); 

            } else {

                $response = [
                    'message' => '更新資料庫失敗',
                ];
                return response()->json($response); 

            }

        } else {

            $response = [
              'message' => '刪除檔案失敗',
            ];
            return response()->json($response); 

        }
    }
   
}
