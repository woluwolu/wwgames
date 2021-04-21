<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public $timestamps = false;
    public static $snakeAttributes = false;

    protected function castAttribute($key, $value)
    {
    	if ($this->getCastType($key) == 'boolean' && is_null($value)) {
    		return false;
    	}

        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }

    	return parent::castAttribute($key, $value);
    }
}
