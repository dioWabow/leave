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
    
    public static function getColorByKey($key = "")
    {
	   $result = self::where("id", $key)->pluck('color')->first();
	   return $result;
    }

    public static function UpdateTeamParentId($id,$parent_id)
    {
        $result = self::where('id', $id)->update(['parent_id' => $parent_id]);
        return $result;
    }

    public static function getHasChildrenTeam($id)
    {
        $result = false;

        $model = self::where("parent_id", $id)->get()->count();
        if (!empty($model)) {

            $result = true;

        }

        return $result;
    }

    public static function getTeamParentFullName($id)
    {

        $parent_id = self::where("id", $id)->pluck("parent_id");

        if ($parent_id != "0") {

            $result = self::where("id", $parent_id)->pluck("name")->first() . " / ";

        }

        return $result;
    }
}
