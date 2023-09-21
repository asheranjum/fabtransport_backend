<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\UserDetail;
use App\Role;
class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
  
    protected $table =  "users";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'name',
        'email',
        'password',
        'phone',
        'role_id',
        'verification_token'
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
  
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function userDetails()
	{
		return $this->hasOne(UserDetail::class,'user_id');
	}


    
    public function getRoleName()
	{
		return $this->belongsTo(Role::class,'role_id');
	}

}