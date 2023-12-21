<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CouponCode extends Model
{
    use HasFactory;
    protected $table = 'coupon_codes';
    public $timestamps = true;

    protected $fillable = [
        'cc_code',
        'cc_name',
        'cc_start_date',
        'cc_expiry_date',
        'cc_remaining_code',
        'cc_percentage',
        'cc_status',
        'cc_usage_count'
    ];

    const STATUS = [
        1 => 'Đang kích hoạt',
        2 => 'Đã khóa'
    ];
    const CLASS_STATUS = [
        1 => 'btn-info',
        2 => 'btn-success',
    ];

    public function createOrUpdate($request, $id = '')
    {
        $params = $request->except(['_token', 'submit']);
    
        if ($id) {
            $couponCode = $this->find($id);
            if (!$couponCode) {
                // Xử lý trường hợp mã giảm giá không tồn tại
                return false;
            }
            $couponCode->update($params);
            return $couponCode;
        }
    
        // Ngẫu nhiên tạo cc_code nếu không được cung cấp
        if (!isset($params['cc_code'])) {
            $params['cc_code'] = Str::random(10); // Thay đổi 10 thành độ dài mong muốn
        }
    
        return $this->create($params);
    }
    

    public function booktours()
    {
        return $this->hasMany(BookTour::class, 'b_coupon_code_id', 'id');
    }
        public function usageCount()
    {
        return $this->hasMany(BookTour::class, 'b_coupon_code_id');
    }

}
