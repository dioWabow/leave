<?php

namespace App;

use Schema;
use Illuminate\Database\Eloquent\Model;
use Auth;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use OwenIt\Auditing\Contracts\UserResolver;

class BaseModel extends Model implements AuditableContract, UserResolver
{
    use Auditable;
    
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

    /**
     * {@inheritdoc}
     */
    public static function resolveId()
    {
        return Auth::check() ? Auth::user()->getAuthIdentifier() : null;
    }
}
