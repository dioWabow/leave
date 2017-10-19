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
        return (is_file(substr_replace(Storage::url('avatar/' . $filename), '', 0, 1))) ? url(Storage::url('avatar/' . $filename)) . self::getRandom() : route('root_path') . '/dist/img/users/default.png';
    }
    /**
     * 取得上傳證明路徑
     *
     *  @return string
     */
    public static function getLeaveProveUrl($filename)
    {
        return (!empty($filename)) ? url(Storage::url('prove/' . $filename)) . self::getRandom() : '#';
    }

    public function getCompanyLogoUrl($filename)
    {
        return (!empty($filename)) ? url(Storage::url('/' . $filename)) . self::getRandom() : '#';
    }

    /**
     * 取得上傳多張輪播圖片
     *
     *  @return string
     */
    public static function getLoginPictureUrl($filename)
    {
        return (!empty($filename)) ? url(Storage::url('login_pictures/' . $filename)) . self::getRandom() : '#';
    }

    public static function getRandom()
    {
        return '?v=' .  rand();
    }
}