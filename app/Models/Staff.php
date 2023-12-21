<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;


class Staff extends Authenticatable
{
    use HasFactory, Notifiable, LaravelEntrustUserTrait;
    protected $table = 'staffs';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'images',
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
  

    public function getInfoEmail($email)
    {
        return $this->where(['email'=>$email,'status'=>1])->first();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_staff', 'staff_id', 'role_id');
    }
    

  
    public $timestamps = true;
}

