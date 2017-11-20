<?php

namespace App;


use Illuminate\Pagination\Paginator;

class Project extends BaseModel
{
	protected $fillable = [
	'id',
        'name',
        'available',
        'pagesize',
        'team',
        'keywords'
    ];

    protected $attributes = [
        'pagesize' => '25',
        'team' => 'all',
        'available' => 'all',
        'keywords' => '',
    ];

    public function getAllProject()
    {
    	$result = $this->paginate($this->pagesize);
    	return $result;
    }

    public function search()
    {
        $query = $this->OrderedBy();

            if($this->team != 'all') {
                $query->select('projects.id', 'projects.name', 'projects.available', 'project_teams.team_id', 'project_teams.project_id')
                    ->leftJoin('project_teams', 'projects.id', '=', 'project_teams.project_id')
                    ->where('project_teams.team_id', $this->team);
            }

            if($this->available != 'all') {
                $query->where('available', $this->available);
            }

            if(!empty($this->keywords)) {
                $query->where('name', 'LIKE', '%'.$this->keywords.'%');
            }

        $result = $query->paginate($this->pagesize);
        return $result;
    }

    public function scopeOrderedBy($query)
    {
        $result = $query->orderBy('id');
        return $result;
    }

    public function whichProject($id)
    {
    	$result = $this->where('id', $id)->get();
    	return $result;
    }
}
