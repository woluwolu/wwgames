<?php

namespace App\Models;

class TokenSuperadmin extends BaseModel
{
    protected $table = 'token_superadmin';
    protected $primaryKey = 'ID';
    protected $keyType = 'string';
    
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->DeviceType = 'WEB';
            $model->CreatedAt = time();
        });
    }
}
