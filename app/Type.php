<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'types';

    public static function getTypeNameByKey($key = "")
	{
		$result = self::where("id", $key)->pluck('name')->first();
		return $result;
	}
}
