<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'promotions';
    public $timestamps = true;

    protected $fillable = [
        'p_discount_type',
        'p_tour_id',
        'p_discount_value',
        'p_start_date',
        'p_end_date',

    ];

 


    public function tour()
    {
        return $this->belongsTo(Tour::class, 'p_tour_id', 'id');
    }
    
}
