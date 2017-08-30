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

    public function testDate()
    {
    	$result = $this->get();
    	return $result;
    	// dd($result);
    }
}
