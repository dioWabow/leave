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
    public static function getAllTeam()
    {
        $result = self::get();
        return $result;
    }
}
