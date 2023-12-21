<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;
    protected $table = 'locations';
    public $timestamps = true;

    protected $fillable = [
        'l_name',
        'l_description',
        'l_region_id'
    ];

    const STATUS = [
        1 => 'Hiển thị',
        2 => 'Ẩn'
    ];

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['_token']);
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'l_region_id', 'id');
    }
     
    public function attractions()
    {
        return $this->hasMany(Attraction::class, 'at_location_id', 'id');
    }
    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'h_location_id', 'id');
    }

}
