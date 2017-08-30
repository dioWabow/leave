<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'leaves';

    public function testDate($first_day, $last_day)
    {
        $result = $this->whereBetween('start_time', [$first_day, $last_day])->get();
        // $result = $this->get();
    	return $result;
    }

    public function search($where=[])
    {
        //
    }
}
