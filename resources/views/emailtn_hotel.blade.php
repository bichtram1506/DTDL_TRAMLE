<!-- emailtn_hotel.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation Email</title>
</head>
<body>
    <h1>Xác Nhận Đặt Phòng</h1>

    <p>Xin chào {{ $user->name }},</p>

    <p>Cảm ơn bạn đã đặt phòng tại {{ $hotel->h_name }}!</p>

    <p>Thông tin đặt phòng:</p>
    <ul>
        <li>Phòng: {{ $room->rm_name }}</li>
        <li>Số phòng: {{ $room->rm_code }}</li>
        <li>Tầng: {{ $room->rm_floor }}</li>
        <li>Ngày nhận phòng: {{ $booking->check_in->format('Y-m-d') }}</li>
        <li>Ngày trả phòng: {{ $booking->check_out->format('Y-m-d') }}</li>
        <li>Số ngày thuê: {{ $booking->check_in->diffInDays($booking->check_out) }}</li>
        <li>Số khách: {{ $booking->num_guest }}</li>
        <li>Tổng giá tiền: {{ $booking->total_price }}</li>
        
    @if($booking->bh_payment_method === 'vnpay')
    <p>Thanh toán trực tiếp qua VNPAY</p>
@elseif($booking->bh_payment_method === 'direct_payment')
    <p>Thanh toán chuyển khoản</p>
@else
    <p>Phương thức thanh toán không xác định</p>
@endif
    </ul>

    <p>Cảm ơn bạn và chúc bạn có một kỳ nghỉ tuyệt vời!</p>
</body>
</html>
