<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    public $timestamps = true;



    protected $fillable = [
        'p_booktour_id',
        'p_total_price',
        'p_vnp_response_code',
        'p_code_vnpay',
        'p_code_bank',
        
    ];


    public function bookTour()
    {
        return $this->belongsTo(BookTour::class, 'p_booktour_id', 'id');
    }

}
