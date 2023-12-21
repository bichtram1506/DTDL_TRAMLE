<!-- email_cancel_booking.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Email</title>
</head>
<body>
    <h1>Xác Nhận HỦY Đặt Phòng</h1>

    <p>Xin chào {{ $user->name }},</p>

    <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>

    <p>Thông tin hủy đặt phòng:</p>
    <ul>
        <li>Phòng: {{ $room->rm_name }}</li>
        <li>Số phòng: {{ $room->rm_code }}</li>
        <li>Tầng: {{ $room->rm_floor }}</li>
        <li>Ngày nhận phòng: {{ \Carbon\Carbon::parse($booking->check_in)->format('Y-m-d') }}</li>
        <li>Ngày trả phòng: {{ \Carbon\Carbon::parse($booking->check_out)->format('Y-m-d') }}</li>        
        <li>Số ngày thuê: {{ \Carbon\Carbon::parse($booking->check_in)->diffInDays(\Carbon\Carbon::parse($booking->check_out)) }}</li>

        <li>Số khách: {{ $booking->num_guest }}</li>
        <li>Tổng giá tiền: {{ $booking->total_price }}</li>
        
        @if($booking->bh_payment_method === 'vnpay')
            <li>Phương thức thanh toán: Thanh toán trực tiếp qua VNPAY</li>
        @elseif($booking->bh_payment_method === 'direct_payment')
            <li>Phương thức thanh toán: Thanh toán chuyển khoản</li>
        @else
            <li>Phương thức thanh toán không xác định</li>
        @endif
    </ul>

    <p>Đặt phòng của bạn đã được hủy thành công. Chúng tôi hy vọng sẽ phục vụ bạn trong những dịp sắp tới.</p>

    <p>Cảm ơn bạn và chúc bạn một ngày tốt lành!</p>
</body>
</html>
