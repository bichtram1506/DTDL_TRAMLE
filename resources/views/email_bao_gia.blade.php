<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo giá Tour</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3 {
            color: #007BFF;
            text-align: center;
        }

        p, .content, .description {
            color: #495057;
            line-height: 1.6;
        }

        h2, h3 {
            margin-top: 20px;
        }

        .quote {
            margin: 20px 0;
            background-color: #d4edda;
            padding: 15px;
            border-radius: 5px;
        }

        .itinerary, .pricing {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #c3c3c3;
            border-radius: 5px;
            background-color: #fff;
        }

        .button {
            text-align: center;
            margin-top: 20px;
        }

        .button a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007BFF;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button a:hover {
            background-color: #0056b3;
        }

        .day {
            margin-bottom: 20px;
            border-bottom: 1px solid #c3c3c3;
            padding-bottom: 15px;
        }

        .day h3 {
            font-size: 20px;
            color: #343a40;
            margin-bottom: 10px;
        }

        .day .content {
            font-size: 16px;
            color: #495057;
            margin-bottom: 10px;
        }

        .day .description {
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Báo giá Tour {{ $tour->t_title }} - {{ $tour->t_code }}</h1>
        <h2>Thời gian: {{ $tour->t_day }} ngày / {{ $tour->t_night }} đêm</h2>
        <p>Xin chào {{ $user->name ?? $bookTour->b_name }},</p>
        <p>Dưới đây là báo giá cho tour "{{ $tour->t_title }}".</p>
        
        <div class="itinerary">
            <h2>Lịch trình tour</h2>
            @foreach ($tourItineraries as $itinerary)
                <div class="day">
                    <h3>Ngày {{ $itinerary->ti_day }}</h3>
                    <p class="content">{{ $itinerary->ti_content }}</p>
                    <p class="description">{{ $itinerary->ti_description }}</p>
                </div>
            @endforeach
        </div> 
        
        <div class="quote">
            <h2>Giá tour:</h2>
            <p>Giá cho người lớn: {{ $adultPrice }} VND</p>
            <p>Giá cho trẻ em: {{ $childPrice }} VND</p>
            <p>Bao gồm:
                @if ($tour->service_ids)
                @php
                    $serviceData = json_decode($tour->service_ids, true);
                    $selectedServices = $serviceData['selected_services'];
                    $descriptions = isset($serviceData['descriptions']) ? $serviceData['descriptions'] : [];
                @endphp
            
                @if (!empty($selectedServices))
                    @foreach ($selectedServices as $serviceId)
                        @php
                            $service = \App\Models\Service::find($serviceId);
                            $description = isset($descriptions[$serviceId]) ? $descriptions[$serviceId] : '';
                        @endphp
            
                        <div style="background-color: #f5f5f5; border: 1px solid #ccc; border-radius: 10px; margin-bottom: 15px; padding: 15px;">
                            <strong style="font-size: 16px; color: #ff0000; margin-bottom: 10px; display: block;">{{ $service->sv_name }}</strong>
                            <p style="font-size: 14px; color: #000000;">{{ $description }}</p>
                        </div>
            
                    @endforeach
                @else
                    {{-- Xử lý khi mảng không có phần tử --}}
                    <p>Không có dịch vụ nào được chọn</p>
                @endif
            @endif
            </p>
            <p>Không bao gồm: Phí cá nhân, chi phí không được đề cập trong phần "Bao gồm".</p>
        </div>
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
        
     
  <p><b>Ngày Booking:</b> {{ $bookTour->b_book_date }}</p>
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
        <div class="pricing">
            <p>Xin vui lòng xem chi tiết báo giá và lịch trình tour trên trang web của chúng tôi.</p>
        </div>
        
        <div class="button">
            <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_code)]) }}">Xem chi tiết Tour</a>
        </div>
    </div>
</body>
</html>
