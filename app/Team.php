<?php

namespace App;

class Team extends BaseModel
{
    protected $fillable = [
        'parent_id',
        'name',
        'color',
    ];

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
