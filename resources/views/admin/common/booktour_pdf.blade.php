<!DOCTYPE html>
<html>
<head>
    <title>Hóa đơn</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
}

h1 {
    text-align: center;
    color: #333;
}

.invoice-container {
    border: 1px solid #ccc;
    padding: 20px;
    max-width: 600px;
    margin: 0 auto;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.section-content {
    margin-bottom: 20px;
}

.section-title {
    font-weight: bold;
    margin-top: 10px;
    color: #333;
}

p {
    margin: 0;
}

/* Style for alternate sections, to improve readability */
.section-content:nth-child(odd) {
    background-color: #f9f9f9;
}

/* Style for the header */
.invoice-container h1 {
    color: #4CAF50;
}

/* Style for the total price section */
.section-content.total-price {
    background-color: #4CAF50;
    color: #fff;
    font-weight: bold;
}

/* Style for the additional services section */
.section-content.extra-service {
    border: 1px solid #ddd;
    padding: 10px;
    margin-top: 10px;
}

/* Responsive design for smaller screens */
@media screen and (max-width: 600px) {
    .invoice-container {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <div class="invoice-container">
        <h1>Hóa đơn</h1>

        @if(isset($invoiceData['user_id']))
            <div class="section-content">
                <p class="section-title">Mã người dùng:</p>
                <p>{{ $invoiceData['user_id'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['coupon_code_id']))
            <div class="section-content">
                <p class="section-title">Mã giảm giá:</p>
                <p>{{ $invoiceData['coupon_code_id'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['address']))
            <div class="section-content">
                <p class="section-title">Địa chỉ:</p>
                <p>{{ $invoiceData['address'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['status']))
            <div class="section-content">
                <p class="section-title">Trạng thái:</p>
                <p>Đã thanh toán</p>
            </div>
        @endif

        @if(isset($invoiceData['payment_method']))
            <div class="section-content">
                <p class="section-title">Phương thức thanh toán:</p>
                <p>{{ $invoiceData['payment_method'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['reason']))
            <div class="section-content">
                <p class="section-title">Lý do:</p>
                <p>{{ $invoiceData['reason'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['book_date']))
            <div class="section-content">
                <p class="section-title">Ngày đặt:</p>
                <p>{{ $invoiceData['book_date'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['total_price']))
            <div class="section-content">
                <p class="section-title">Tổng giá:</p>
                <p>{{ $invoiceData['total_price'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['tourdetail_id']))
            <div class="section-content">
                <p class="section-title">Mã Khởi hành Tour:</p>
                <p>{{ $invoiceData['tourdetail_id'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['total_ticket']))
            <div class="section-content">
                <p class="section-title">Tổng số vé:</p>
                <p>{{ $invoiceData['total_ticket'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['extra_service_id']))
        @php
            $extraServices = json_decode($invoiceData['extra_service_id'], true);
        @endphp
    
        @if(is_array($extraServices))
            @foreach($extraServices as $extraService)
                <div class="section-content">
                    <p class="section-title">Mã dịch vụ bổ sung:</p>
                    <p>ID: {{ $extraService['id'] }}</p>
                    <p>Tên: {{ $extraService['name'] }}</p>
                    <p>Giá: {{ $extraService['price'] }}</p>
                </div>
            @endforeach
        @endif
    @endif

        @if(isset($invoiceData['price_adults']))
            <div class="section-content">
                <p class="section-title">Giá cho người lớn:</p>
                <p>{{ $invoiceData['price_adults'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['price_children']))
            <div class="section-content">
                <p class="section-title">Giá cho trẻ em:</p>
                <p>{{ $invoiceData['price_children'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['number_adults']))
            <div class="section-content">
                <p class="section-title">Số lượng người lớn:</p>
                <p>{{ $invoiceData['number_adults'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['number_children']))
            <div class="section-content">
                <p class="section-title">Số lượng trẻ em:</p>
                <p>{{ $invoiceData['number_children'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['price_child6']))
            <div class="section-content">
                <p class="section-title">Giá cho trẻ dưới 6 tuổi:</p>
                <p>{{ $invoiceData['price_child6'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['price_child2']))
            <div class="section-content">
                <p class="section-title">Giá cho trẻ dưới 2 tuổi:</p>
                <p>{{ $invoiceData['price_child2'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['number_child6']))
            <div class="section-content">
                <p class="section-title">Số lượng trẻ dưới 6 tuổi:</p>
                <p>{{ $invoiceData['number_child6'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['number_child2']))
            <div class="section-content">
                <p class="section-title">Số lượng trẻ dưới 2 tuổi:</p>
                <p>{{ $invoiceData['number_child2'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['name']))
            <div class="section-content">
                <p class="section-title">Tên:</p>
                <p>{{ $invoiceData['name'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['email']))
            <div class="section-content">
                <p class="section-title">Email:</p>
                <p>{{ $invoiceData['email'] }}</p>
            </div>
        @endif

        @if(isset($invoiceData['phone']))
            <div class="section-content">
                <p class="section-title">Số điện thoại:</p>
                <p>{{ $invoiceData['phone'] }}</p>
            </div>
        @endif
    </div>
</body>
</html>