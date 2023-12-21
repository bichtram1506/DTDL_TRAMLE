<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuoteHistory extends Model
{
    use HasFactory;
    protected $table = 'quote_history';
    public $timestamps = true;

    protected $fillable = [
        'tour_id',
        'adult_price',
        'child_price',
        'status',
        'reason'
    ];
    const STATUS = [
        0 => 'Chưa duyệt',
        1 => 'Duyệt',
        2 => 'Từ chối',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }
}