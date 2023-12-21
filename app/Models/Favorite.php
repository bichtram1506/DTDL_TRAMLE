<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;
    protected $table = 'favorites';
    public $timestamps = true;

    protected $fillable = [
        'f_user_id',
        'f_tour_id',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'f_user_id', 'id');
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'f_tour_id', 'id');
    }
    
}
