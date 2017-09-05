<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'holidays';

    public static function getHolidayByDateAndType($date,$type)
    {
        $query = self::where('date' , 'like' , $date.'%');
        $result = $query->where('type' , $type)->count();
        return $result;
    }
}
