<?php 
namespace App\Http\Controllers\Page;
use Illuminate\Http\Request;
use App\Models\CouponCode;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function applyDiscount(Request $request)
    {
        try {
            $discountCode = $request->input('cc_code');
            $totalPrice = $request->input('total_price');
    
            $coupon = CouponCode::where('cc_code', $discountCode)
                ->where('cc_status', 1) // Filter by cc_status = 1
                ->where('cc_start_date', '<=', now())
                ->where('cc_expiry_date', '>=', now())
                ->where('cc_remaining_code', '>', 0)
                ->where('cc_usage_count', '<', \DB::raw('cc_remaining_code'))
                ->first();
    
            if ($coupon) {
                // Tính toán giảm giá và gửi kết quả về cho front-end
                $discountAmount = 0;
                if ($coupon->cc_percentage > 0) {
                    $discountAmount = $totalPrice * ($coupon->cc_percentage / 100);
                }
    
                $discountCodeId = $coupon->id; // Lấy ID của mã giảm giá đã áp dụng
    
                // Trừ đi 1 lượt từ số lượt còn lại của mã giảm giá
                // ...
    
                // Lưu thay đổi vào cơ sở dữ liệu
                $coupon->save();
    
                // Trả về phản hồi JSON
                return response()->json([
                    'success' => true,
                    'discountAmount' => $discountAmount,
                    'discountCodeId' => $discountCodeId
                ]);
    
            } else {
                return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ hoặc đã hết lượt sử dụng']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
    
}