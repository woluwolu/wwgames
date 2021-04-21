<?php

namespace App\Models;

class TokenGamer extends BaseModel
{
    protected $table = 'token_gamer';
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
