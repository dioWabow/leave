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
        'pagesize',
        'team',
        'status'
    ];

    protected $attributes = [
        'pagesize' => '25',
    ];

    public function getAllProject()
    {
    	$result = $this->paginate($this->pagesize);
    	return $result;
    }

    public function whichProject($id)
    {
    	$result = $this->where('id', $id)->get();
    	return $result;
    }
}
