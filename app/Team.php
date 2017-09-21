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
    
    public static function getColorByKey($key = "")
    {
        $result = self::where("id", $key)->pluck('color')->first();
        return $result;
    }

    public static function getTeamsByManagerTeam($teams)
    {
        foreach ($teams as $team) {

            $teams_id[] = $team->id;
            
        }
        
        $result = self::whereIn('parent_id', $teams_id)->get();
        return $result;
    }
    
    public static function getParentIdById($id)
    {
        
        $result = self::whereIn('id' , $id)->pluck( 'parent_id', 'id');
        return $result;
    }

    public static function getIdByTeamId($id)
    {
        $result = self::where('id' , $id)->get();
        return $result;
    }

    public static function getManagerTeamIdByTeamId($id)
    {
        $result = self::whereIn('id' , $id)
            ->where('parent_id', '0')
            ->get()
            ->pluck('id');
        return $result;
    }

    public static function getMiniManagerTeamIdByTeamId($id)
    {
        $result = self::whereIn('id' , $id)
            ->where('parent_id', '!=', '0')
            ->get()
            ->pluck('id');
        return $result;
    }
    
}
