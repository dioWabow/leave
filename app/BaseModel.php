<?php

namespace App;

use Schema;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public static function boot()
    {
        static::creating(function ($model) {
            // blah blah
        });

        static::updating(function ($model) {
            // bleh bleh
        });

        static::deleting(function ($model) {
            // bluh bluh
        });

        static::saving(function ($model) {
            foreach ($model->getAttributes() as $key => $value) {
                if(!Schema::hasColumn($model->getTable(), $key)) 
                    unset($model->$key);
            }
        });
        
        parent::boot();
    }
}
