<div style="background-color:#F7F7F7; border: 1px solid #ECECEC; padding: 20px;">
    <h3 style="color:#0077B5; text-align: center; font-weight: bold;">Cảm ơn quý khách đã sử dụng dịch vụ của chúng tôi</h3>
    @if ($vnp_ResponseCode == "00")
        <p style="text-align: center;">Booking của quý khách đã được thanh toán thành công</p>
        <hr style="margin: 20px 0;">
        <h3 style="color:#0077B5; font-weight: bold;">Phiếu xác nhận Thanh toán: <b style="border-color: green; border-style: solid; color: green">ĐÃ THANH TOÁN</b></h3>
    @else
        <p style="text-align: center;">Booking của quý khách đã không thành công</p>
        <hr style="margin: 20px 0;">
        <h3 style="color:#0077B5; font-weight: bold;">Phiếu xác nhận Thanh toán: <b style="border-color: red; border-style: solid; color: red">THANH TOÁN THẤT BẠI</b></h3>
    @endif
  <div style="background-color:#fff; border: 1px solid #ECECEC; padding: 20px;">
    <p><b>Mã tour:</b> {{ $tour->t_code }}</p>
    <p><b>Tên tour:</b> {{ $tour->t_title }}</p>
    <p><b>Điểm khởi hành:</b> {{ $tour->t_starting_gate }}</p>
    <li><strong>Điểm Đến :</strong>  @foreach ($tour->locations as $key => $location)
        <span>{{ $location->l_name }}</span>
        @if ($key < count($tour->locations) - 1)
            <span>, </span>
        @endif
    @endforeach
</li>
    <p><b>Ngày đi dự kiến:</b> {{$eventdate->td_start_date}}</p>
    <hr style="margin: 20px 0;">
    <p><b>Mã booking:</b> <span style="color:{{ $vnp_ResponseCode == "00" ? 'green' : 'red' }}">{{ $bookTour->id }}</span></p>
  
    <p><b>Trị giá booking:</b> {{ number_format($bookTour->b_total_price, 0,',','.') }} vnd</p>

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
    @if (isset($extraServiceArray[$bookTour->id]) && count($extraServiceArray[$bookTour->id]) > 0)
    <ul>
        <p><b>Dịch vụ tour kèm theo: <i class="fas fa-suitcase"></i></b></p>
        @foreach ($extraServiceArray[$bookTour->id] as $extraService)
            <li>
                <div style="background-color: #f2f2f2; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                    <p style="margin: 0; color: #040303;">Dịch vụ: {{ $extraService['name'] }}</p>
                    <p style="margin: 0; color: #140c0c;">Giá: {{ $extraService['price'] }}</p>
                </div>
            </li>
        @endforeach
    </ul>
    @endif
             <!-- Thêm biểu tượng cho thông tin giảm giá -->
          
         @if ($bookTour->b_note)
         <div class="detail">
             <p><b>Ghi chú:</b>
                 {{ $bookTour->b_note }}</p>
         </div>
         @endif
        <!-- Thêm các thông tin khác của chi tiết đợt tour tại đây -->

        <p><b>Phương thức thanh toán:</b> {{ $bookTour->b_payment_method }}</p>
         <p><b>Ngày booking:</b> {{$bookTour->created_at}}</p>
          @if ($vnp_ResponseCode == "00") <p><b>Đã thanh toán: </b style="color:{{ $vnp_ResponseCode == "00" ? 'green' : 'red' }}">{{ number_format($bookTour->b_total_price, 0,',','.') }} vnd </p>
            @if($bookTour->payments->count() > 0)
            <p><b>Ngày thanh toán:</b></p>
            <ul>
                @foreach($bookTour->payments as $payment)
                    <li>{{ $payment->created_at->format('d/m/Y') }}</li>
                @endforeach
            </ul>
        @else
            <p><b>Ngày thanh toán:</b> N/A</p>
        @endif
         @endif
</div>
<hr style="margin: 20px 0;">
<h3 style="color:#0077B5; font-weight: bold;">Thông tin khách hàng</h3>
<div style="background-color:#fff; border: 1px solid #ECECEC; padding: 20px;">
    @if ($user)
        <p><b>Họ tên:</b> {{$user->name}}</p>
        <p><b>Email:</b> {{$user->email}}</p>
        <p><b>Số điện thoại:</b> {{$user->phone}}</p>
        <p><b>Địa chỉ:</b> {{$user->address}}</p>
    @else
        <p><b>Họ tên:</b> {{$bookTour->b_name}}</p>
        <p><b>Email:</b> {{$bookTour->b_email}}</p>
        <!-- Hiển thị các thông tin khác từ BookTour nếu có -->
    @endif
</div>
<div style="background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc; width: 300px; text-align: center; margin: 0 auto;">
    <p style="font-size: 18px; color: #333;">Hỗ trợ khách hàng</p>
    <p style="color: #007bff;">Hotline: 1900 1808</p>
    <p style="color: #007bff;">Email: info@saigontourist.net</p>
    <p style="color: #007bff;">Bạn muốn được gọi lại?</p>
  </div>
  
<hr style="margin: 20px 0;">
<div style="text-align: center;">
    <a href="{{ route('my.tour') }}" style="background-color:#0077B5; color:#fff; border-radius: 5px; padding: 10px 20px; text-decoration: none;">Xem thông tin chi tiết tại trang web </a>
</div>
