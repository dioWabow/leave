<?php

namespace App;

class Team extends BaseModel
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    public static function getAllTeam() 
    {
        $result = self::get();
        return $result;
    }
    
    public static function getColorByKey($key = '')
    {
	$result = self::where('id', $key)->pluck('color')->first();
	return $result;
    }
}
