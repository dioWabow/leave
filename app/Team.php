<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'teams';

    public static function getColorByKey($key = "")
	{
		$result = self::where("id", $key)->pluck('color')->first();
		return $result;
	}
}
