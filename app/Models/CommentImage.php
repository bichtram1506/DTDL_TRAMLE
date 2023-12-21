<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentImage extends Model
{
    use HasFactory;
    protected $table = 'comment_images';
    public $timestamps = true;
    protected $fillable = [
     
        'ci_comment_id',
  
    ];

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'ci_comment_id', 'id');
    }
  
    
}
