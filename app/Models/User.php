<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Shanmuga\LaravelEntrust\Traits\LaravelEntrustUserTrait;


class User extends Authenticatable
{
    use HasFactory, Notifiable, LaravelEntrustUserTrait;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function getInfoEmail($email)
    {
        return $this->where(['email'=>$email,'status'=>1])->first();
    }
    public function sender()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Tour::class, 'favorites', 'f_user_id', 'f_tour_id');
    }
    public function bookTours()
    {
        return $this->hasMany(BookTour::class, 'b_user_id', 'id');
    }

        // Trong model User
        public function bookings()
        {
            return $this->hasMany(BookTour::class, 'b_user_id'); // Sửa 'user_id' thành 'b_user_id'
        }
// Trong mô hình User
        public function bookedEventDates()
        {
            return $this->hasMany(BookTour::class, 'b_user_id')->with('eventdate');
        }
    public $timestamps = true;
}

