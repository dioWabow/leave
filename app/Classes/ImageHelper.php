<?php

namespace App\Classes;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

use Image;

class ImageHelper
{
    public $upload_path;
    
    private $_save_folder;
    private $_file_path;
    private $_file_name;

    function __construct ()
    {
        $this->upload_path = storage_path() . '/app/public/';
    }

    public function uploadImages($input_name, $folder = 'tmp',$file_name = "")
    {
        $this->_save_folder = $folder . '/';
        $this->_file_path = $this->upload_path . $this->_save_folder;
        $this->_file_name = $file_name;

        $input = $this->getAvailableFiles($input_name);
        if($input === null) return null;

        if(is_array($input)) {
            $result = array();
            foreach($input as $key=>$file) {
                $filename = $this->saveImage($file);
                if($filename !== null) $result[] = $filename;
            }

            if(count($result) > 0) {
                return $result;
            }else{
                return null;
            }
        }else{
            return $this->saveImage($input);
        }
    }

    public function getFileUrlPath()
    {
        return Storage::url($this->_save_folder);
    }

    public function getFilePath()
    {
        return $this->_file_path;
    }

    private function getAvailableFiles($input_name) 
    {
        if(Input::hasFile($input_name)) {

            $input = Input::file($input_name);
            if(is_array($input)) {

                $result = array();
                foreach ($input as $key=>$file) {
                    if($file->isValid()) $result[] = $file;
                }

                if(count($result) > 0) return $result;

            }else{

                if($input->isValid()) return $input;
            }

        }

        return null;
    }

    private function saveImage($file)
    {
        $file_extension = $file->getClientOriginalExtension();
        
        if (!empty($this->_file_name)) {
            $filename = $this->_file_name . '.' . $file_extension; //若有指定命名時使用指定名字
        }else{
            $filename = strval(time()) . str_random(5) . '.' . $file_extension; //重新命名，若傳中文會炸掉，故要改名
        }
        
        $path = $this->_file_path . $filename;
        $save = Image::make($file)->save($path);

        if($save) {
            return $filename;
        }else{
            return null;
        }
    }
}
