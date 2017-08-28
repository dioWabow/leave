<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image; //使用圖片簡寫

use App\Http\Controllers\Controller;

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

    /**
    * 上傳圖片 demo
    * 注意：須於 public 下建立連結 - php artisan storage:link 
    */
    public function getImage (Request $request)
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
