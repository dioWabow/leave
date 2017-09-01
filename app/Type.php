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

    public static function getAllType() 
    {
        $result = self::get();
        return $result;
    }
}
