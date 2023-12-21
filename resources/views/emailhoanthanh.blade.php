<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo và Khảo sát Sau Tour</title>
    <style>
        /* Thiết lập các kiểu CSS cho email */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Đánh giá trải nghiệm sau chuyến đi</h1>
        <p>Kính gửi :
            @if ($user)
            <p><b>Họ tên:</b> {{$user->name}}</p>
            <p><b>Email:</b> {{$user->email}}</p>
           
        @else
            <p><b>Họ tên:</b> {{$bookTour->b_name}}</p>
            <p><b>Email:</b> {{$bookTour->b_email}}</p>
            <!-- Hiển thị các thông tin khác từ BookTour nếu có -->
        @endif
        </p>
        <p>
            Chúng tôi xin chân thành cảm ơn bạn đã tham gia tour <strong>{{$tour->t_title}}</strong> với mã đặt <span style="color:red;">{{ $bookTour->id }}</span> vào ngày {{$eventdate->td_start_date}} của chúng tôi gần đây. Chúng tôi rất mong muốn biết ý kiến của bạn về trải nghiệm của mình để có cơ hội cải thiện dịch vụ và đảm bảo rằng bạn có trải nghiệm tốt nhất trong các tour tiếp theo.
        </p>
        <p>
            Hãy tham gia khảo sát của chúng tôi bằng cách nhấn vào nút bên dưới:
        </p>
        <p>
            <a class="button" href="https://docs.google.com/forms/d/e/1FAIpQLSeGhaVQPT6qFtNWdOQhCaZyVvwJ55HO0JaFicsGqcBp6hJ9tg/viewform" target="_blank"> Tham gia khảo sát</a>
        </p>
        
        <p>
            Sau khi hoàn thành tour, hãy để lại ý kiến và bình luận của bạn để chia sẻ trải nghiệm của mình với chúng tôi:
        </p>
        @if ($user)<p>
            <a href="{{ route('danh.gia.don', ['id' => $bookTour->id]) }}" class="btn btn-primary"><i class="fas fa-star"></i> Đánh giá</a> 
        </p>
        @endif
        
        <p>
            Khảo sát này sẽ chỉ mất một ít thời gian của bạn, và ý kiến của bạn rất quan trọng đối với chúng tôi. Chúng tôi đánh giá cao sự chia sẻ của bạn về trải nghiệm du lịch và sẽ sử dụng thông tin này để cải thiện và phục vụ bạn tốt hơn.
        </p>
        <p>
            Như một lời cảm ơn, chúng tôi muốn gửi đến bạn một ưu đãi đặc biệt cho các tour tiếp theo. Chúng tôi sẽ cung cấp cho bạn mã giảm giá 10% khi bạn đặt tour tiếp theo của chúng tôi.
        </p>
     
   
        <p>
            Nếu bạn có bất kỳ câu hỏi hoặc góp ý nào khác, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại dưới đây:
        </p>
        <p>
            Email: [Địa chỉ email của bạn]<br>
            Số điện thoại: [Số điện thoại của bạn]
        </p>
        <p>
            Một lần nữa, chúng tôi xin cảm ơn bạn đã chọn chúng tôi và mong được phục vụ bạn trong tương lai.
        </p>
        <p>Trân trọng,</p>
        <p>Lê Thị Bích Trâm</p>
        <p>Công ty Du Lịch Việt</p>
    </div>
</body>
</html>
