<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin-bottom: 10px;
            color: #555;
        }

        strong {
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
            color: #333;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        .order-details {
            margin-bottom: 20px;
        }

        .total-price {
            color: #e44d26;
        }

        .options {
            color: #333;
            margin-top: 20px;
        }

        a {
            color: #e44d26;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Chủ đề: Thông báo Hủy Tour - {{$tour->t_title}}</h1>
        <p>Kính gửi Quý khách hàng thân yêu,</p>

        <p>Chúng tôi xin chân thành xin lỗi và phải thông báo rằng tour "{{$eventdate->td_start_date}}" mà Quý khách đã đăng ký ngày {{$tour->t_title}} cùng chúng tôi đã phải bị hủy. Chúng tôi hiểu rằng điều này có thể gây không tiện và thất vọng, và xin chia sẻ lý do hủy cùng bạn.</p>

        <p><strong>Lý do hủy tour:</strong></p>

        <p>Chúng tôi rất tiếc phải thông báo rằng do tình hình thời tiết bất lợi, không đủ số lượng đăng ký, hoặc bất kỳ lý do an toàn nào khác, chúng tôi không thể tiến hành tour theo kế hoạch ban đầu.</p>

        <p>Chúng tôi hiểu rằng bạn đã đặt niềm tin vào chúng tôi và chúng tôi chia sẻ sự thất vọng của bạn về tình huống này. Đội ngũ chúng tôi đã cân nhắc nhiều về quyết định này và đảm bảo rằng sự an toàn và trải nghiệm của bạn luôn được đặt lên hàng đầu.</p>

        <p><strong>Thông tin đơn hàng:</strong></p>

        <div class="order-details">
            <p><b>Mã tour:</b> {{ $tour->id }}</p>
            <p><b>Tên tour:</b> {{ $tour->t_title }}</p>
            <p><b>Điểm khởi hành:</b> {{ $bookTour->b_address }}</p>
            <p><b>Ngày đi dự kiến:</b> {{$eventdate->td_start_date}}</p>
        </div>


        <div class="order-details total-price">
            <p><b>Trị giá booking:</b> {{ number_format($bookTour->b_total_price, 0,',','.') }} vnd</p>
            <strong>Số người lớn:</strong> {{ $bookTour->b_number_adults }}</li>
            @if ($bookTour->b_number_children > 0)
            <li><strong>Số trẻ em (6-12 tuổi):</strong> {{ $bookTour->b_number_children }}</li>
            @endif
            @if ($bookTour->b_number_child6 > 0)
            <strong>Số trẻ dưới 6 tuổi:</strong> {{ $bookTour->b_number_child6 }}</li>
            @endif
            @if ($bookTour->b_number_child2 > 0)
            <strong>Số trẻ dưới 2 tuổi:</strong> {{ $bookTour->b_number_child2 }}</li>
            @endif
        </div>

        <hr>

        <div class="order-details">
            <p><b>Mã booking:</b> <span style="color:red;">{{ $bookTour->id }}</span></p>
            <p><b>Phương thức thanh toán:</b> {{ $bookTour->b_payment_method }}<sup class="text-danger">(xem chi tiết <a href="http://127.0.0.1:8000/lien-he.html" target="_blank">tại đây</a>)</sup></p>
            <p><b>Ngày Booking:</b> {{ $bookTour->b_book_date }}</p>
        </div>

        <div class="options">
            <p><strong>Tùy chọn của bạn:</strong></p>
            <p>Chuyển đổi sang tour khác: Chúng tôi rất muốn cung cấp cho bạn sự lựa chọn khác để đảm bảo bạn có trải nghiệm du lịch tốt nhất. Bạn có thể chuyển đổi sang một tour khác trong danh sách của chúng tôi. Chúng tôi sẽ giúp bạn chọn tour thay thế và điều</p>
            <!-- Thêm các tùy chọn khác nếu cần -->
        </div>
    </div>
</body>

</html>
