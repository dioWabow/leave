<?php

namespace App\Http\Controllers\sheet;

use Image; //使用圖片簡寫
use ImageHelper;
use App\User;
use App\Leave;
use App\Type;
use App\Team;
use App\UserAgent;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DailyController extends Controller
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

    public function getIndex(Request $request)
    {
        return view('sheet_insert_form');
        //return view('sheet_insert_form',compact(
        //    'user','model','types','user_agents','teams','team_users','user_no_team'
        //));
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
