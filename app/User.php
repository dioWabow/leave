<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'users';

    public static function getUserNameByKey($key = "")
	{
		$result = self::where("id", $key)->pluck('name')->first();
		return $result;
	}
}
