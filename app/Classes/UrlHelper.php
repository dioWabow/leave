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
        return (!empty($filename)) ? url(Storage::url('avatar/' . $filename)) . self::getRandom() : '#';
    }
    /**
     * 取得上傳檔案路徑
     *
     *  @return string
     */
    public static function getLeaveProveUrl($filename)
    {
        return (!empty($filename)) ? url(Storage::url('prove/' . $filename)) . self::getRandom() : '#';
    }

    public function getCompanyLogoUrl($filename)
    {
        return (!empty($filename))? url(Storage::url($filename)) : '#';
    }

    public static function getRandom()
    {
        return '?v=' .  rand();
    }
}