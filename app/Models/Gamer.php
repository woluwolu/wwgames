<?php
namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Gamer extends BaseModel implements AuthorizableContract, AuthenticatableContract
{
    use Authorizable, Authenticatable;
    
    protected $table = 'gamer';
    protected $guarded = ['Email'];
    protected $hidden = ['Password'];
    
    protected $keyType = 'string';
}
