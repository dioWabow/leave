<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use Session;
use Url;

class UrlHelper
{
    public static function getUrl()
    {
        return url('/');
    }

    /**
     * 取得 user 大頭圖片
     *
     * @return string
     */
    public static function getUserAvatarUrl($filename)
    {
        return (!empty($filename))? url(Storage::url('avatar/' . $filename)) : '#';
    }
}