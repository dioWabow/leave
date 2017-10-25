<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    protected $fillable = [
        'team_id',
        'project_id',
    ];
}
