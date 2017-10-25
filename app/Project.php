<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	protected $fillable = [
        'name',
        'available',
    ];

    public function getAllProject()
    {
    	$result = $this->get()->groupBy('name');
    	return $result;
    }
}
