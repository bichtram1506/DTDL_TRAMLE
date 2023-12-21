<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đặt Tour</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            color: #0077B5;
            text-align: center;
            font-weight: bold;
            margin-bottom: 15px;
        }

        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #e0e0e0;
        }

        .booking-info {
            background-color: #f9f9f9;
            border: 1px solid #e0e0e0;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .booking-info p {
            margin: 10px 0;
        }

        .total-price {
            font-weight: bold;
        }

        .discount-info {
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            width: 300px;
            text-align: center;
            margin: 0 auto;
            border-radius: 5px;
        }

        .detail {
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .customer-info {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .support-info {
            background-color: #f2f2f2;
            padding: 10px;
            border: 1px solid #ccc;
            width: 300px;
            text-align: center;
            margin: 0 auto;
            border-radius: 5px;
        }

        .btn-view-details {
            background-color: #0077B5;
            color: #fff;
            border-radius: 5px;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>Xin chân thành cảm ơn quý khách đã lựa chọn dịch vụ của chúng tôi!</h3>
        <p style="text-align: center;">Chúng tôi đã nhận được đơn đặt tour của quý khách và sẽ liên hệ trong thời gian sớm nhất để hoàn tất quá trình xác nhận. Trân trọng!</p>        
        <hr>
        <h3>Phiếu tiếp nhận booking</h3>
        <div class="booking-info">
            <p><b>Mã tour: </b> {{$tour->t_code}} </p>
            <p><b>Tên tour:</b> {{$tour->t_title}}</p>
            <p><b>Ngày đi dự kiến:</b> {{$eventdate->td_start_date}}</p>
            <p><b>Điểm khởi hành:</b> {{ $tour->t_starting_gate }}</p>
            <hr>
            <p><b>Mã booking:</b> <span style="color:#FF0000;">{{$booktour->id}}</span><br><span style="color:#FF0000;">Xin quý khách vui lòng nhớ số booking để thuận tiện cho giao dịch sau này</span></p>
           
            <p><b>Trị giá booking:</b> {{ number_format($booktour->b_total_price, 0,',','.') }} VND</p>
                 <!-- Thêm biểu tượng cho thông tin giảm giá -->
                 @if ($booktour->couponCode)
                 <div class="discount-info">
                     <p><b><i class="fas fa-tag"></i> Mã giảm giá:</b> {{ $booktour->couponCode->cc_code }}</p>
                     @if ($booktour->couponCode->cc_percentage > 0)
                         <p><b><i class="fas fa-percent"></i> Giảm giá:</b> {{ $booktour->couponCode->cc_percentage }}%</p>
                     @endif
                     @php
                     $discountedAmount = ($booktour->b_number_adults * $booktour->b_price_adults) + ($booktour->b_number_children * $booktour->b_price_children) + ($booktour->b_number_child6 * ($booktour->b_price_children )) + ($booktour->b_number_child2 * ($booktour->b_price_children ));
                     $finalTotal =  $discountedAmount - $booktour->b_total_price ;
                   @endphp
                 <p><b><i class="fas fa-money-bill"></i> Số tiền đã giảm:</b> {{ number_format($finalTotal , 0, ',', '.') }} VND</p>
                 </div>
             @endif
            <strong>Số người lớn:</strong> {{ $booktour->b_number_adults }}
         @php
            $adultPrice = $booktour->b_price_adults; // Giả sử giá vé người lớn lưu trong thuộc tính b_price_adults
            $totalAdultPrice = $booktour->b_number_adults * $adultPrice;
        @endphp

        <p><strong>Tổng giá vé người lớn:</strong> {{ number_format($totalAdultPrice, 0, ',', '.') }} VND</p>

        @if ($booktour->b_number_children > 0)
        <strong>Số trẻ em (6-12 tuổi):</strong> {{ $booktour->b_number_children }}
        @php
            $childPrice = $booktour->b_price_children; // Giả sử giá vé trẻ em (6-12 tuổi) lưu trong thuộc tính b_price_children
            $totalChildPrice = $booktour->b_number_children * $childPrice;
        @endphp
        <p><strong>Tổng giá vé trẻ em (6-12 tuổi):</strong> {{ number_format($totalChildPrice, 0, ',', '.') }} VND</p>
    @endif

    @if ($booktour->b_number_child6 > 0)
        <strong>Số trẻ dưới 6 tuổi:</strong> {{ $booktour->b_number_child6 }}
        @php
            $child6Price = $booktour->b_price_child6; // Giả sử giá vé trẻ em dưới 6 tuổi lưu trong thuộc tính b_price_child6
            $totalChild6Price = $booktour->b_number_child6 * $child6Price;
        @endphp
        <p><strong>Tổng giá vé trẻ em dưới 6 tuổi:</strong> {{ number_format($totalChild6Price, 0, ',', '.') }} VND</p>
    @endif

    @if ($booktour->b_number_child2 > 0)
        <strong>Số trẻ dưới 2 tuổi:</strong> {{ $booktour->b_number_child2 }}
        @php
            $child2Price = $booktour->b_price_child2; // Giả sử giá vé trẻ em dưới 2 tuổi lưu trong thuộc tính b_price_child2
            $totalChild2Price = $booktour->b_number_child2 * $child2Price;
        @endphp
        <p><strong>Tổng giá vé trẻ em dưới 2 tuổi:</strong> {{ number_format($totalChild2Price, 0, ',', '.') }} VND</p>
    @endif
    @if (isset($extraServiceArray[$booktour->id]) && count($extraServiceArray[$booktour->id]) > 0)
    <ul>
        <p><b>Dịch vụ tour kèm theo: <i class="fas fa-suitcase"></i></b></p>
        @foreach ($extraServiceArray[$booktour->id] as $extraService)
            <li>
                <div style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                    <p style="margin: 0; color: #040303;">Dịch vụ: {{ $extraService['name'] }}</p>
                    <p style="margin: 0; color: #140c0c;">Giá: {{ $extraService['price'] }} VND</p>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
                <p><b>Ngày booking:</b> {{ \Carbon\Carbon::parse($booktour->b_book_date)->format('H:i:s d/m/Y') }}   </p>
                <p><b>Phương thức thanh toán:</b></p>
                @if ($booktour->b_payment_method === 'cash')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-money" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Tiền mặt</span>
                    </p>
                    <p style="margin-bottom: 10px;">Vui lòng đến cửa hàng của chúng tôi để thanh toán trực tiếp:</p>
                    <p style="margin-bottom: 5px;">CÔNG TY CỔ PHẦN DU LỊCH VIETOURIST</p>
                    <p style="margin-bottom: 5px;">Địa chỉ: 154 Lý Chính Thắng, Phường 7, Quận 3, TP. HCM</p>
                    <p style="margin-bottom: 5px;">Điện thoại: 08. 62 61 63 65</p>
                    <p style="margin-bottom: 5px;">Hotline: 089 990 9145</p>
                @elseif ($booktour->b_payment_method === 'VNPay')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-bank" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Thanh toán VNPay</span>
                    </p>
                    @elseif ($booktour->b_payment_method === 'MOMO')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-bank" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Thanh toán Ví MOMO</span>
                    </p>
                @elseif ($booktour->b_payment_method === 'bankTransfer')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-university" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Chuyển khoản ngân hàng</span>
                    </p>
                    <p style="margin-bottom: 10px;">Vui lòng sử dụng thông tin tài khoản dưới đây để chuyển khoản:</p>
                    <p style="margin-bottom: 5px;">Ngân hàng: Tên ngân hàng</p>
                    <p style="margin-bottom: 5px;">Chi nhánh: Chi nhánh XYZ</p>
                    <p style="margin-bottom: 5px;">Số tài khoản: 1601100633008</p>
                    <p style="margin-bottom: 5px;">Chủ tài khoản: Lê Thi Bích Trâm</p>
                    <p style="margin-bottom: 5px;">Nội dung chuyển khoản: [Mã đơn hàng, Tên khách hàng]</p>
                @endif
       
             
             
              
              @if ($booktour->b_note)
              <div class="detail">
                  <p><b>Ghi chú:</b>
                      {{ $booktour->b_note }}</p>
              </div>
              @endif
          
         
            <p><b>Thời hạn xác nhận:</b> 3 ngày sau booking</p>
            <p style="color:#FF0000;"><b>Quý khách có thể quản lý booking tại thông tin khách hàng</b></p>
        </div>
        <hr>
        <h3>Thông tin khách hàng</h3>
        <div class="customer-info">
            @if ($user)
                <p><b>Họ tên:</b> {{$user->name}}</p>
                <p><b>Email:</b> {{$user->email}}</p>
                <p><b>Số điện thoại:</b> {{$user->phone}}</p>
                <p><b>Địa chỉ:</b> {{$user->address}}</p>
            @else
                <p><b>Họ tên:</b> {{$booktour->b_name}}</p>
                <p><b>Email:</b> {{$booktour->b_email}}</p>
                <!-- Hiển thị các thông tin khác từ BookTour nếu có -->
            @endif
        </div>
        <div class="support-info">
            <p style="font-size: 18px; color: #333;">Hỗ trợ khách hàng</p>
            <p style="color: #007bff;">Hotline: 1900 1808</p>
            <p style="color: #007bff;">Email: info@saigontourist.net</p>
            <p style="color: #007bff;">Bạn muốn được gọi lại?</p>
        </div>
   
      
    <hr style="margin: 20px 0;">
    <div style="text-align: center;">
        <a href="{{ route('my.tour') }}" style="background-color:#0077B5; color:#fff; border-radius: 5px; padding: 10px 20px; text-decoration: none;">Xem thông tin chi tiết tại trang web </a>
    </div>
</div>
