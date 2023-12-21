<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Hotel extends Model
{
    use HasFactory;
    protected $table = 'hotels';
    public $timestamps = true;

    const STATUS = [
        1 => 'Xuất bản',
        2 => 'Bản nháp'
    ];

    protected $fillable = [
        'h_name',
        'h_image',
        'h_address',
        'h_phone',
        'h_price',
        'h_description',
        'h_content',
        'h_status',
        'h_location_id',
        'h_staff_id',
        'h_hoteltype_id',
        'h_number',
    ];

    public function location ()
    {
        return $this->belongsTo(Location::class, 'h_location_id', 'id');
    }

    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images', '_token', 'submit']);

        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1)
                $params['h_image'] = $image['name'];
        }

        $params['h_staff_id'] = Auth::user()->id;
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

   public function staff ()
    {
        return $this->belongsTo(Staff::class, 'h_staff_id', 'id');
    }

    
    public function scopeActive($query)
    {
        return $query->where('h_status', 1);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'cm_hotel_id', 'id');
    }
    public function commentCount()
    {
        return $this->comments()->whereIn('cm_status',[1,2])->count();
    }
    
    public function type()
    {
        return $this->belongsTo(HotelType::class, 'h_hoteltype_id', 'id');
    }
    public function rooms()
    {
        return $this->hasMany(Room::class, 'rm_hotel_id', 'id');
    }
}
