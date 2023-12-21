<!-- emailnhacnho.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Nhắc nhở: Chuyến đi sắp tới</title>
</head>
<body>
    <h2>Chào bạn, {{ $user->name }}!</h2>
    
    <p>Chúng tôi muốn nhắc nhở bạn về chuyến đi sắp tới của bạn.</p>
    
    <p>Thông tin chuyến đi:</p>
    <ul>
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
        <p><b>Mã booking:</b> <span style="color:red;">{{ $bookTour->id }}</span></p>
     
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

            <!-- Thêm các thông tin khác của chi tiết đợt tour tại đây -->
            <p><b>Phương thức thanh toán:</b>
                @if ($bookTour->b_payment_method === 'cash')
                <i class="fa fa-money"></i> Tiền mặt
            @elseif ($bookTour->b_payment_method === 'VNPay')
                <i class="fa fa-bank"></i> Thanh toán VNPay
                @elseif ($bookTour->b_payment_method === 'MOMO')
                <i class="fa fa-bank"></i> Thanh toán Ví MOMO
            @elseif ($bookTour->b_payment_method === 'bankTransfer')
                <i class="fa fa-university"></i> Chuyển khoản ngân hàng
              
            @endif
            </p>
            <!-- Thêm các thông tin khác của chi tiết đợt tour tại đây -->
        
     
  <p><b>Ngày Booking:</b> {{ $bookTour->b_book_date }}</p>
  <p><b>Ngày xác nhận:</b> {{$bookTour->updated_at}}</p>
     
    </ul>
    
    <p>Hãy chuẩn bị và đến trước cho chuyến đi để trải nghiệm tuyệt vời cùng chúng tôi.</p>
    
    <p>Xin cảm ơn và chúc bạn có một chuyến đi thú vị!</p>
    
    <p>Trân trọng,</p>
    <p>Đội ngũ của chúng tôi</p>
</body>
</html>