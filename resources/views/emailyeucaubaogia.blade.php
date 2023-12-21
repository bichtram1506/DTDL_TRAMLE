<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Yêu cầu báo giá</title>
</head>
<body>
    <h1>Yêu cầu báo giá</h1>

    <p>Xin chào,</p>
    
    <p>Bạn đã gửi yêu cầu báo giá cho tour sau:</p>
    
    <p>
        <strong>Tên tour:</strong> {{ $tour->t_title }}<br>
        <strong>Mã tour:</strong> {{ $tour->t_code }}
        <div class="button">
            <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_code)]) }}">Xem chi tiết Tour</a>
        </div>
    </p>
    <p><b>Điểm khởi hành:</b> {{ $tour->t_starting_gate }}</p>
    <li><strong>Điểm Đến :</strong>  @foreach ($tour->locations as $key => $location)
        <span>{{ $location->l_name }}</span>
        @if ($key < count($tour->locations) - 1)
            <span>, </span>
        @endif
    @endforeach
</li>
     @foreach ($tour->eventdate as $eventdate)
        @if ($eventdate->bookTour->isNotEmpty())
            <p>Mã đơn hàng: {{ $eventdate->bookTour->first()->id }}</p>
        @endif
    @endforeach
    
    @foreach ($tour->eventdate as $eventdate)
        @if ($eventdate->bookTour->isNotEmpty())
            <p>Tổng vé: {{ $eventdate->bookTour->first()->b_total_ticket }}</p>
        @endif
    @endforeach
    <p><b>Mã booking:</b> <span style="color:red;">{{ $bookTour->id }}</span></p>
         
    <p>
        <b>Trị giá booking:</b> 
        @if($bookTour->b_total_price != 0)
            {{ number_format($bookTour->b_total_price, 0, ',', '.') }} vnd
        @else
            Đang cập nhật
        @endif
    </p>
    

    <strong>Số người lớn:</strong> {{ $bookTour->b_number_adults }}
    @php
        $adultPrice = $bookTour->b_price_adults;
        $totalAdultPrice = $bookTour->b_number_adults * $adultPrice;
    @endphp
      @if ($totalAdultPrice > 0)
    <p><strong>Tổng giá vé người lớn:</strong> {{ number_format($totalAdultPrice, 0, ',', '.') }} VND</p>
    @else
    <p>Giá đang được cập nhật.</p>
@endif
    @if ($bookTour->b_number_children > 0)
        <strong>Số trẻ em (6-12 tuổi):</strong> {{ $bookTour->b_number_children }}
        @php
            $childPrice = $bookTour->b_price_children;
            $totalChildPrice = $bookTour->b_number_children * $childPrice;
        @endphp
        @if ($totalChildPrice > 0)
            <p><strong>Tổng giá vé trẻ em (6-12 tuổi):</strong> {{ number_format($totalChildPrice, 0, ',', '.') }} VND</p>
        @else
            <p>Giá đang được cập nhật.</p>
        @endif
    @endif
    
    @if ($bookTour->b_number_child6 > 0)
        <strong>Số trẻ dưới 6 tuổi:</strong> {{ $bookTour->b_number_child6 }}
        @php
            $child6Price = $bookTour->b_price_child6;
            $totalChild6Price = $bookTour->b_number_child6 * $child6Price;
        @endphp
        @if ($totalChild6Price > 0)
            <p><strong>Tổng giá vé trẻ em dưới 6 tuổi:</strong> {{ number_format($totalChild6Price, 0, ',', '.') }} VND</p>
        @else
            <p>Giá đang được cập nhật.</p>
        @endif
    @endif
    
    @if ($bookTour->b_number_child2 > 0)
        <strong>Số trẻ dưới 2 tuổi:</strong> {{ $bookTour->b_number_child2 }}
        @php
            $child2Price = $bookTour->b_price_child2;
            $totalChild2Price = $bookTour->b_number_child2 * $child2Price;
        @endphp
        @if ($totalChild2Price > 0)
            <p><strong>Tổng giá vé trẻ em dưới 2 tuổi:</strong> {{ number_format($totalChild2Price, 0, ',', '.') }} VND</p>
        @else
            <p>Giá đang được cập nhật.</p>
        @endif
    @endif
    
    <p><b>Phương thức thanh toán:</b>
        @if ($bookTour->b_payment_method === 'cash')
        <i class="fa fa-money"></i> Tiền mặt
        <p> Vui lòng đến cửa hàng của chúng tôi để thanh toán trực tiếp:

            CÔNG TY CỔ PHẦN DU LỊCH VIETOURIST
            
            Địa chỉ: 154 Lý Chính Thắng, Phường 7, Quận 3, TP. HCM
            
            Điện thoại: 08. 62 61 63 65
            
            Hotline: 089 990 9145</p>
    @elseif ($bookTour->b_payment_method === 'VNPay')
        <i class="fa fa-bank"></i> Thanh toán VNPay
        @elseif ($bookTour->b_payment_method === 'MOMO')
        <i class="fa fa-bank"></i> Thanh toán Ví MOMO
       
    @elseif ($bookTour->b_payment_method === 'bankTransfer')
        <i class="fa fa-university"></i> Chuyển khoản ngân hàng
        <p> Vui lòng sử dụng thông tin tài khoản dưới đây để chuyển khoản:

            Ngân hàng: Tên ngân hàng
            
            Chi nhánh: Chi nhánh XYZ
            
            Số tài khoản: 1601100633008
            
            Chủ tài khoản: Lê Thi Bích Trâm
            
            Nội dung chuyển khoản: [Mã đơn hàng, Tên khách hàng]
        </p>
    @endif
    </p>
    <p>Xin vui lòng xem và xử lý yêu cầu này.</p>
    
    <p>Trân trọng,</p>
    <p>Đội ngũ của chúng tôi</p>
</body>
</html>