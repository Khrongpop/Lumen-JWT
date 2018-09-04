<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];



    public function scopeCheckEmailAndName($query,$requset){
        $query->where('name',$requset->name)->orWhere('email',$requset->email)->first();
     }

    public function scopeGetID($query,$name){
        $query->where('name',$name)->first();
    }

    public function scopeLog($query,$requset){
        // if($requset->password == '123456')
          $query->where('name',$requset->name)>first();
        // else 
        //   return  null;
    }


    public function getAuthPassword()
    {
        return $this->password;
    }

}
