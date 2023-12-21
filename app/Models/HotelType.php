<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    use HasFactory;
    protected $table = 'hotel_types';
    public $timestamps = true;

    protected $fillable = [
        'ht_name',
        'image'
    ];

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'h_hoteltype_id', 'id');
    }
    
}
