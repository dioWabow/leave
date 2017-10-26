<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Project extends Model
{
	protected $fillable = [
		'id',
        'name',
        'available',
    ];

    public function getAllProject()
    {
    	$result = $this->paginate(25);
    	return $result;
    }

    public function whichProject($id)
    {
    	$result = $this->where('id', $id)->get();
    	return $result;
    }
}
