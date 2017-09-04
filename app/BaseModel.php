<?php

namespace App;

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
            $dirty = $model->getDirty();
            foreach ($model->getAttributes() as $key => $value) {
                if(in_array($key, array_keys($model->getOriginal()))) 
                    unset($model->$key);
            }
            foreach ($dirty as $key => $value) {
                $model->setAttribute($key, $value);
            }
        });
        parent::boot();
    }
}
