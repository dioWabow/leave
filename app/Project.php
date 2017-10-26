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
        'status',
        'keywords'
    ];

    protected $attributes = [
        'pagesize' => '25',
        'team' => 'all',
        'status' => 'all',
        'keywords' => '',
    ];

    public function getAllProject()
    {
    	$result = $this->paginate($this->pagesize);
    	return $result;
    }

    public function search()
    {
        $query = $this->select('projects.id', 'projects.name', 'projects.available', 'project_teams.team_id', 'project_teams.project_id')
            ->leftJoin('project_teams', 'projects.id', '=', 'project_teams.project_id');

            if($this->status != 'all') {
                $query->where('projects.available', $this->status);
            }

            if($this->team != 'all') {
                $query->where('project_teams.team_id', $this->team);
            }

            if(!empty($this->keywords)) {
                $query->where('projects.name', 'LIKE', '%'.$this->keywords.'%');
            }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function whichProject($id)
    {
    	$result = $this->where('id', $id)->get();
    	return $result;
    }
}
