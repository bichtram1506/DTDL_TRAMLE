<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông báo Đơn hàng điều chỉnh</title>
</head>
<body>
    <h3>Chào {{ $user->name }},</h3>
    
    <p>Chúng tôi xin thông báo rằng đơn hàng của bạn đã được điều chỉnh.</p>
    
    <p>Thông tin chi tiết về đơn hàng đã được điều chỉnh:</p>
    
    <ul>
        <p><b>Mã tour:</b> {{ $tour->t_code }}</p>
        <p><b>Tên tour:</b> {{ $tour->t_title }}</p>
        <p><b>Điểm khởi hành:</b> {{ $bookTour->b_address }}</p>
        <p><b>Ngày đi dự kiến:</b> {{$eventdate->td_start_date}}</p>
        <hr style="margin: 20px 0;">
        <p><b>Mã booking:</b> <span>{{ $bookTour->id }}</span></p>
      
        <p><b>Trị giá booking:</b> {{ number_format($bookTour->b_total_price, 0,',','.') }} vnd</p>
          
                <strong>Số người lớn:</strong> {{ $bookTour->b_number_adults }}</li>
             @php
                $adultPrice = $bookTour->b_price_adults; // Giả sử giá vé người lớn lưu trong thuộc tính b_price_adults
                $totalAdultPrice = $bookTour->b_number_adults * $adultPrice;
            @endphp
    
            <p><strong>Tổng giá vé người lớn:</strong> {{ number_format($totalAdultPrice, 0, ',', '.') }} VND</p>
    
            @if ($bookTour->b_number_children > 0)
            <strong>Số trẻ em (6-12 tuổi):</strong> {{ $bookTour->b_number_children }}
            @php
                $childPrice = $bookTour->b_price_children; // Giả sử giá vé trẻ em (6-12 tuổi) lưu trong thuộc tính b_price_children
                $totalChildPrice = $bookTour->b_number_children * $childPrice;
            @endphp
            <p><strong>Tổng giá vé trẻ em (6-12 tuổi):</strong> {{ number_format($totalChildPrice, 0, ',', '.') }} VND</p>
        @endif
        
        @if ($bookTour->b_number_child6 > 0)
            <strong>Số trẻ dưới 6 tuổi:</strong> {{ $bookTour->b_number_child6 }}
            @php
                $child6Price = $bookTour->b_price_child6; // Giả sử giá vé trẻ em dưới 6 tuổi lưu trong thuộc tính b_price_child6
                $totalChild6Price = $bookTour->b_number_child6 * $child6Price;
            @endphp
            <p><strong>Tổng giá vé trẻ em dưới 6 tuổi:</strong> {{ number_format($totalChild6Price, 0, ',', '.') }} VND</p>
        @endif
        
        @if ($bookTour->b_number_child2 > 0)
            <strong>Số trẻ dưới 2 tuổi:</strong> {{ $bookTour->b_number_child2 }}
            @php
                $child2Price = $bookTour->b_price_child2; // Giả sử giá vé trẻ em dưới 2 tuổi lưu trong thuộc tính b_price_child2
                $totalChild2Price = $bookTour->b_number_child2 * $child2Price;
            @endphp
            <p><strong>Tổng giá vé trẻ em dưới 2 tuổi:</strong> {{ number_format($totalChild2Price, 0, ',', '.') }} VND</p>
        @endif
        @if ($bookTour->couponCode)
        <div class="discount-info">
            <p><b><i class="fas fa-tag"></i> Mã giảm giá:</b> {{ $bookTour->couponCode->cc_code }}</p>
            @if ($bookTour->couponCode->cc_percentage > 0)
                <p><b><i class="fas fa-percent"></i> Giảm giá:</b> {{ $bookTour->couponCode->cc_percentage }}%</p>
            @endif
            @php
            $discountedAmount = ($bookTour->b_number_adults * $bookTour->b_price_adults) + ($bookTour->b_number_children * $bookTour->b_price_children) + ($bookTour->b_number_child6 * ($bookTour->b_price_children )) + ($bookTour->b_number_child2 * ($bookTour->b_price_children ));
            $finalTotal =  $discountedAmount - $bookTour->b_total_price ;
          @endphp
        <p><b><i class="fas fa-money-bill"></i> Số tiền đã giảm:</b> {{ number_format($finalTotal , 0, ',', '.') }} VND</p>  
        </div>
    @endif
            <!-- Thêm các thông tin khác của chi tiết đợt tour tại đây -->
    
            <p><b>Phương thức thanh toán:</b> {{ $bookTour->b_payment_method }}<sup class="text-danger">(xem chi tiết <a href="http://127.0.0.1:8000/lien-he.html" target="_blank">tại đây</a>)</sup></p>
             <p><b>Ngày booking:</b> {{$bookTour->created_at}}</p>
             <?php
             $status = $bookTour->b_status;
             $statusText = '';
             
             switch ($status) {
                 case 1:
                     $statusText = 'Tiếp nhận';
                     break;
                 case 2:
                     $statusText = 'Đã xác nhận';
                     break;
                 case 3:
                     $statusText = 'Đã thanh toán';
                     break;
                 case 4:
                     $statusText = 'Đã kết thúc';
                     break;
                 case 5:
                     $statusText = 'Đã hủy';
                     break;
                 default:
                     $statusText = 'Trạng thái không xác định';
                     break;
             }
             ?>
             
             <p><b>Trạng thái đơn hàng:</b> {{$statusText}}</p>
             @if ($bookTour->payments)
             @foreach ($bookTour->payments as $payment)
                 <h3><strong class="text-center">Thông tin thanh toán</strong></h3>
                 <div class="discount-info">
                     <p>
                         <b><i class="fas fa-tag"></i> Số tiền</b> {{ $payment->p_total_price }}
                     </p>
                     @if ($payment->p_vnp_response_code === "00")
                         <p>
                             <b><i class="fas fa-check-circle"></i> Trạng thái:</b> Thành công
                         </p>
                     @elseif ($payment->p_vnp_response_code === "22")
                         <p>
                             <b><i class="fas fa-check-circle"></i> Trạng thái:</b> Đã hoàn tiền
                         </p>
                     @else
                         <p>
                             <b><i class="fas fa-times-circle"></i> Trạng thái:</b> Thất bại
                         </p>
                     @endif
                     @if(isset($payment->p_code_vnpay))
                         <p>
                             <b><i class="fas fa-barcode"></i> Mã giao dịch</b> {{ $payment->p_code_vnpay }}
                         </p>
                     @endif
                 </div>
             @endforeach
         @endif
        <!-- Thêm thông tin khác liên quan đến chuyến nghỉ -->
    </ul>
    
    <p>Xin cảm ơn!</p>
</body>
</html>