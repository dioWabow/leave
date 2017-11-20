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

    public function uploadFiles($name, $folder = 'tmp', $fixedname = '', $number='-1')
    {
        $this->_save_folder = $folder . '/';
        $this->_file_path = $this->upload_path . $this->_save_folder;

        if ($number != '-1' && !empty($fixedname)) {

            $input = $this->getAvailableFiles($name,$number);

        } else {

            $input = $this->getAvailableFiles($name);

        }

        if($input === null) return null;

        if (is_array($input)) {

            $result = array();
            foreach($input as $key=>$file) {

                if (!empty($fixedname)) {

                    $filename = $this->saveFile($file,$fixedname,$number);

                } else {

                    $filename = $this->saveFile($file);

                }
                
                if($filename !== null) $result[] = $filename;

            }

            if (count($result) > 0) {

                return $result;

            } else {

                return null;

            }

        } else {

            if (!empty($fixedname)) {

                return $this->saveFile($input,$fixedname,$number);

            } else {

                return $this->saveFile($input);

            }

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

    private function getAvailableFiles($name, $number='-1') 
    {
        if ($number != '-1') {

            if(!empty(Input::file('fileupload')[$number])) {

                $input = Input::file($name)[$number];

                if($input->isValid()) return $input;

            }

        } else {

            if (Input::hasFile($name)) {

                $input = Input::file($name);

                if (is_array($input)) {

                    $result = array();
                    foreach ($input as $key=>$file) {

                        if($file->isValid()) $result[] = $file;

                    }

                    if(count($result) > 0) return $result;

                } else {

                    if($input->isValid()) return $input;

                }

            }

        }

        return null;
    }

    private function saveFile($file,$filename = '')
    {
        $file_extension = $file->getClientOriginalExtension();
        
        if (empty($filename)) {

            $filename = strval(time()) . str_random(5) . '.' . $file_extension; //重新命名，若傳中文會炸掉，故要改名

        } else {

            $filename .= '.' . $file_extension;

        }
        
        $save = Storage::putFileAs($this->_file_path , $file, $filename);

        if ($save) {

            return $filename;

        } else {

            return null;

        }
    }

    public function deleteFile($name, $folder = 'tmp')
    {
        if (Storage::delete($this->upload_path . $folder . '/' . $name)) {

            return true;

        } else {

            return false;

        }
    }
}