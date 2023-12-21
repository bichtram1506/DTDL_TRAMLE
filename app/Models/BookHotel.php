<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookHotel extends Model
{
    use HasFactory;
    protected $table = 'book_hotels';
    public $timestamps = true;
    protected $fillable = [
        'bh_user_id',
        'bh_room_id',
        'check_in',
        'check_out',
        'num_guest',
        'total_price',
        'status',
        'bh_payment_method'
    ];
    const STATUS = [
        1 => 'Tiếp nhận',
        2 => 'Đã xác nhận',
        3 => 'Đã thanh toán',
        5 => 'Đã hủy',
    ];
    const CLASS_STATUS = [
        1 => 'btn-secondary',
        2 => 'btn-info',
        3 => 'btn-success',
        5 => 'btn-danger',
    ];
    const PAYMENT_METHODS = [
        'bankTransfer' => 'Chuyển Khoản Ngân Hàng',
        'vnpay' => 'Thanh Toán Tiền Mặt',
    ];
    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except(['_token']);
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'bh_user_id', 'id');
    }
   public function room()
    {
        return $this->belongsTo(Room::class, 'bh_room_id', 'id');
    }
  
 
}
