<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    public $timestamps = true;
    const TYPES = [
        1 => 'Cẩm Nang',
        2 => 'Du lịch'
    ];
     const STATUS = [
         1 => 'Hiển thị',
         2 => 'Ẩn'
     ];


    protected $fillable = ['c_name', 'c_slug',  'c_description', 'c_hot', 'c_status', 'c_staff_id'];

    public function news()
    {
        return $this->hasMany(Article::class, 'a_category_id', 'id')->where('a_active', 1);
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category', 'category_id', 'article_id');
    }
    
    /**
     * @param $request
     * @param string $id
     * @return mixed
     */
    public function createOrUpdate($request, $id = '')
    {
        $params = $request->except(['_token']);
        $params['c_slug'] = Str::slug($request->c_name);
        $params['c_staff_id'] = Auth::user()->id;
        
        if ($id) {
            return $this->find($id)->update($params);
        }
        
        return $this->create($params);
    }
}
