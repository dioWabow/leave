<?php

namespace App\Classes;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class AttachHelper
{
    public $upload_path;
    
    private $_save_folder;
    private $_file_path;

    function __construct ()
    {
        $this->upload_path = '/public/';
    }

    public function uploadFiles($name, $folder = 'tmp')
    {
        $this->_save_folder = $folder . '/';
        $this->_file_path = $this->upload_path . $this->_save_folder;

        $input = $this->getAvailableFiles($name);
        if($input === null) return null;

        if (is_array($input)) {

            $result = array();
            foreach($input as $key=>$file) {

                $filename = $this->saveFile($file);
                if($filename !== null) $result[] = $filename;

            }

            if (count($result) > 0) {

                return $result;

            } else {

                return null;

            }

        }else{

            return $this->saveFile($input);

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

    private function getAvailableFiles($name) 
    {
        if(Input::hasFile($name)) {

            $input = Input::file($name);
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

    private function saveFile($file)
    {
        $file_extension = $file->getClientOriginalExtension();
        
        $filename = strval(time()) . str_random(5) . '.' . $file_extension; //重新命名，若傳中文會炸掉，故要改名
        $save = Storage::putFileAs($this->_file_path , $file, $filename);

        if ($save) {

            return $filename;

        } else {

            return null;

        }
    }
}