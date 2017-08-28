<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTeam extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'users_teams';
}
