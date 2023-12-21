<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận duyệt báo giá</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f4f4f4; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        <h2>Xác nhận duyệt báo giá</h2>
        <p>Xin chào {{ $user->name ?? $bookTour->b_name }},</p>
        <p>Báo giá cho tour {{ $tour->t_code }} - {{ $tour->t_title }} của bạn đã được duyệt thành công.</p>
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
    
        <p>Bạn có thể tiếp tục thanh toán và chuẩn bị chuyến đi tour ngay bây giờ.</p>
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
            <a href="{{ route('process_payment') }}?booktourId={{ $bookTour->id }}&b_total_price={{ $bookTour->b_total_price }}">Tiếp tục thanh toán</a>
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
        <div class="button">
            <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_code)]) }}">Xem chi tiết Tour</a>
        </div>
        <p>Xin cảm ơn!</p>
       
    </div>
</body>
</html>