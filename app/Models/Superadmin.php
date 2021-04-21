<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Superadmin extends BaseModel implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable, Authenticatable;
    
    protected $table = 'superadmins';
    protected $guarded = ['Username'];
    protected $hidden = ['Password'];
    protected $casts = [
    	'Active' => 'bool',
    ];
    protected $keyType = 'string';
    protected $appends = ['Level'];
    public $incrementing = false;

    // public function Articles()
    // {
    //     return $this->hasMany(Article::class, 'Author', 'Username');
    // }

    public function getLevelAttribute()
    {
        return strtoupper($this->attributes['Level']);
    }

    public function isGranted(string $level)
    {
    if ($this->Level == 'SUPER') {
            return true;
        }
    }
}
