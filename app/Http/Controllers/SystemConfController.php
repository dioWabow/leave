<?php

namespace App\Http\Controllers;

use App\Config;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Image; //使用圖片簡寫


class SystemConfController extends Controller
{
    protected $image_root_path;
    protected $image_path;

    /**
    * Instantiate a new UserController instance.
    */
    public function __construct()
    {
        $this->image_path = '';
        $this->image_root_path = storage_path() . '/app/public/' . $this->image_path;
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

        $image_url = $this->getImage($request);
        if (!empty($image_url)) {

            $input["company_logo"] = $image_url;

        }

        $model = new Config();
        $error = false;
        foreach ($input as $key => $value) {

            if (!empty($value)) {

                if (!$model->updateConfigValueByKey($key,$value)) {

                    $error = true;

                }

            }

        }
        
        if (!$error) {

            return Redirect::to('/config/edit')->withErrors(['msg' => '更新成功']);

        } else {

            return Redirect::back()->withInput()->withErrors(['msg' => '更新失敗']);

        }
    }

    public function getIndex(Request $reques)
    {
        $config = new Config();
        return view('system_conf', compact('config'));
    }

    /**
    * 上傳圖片 demo
    * 注意：須於 public 下建立連結 - php artisan storage:link 
    */
    public function getImage (Request $request)
    {
        $image_url = '';
        if($request->hasFile('config') && $request->file('config')['company_logo']->isValid()) {
            $input_file = Input::file('config');
            $file_extension = $input_file['company_logo']->getClientOriginalExtension();
            
            $filename = 'company_logo.' . $file_extension; //重新命名，若傳中文會炸掉，故要改名
            $image = $this->image_root_path . $filename;

            Image::make($input_file['company_logo'])->save($image);

            $image_url = Storage::url($this->image_path . $filename);
        }

        return $image_url;
    }
   
}
