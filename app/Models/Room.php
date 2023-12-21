<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'rooms';
    public $timestamps = true;

    protected $fillable = [
        'rm_name',
        'rm_price',
        'rm_type',
        'status',
        'rm_description',
        'rm_hotel_id',
        'rm_floor',
        'rm_code',
        'image'
    ];
    const STATUS = [
        0 => 'Trống',
        1 => 'Đã đặt',
        2 => 'Đang dọn dẹp',
        3 => 'Đang sửa chữa',
    ];
    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['images', '_token', 'submit']);

        if (isset($request->images) && !empty($request->images)) {
            $image = upload_image('images');
            if ($image['code'] == 1)
                $params['image'] = $image['name'];
        }

        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'rm_hotel_id', 'id');
    }
    public function bookings()
    {
        return $this->hasMany(BookHotel::class, 'bh_room_id', 'id');
    }
}
