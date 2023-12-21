<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookTour extends Model
{
    use HasFactory;
    protected $table = 'book_tours';
    public $timestamps = true;

    const STATUS = [
        1 => 'Tiếp nhận',
        2 => 'Đã xác nhận',
        3 => 'Đã thanh toán',
        4 => 'Đã kết thúc',
        5 => 'Đã hủy',
    ];
    const CLASS_STATUS = [
        1 => 'btn-secondary',
        2 => 'btn-info',
        3 => 'btn-success',
        4 => 'btn-warning',
        5 => 'btn-danger',
    ];
    const PAYMENT_METHODS = [
        'VNPay' => 'Thanh toán VNPAY',
        'bankTransfer' => 'Chuyển Khoản Ngân Hàng',
        'cash' => 'Thanh Toán Tiền Mặt',
        'MOMO' => 'Thanh toán ví MOMO'
    ];
    protected $casts = [
        'extra_service_id' => 'array', // Đảm bảo rằng Laravel biết cột này chứa mảng
    ];
    protected $fillable = [ 'b_user_id','b_coupon_code_id', 'b_address', 'b_status','b_payment_method','b_reason','b_book_date','b_total_price','b_tourdetail_id','b_total_ticket','extra_service_id','b_price_adults','b_price_children', 'b_number_adults', 'b_number_children','b_price_child6','b_price_child2','b_number_child6','b_number_child2','b_name','b_email','b_phone'];
    public function createOrUpdate($request , $id ='')
    {
        $params = $request->except([ '_token', 'submit']);
      
        if ($id) {
            return $this->find($id)->update($params);
        }
        return $this->create($params);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'b_user_id', 'id');
    }
    
    public function couponCode()
    {
        return $this->belongsTo(CouponCode::class, 'b_coupon_code_id', 'id');
    }
    
    public function eventdate()
    {
        return $this->belongsTo(EventDate::class, 'b_tourdetail_id', 'id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'p_booktour_id', 'id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'cm_booktour_id', 'id');
    }
    
}
