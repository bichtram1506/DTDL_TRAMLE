<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    public $timestamps = true;

    const STATUS = [
        1 => 'Hiển thị',
        2 => 'Nổi bật',
        3 => 'Ẩn'
    ];

    const CLASS_STATUS = [
        1 => 'btn-info',
        2 => 'btn-success',
        3 => 'btn-warning',
    ];

    protected $fillable = [
        'cm_user_id',
        'cm_article_id',
        'cm_hotel_id',
        'cm_booktour_id',
        'cm_content',
        
       
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'cm_user_id', 'id');
    }
    public function tour()
    {
        return $this->belongsTo(Tour::class, 'cm_tour_id', 'id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'cm_article_id', 'id');
    }
    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'cm_hotel_id', 'id');
    }
    public function commentimages()
    {
        return $this->hasMany(CommentImage::class, 'ci_comment_id', 'id');
    }
    public function booktour()
    {
        return $this->belongsTo(BookTour::class, 'cm_booktour_id', 'id');
    }
    
}
