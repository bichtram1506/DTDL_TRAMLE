@extends('page.layouts.page')
@section('title', 'Đặt Khách Sạn')
@section('style')
@stop
@section('seo')
@stop
@section('content')
@php
    $roomList = json_encode($rooms);
@endphp

<section class="ftco-section ftco-no-pb contact-section ">
    <div class="container">
        <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Hotels <i class="fa fa-chevron-right"></i></span></p>
        <h1 class="text-center mb-0 bread title-highlight">Đặt Khách sạn</h1>
    </div>
</section>
<section class="ftco-section ftco-no-pb contact-section">
    <div class="container">
        <div id="hotelId" data-hotel-id="{{ $hotel->id }}"></div>
        <div class="row">
            <!-- Cột đầu tiên -->
    <div class="col-md-6">
                <form action="{{ route('post.book.room', ['id' => $hotel->id]) }}" method="POST" class="booking-form">
                    @csrf
                    <!-- Trong form -->
                    <div class="form-group">
                        <label for="check_in" class="form-label">Ngày nhận phòng:</label>
                        <input type="date" name="check_in" id="check_in" class="form-control" required min="{{ date('Y-m-d') }}" onchange="calculateTotalPrice()">
                    </div>

                    <div class="form-group">
                        <label for="check_out" class="form-label">Ngày trả phòng:</label>
                        <input type="date" name="check_out" id="check_out" class="form-control" required onchange="calculateTotalPrice()">
                    </div>

                    <div class="form-group">
                        <label for="num_guest" class="form-label">Số lượng khách:</label>
                        <input type="number" name="num_guest" id="num_guest" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="bh_room_id" class="form-label">Chọn phòng:</label>
                        <select name="bh_room_id" id="bh_room_id" class="form-control" required onchange="calculateTotalPrice()">
                            <option value="">Chọn phòng</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" data-price="{{ $room->rm_price }}">
                                {{ $room->rm_name }} ({{ $room->rm_code }}) - Lầu {{ $room->rm_floor }} - {{ $room->rm_price }} VNĐ
                            </option>                            
                            
                            @endforeach
                        </select>
                    </div>

                    <!-- Trường tổng tiền -->
                  
            </div>
            
            <!-- Cột thứ hai -->
            <div class="col-md-6">
                <!-- Đưa nội dung danh sách phòng ở đây -->
                        <div class="form-group">
                            <label for="bh_payment_method" class="form-label">Phương thức thanh toán:</label>
                            <select name="bh_payment_method" id="bh_payment_method" class="form-control" required>
                                <option value="">Chọn phương thức thanh toán</option>
                                <option value="direct_payment">Thanh toán trực tiếp</option>
                                <option value="vnpay">Thanh toán qua chuyển khoản</option>
                                <!-- Thêm các phương thức thanh toán khác nếu cần -->
                            </select>
                        </div>
                        <!-- Thêm các phương thức thanh toán khác nếu cần -->
                    </select>
                </div>
            </div>  
            <div class="d-flex justify-content-center">
                <div class="form-group row text-center">
                    <label for="total_price" class="col-md-4 col-form-label font-weight-bold text-uppercase">Tổng tiền:</label>
                    <div class="col-md-4">
                        <input type="text" name="total_price" id="total_price" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Đặt phòng</button>
            </div>
        </form>   
        </div>
    </div>

   <!-- JavaScript -->
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   <script>
    var filterRoomsUrl = '{{ route("filter-rooms") }}';
</script>
<script>

    var hotelId = {{ $hotel->id }};
    $(document).ready(function() {
        $('#check_in, #check_out').on('change', function() {
            var checkInDate = $('#check_in').val();
            var checkOutDate = $('#check_out').val();

            // Send an Ajax request to the server to get the filtered room list
            $.ajax({
    url: '{{ route("filter-rooms") }}',
    method: 'POST',
    data: {
        check_in: checkInDate,
        check_out: checkOutDate,
        rm_hotel_id: hotelId
    },
    success: function(response) {
        var roomList = response.rooms;
        var selectRoom = $('#bh_room_id');
        selectRoom.empty();

        selectRoom.append($('<option>').val('').text('Chọn phòng'));
            for (var i = 0; i < roomList.length; i++) {
            var room = roomList[i];
            var optionText = room.rm_name + ' (' + room.rm_code + ') - Lầu ' + room.rm_floor + ' - ' + room.rm_price + ' VNĐ';
            selectRoom.append($('<option>').val(room.id).text(optionText).attr('data-price', room.rm_price));
        }

        calculateTotalPrice(); // Gọi hàm tính toán giá sau khi lọc phòng
    }
});

    });

    $('#bh_room_id').on('change', function() {
        var selectedRoomId = $(this).val(); // Get the selected room ID
        if (selectedRoomId) {
            // Send an AJAX request to save the selected room ID to the database
            $.ajax({
                url: '{{ route("post.book.room", ['id' => $hotel->id]) }}', // Include the hotel_id parameter
                method: 'POST',
                data: {
                    selectedRoomId: selectedRoomId
                },
                success: function(response) {
                    console.log("Room ID has been saved: " + selectedRoomId);
                }
            });
        }
        calculateTotalPrice(); // Call the function to calculate the total price after selecting a room
    });
});

function calculateTotalPrice() {
    var checkInDate = new Date(document.getElementById('check_in').value);
    var checkOutDate = new Date(document.getElementById('check_out').value);
    var selectedRoom = document.getElementById('bh_room_id');
    var roomPrice = selectedRoom.options[selectedRoom.selectedIndex].getAttribute('data-price');
    var totalPriceField = document.getElementById('total_price');

    if (checkOutDate <= checkInDate) {
        alert("Ngày trả phòng phải lớn hơn ngày nhận phòng.");
        document.getElementById('check_out').value = '';
        totalPriceField.value = '';
    } else {
        var timeDiff = checkOutDate.getTime() - checkInDate.getTime();
        var days = Math.ceil(timeDiff / (1000 * 3600 * 24));
        var totalPrice = days * roomPrice;
        totalPriceField.value = totalPrice;
    }
}
</script>
</section>

@stop
@section('script')
@stop
