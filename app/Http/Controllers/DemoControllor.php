<?php

namespace App\Http\Controllers;

use Image; //使用圖片簡寫
use ImageHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class DemoControllor extends Controller
{
    protected $image_root_path;
    protected $image_path;

    /**
    * Instantiate a new UserController instance.
    */
    public function __construct()
    {
        $this->image_path = 'demo/';
        $this->image_root_path = storage_path() . '/app/public/' . $this->image_path;
    }

    public function getImage(Request $request)
    {
        $image_path = '';
        $result = [];
        $single_filename = '';
        if ($request->isMethod('post')) {
            //用法一: 直接使用該 class
            //$model = new \App\Classes\ImageHelper;
            //$result = $model->uploadImages('demo_image','demo');
            //$image_path = $model->getFileUrlPath();

            //用法二: 使用 facades 方式
            $result = ImageHelper::uploadImages('demo_image','demo');
            $image_path = ImageHelper::getFileUrlPath();

            $single_filename = ImageHelper::uploadImages('demo_image2','demo2');
            $image_path2 = ImageHelper::getFileUrlPath();
        }

        return view('demo_image', compact(
            'result', 'image_path', 'single_filename', 'image_path2'
        ));
    }

    /**
    * 上傳圖片 demo
    * 注意：須於 public 下建立連結 - php artisan storage:link 
    */
    public function getImageOld (Request $request)
    {
        $image_url = '';
        if($request->hasFile('demo') && $request->file('demo')['image']->isValid()) {
            $input_file = Input::file('demo');
            $file_extension = $input_file['image']->getClientOriginalExtension();
            
            $filename = strval(time()) . str_random(5) . '.' . $file_extension; //重新命名，若傳中文會炸掉，故要改名
            $image = $this->image_root_path . $filename;

            Image::make($input_file['image'])->save($image);

            $image_url = Storage::url($this->image_path . $filename);
        }

        return view('demo_image', compact(
            'image_url'
        ));
    }
}
