<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    /**
     * 與Model關聯的table
     *
     * @var string
     */
    protected $table = 'notices';
}
