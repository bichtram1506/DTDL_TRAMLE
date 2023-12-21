<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    public $timestamps = true;

    protected $fillable = [
        'r_name',
        'r_slug',
        'r_image',
        'r_description',
        'r_content',
        'r_status',
        'r_staff_id',
    ];

    const STATUS = [
        1 => 'Hiển thị',
        2 => 'Ẩn'
    ];

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images', '_token']);
        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1)
                $params['r_image'] = $image['name'];
        }
        $params['r_slug'] = Str::slug($request->r_name);
        $params['r_staff_id'] = Auth::user()->id;
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

   

    public function scopeActive($query)
    {
        return $query->where('r_status', 1);
    }
    public function locations()
    {
        return $this->hasMany(Location::class, 'l_region_id', 'id');
    }
}