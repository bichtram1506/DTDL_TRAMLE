<div class="modal-body">
    <table class="table">
        
        @foreach ($bookTours as $booktour)
            <table class="table">
               
                <tbody>
              
                    <tr>
                        <td colspan="2">
                            @if ($bookTours->count() > 0)
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Mã Đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Tổng tiền</th>
                                            <th>Vé</th>
                                            <th>Hành động</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                   
                                            <tr>
                                                
                                                <td>
                                             <span>Mã Đơn: {{ $booktour->id }}</span>
                                                    
                                                </td><td>{{ $booktour->b_name }} <br>
                                                    {{ $booktour->b_email }} </td>
                                                <td> {{ $booktour->b_total_price }}</td>
                                                <td>  {{ $booktour->b_total_ticket }}</td>
                                                <td><button type="button" class="btn btn-primary btn-view-detail" data-book-tour-id="{{ $booktour->id }}">
                                                    <i class="fa fa-eye"></i> Xem chi tiết
                                                </button><br>
                                                <a href="{{ route('book.tour.update', $booktour->id) }}" class="btn btn-primary btn-sm"
                                                    style="text-decoration: none; padding: 5px 10px; border-radius: 5px; background-color: #007bff; color: #fff; transition: background-color 0.2s;">
                                                     <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                                 </a> </td>
                                                 <td style="vertical-align: middle; width: 11%">
                                                    <button type="button" class="btn btn-block {{ $classStatusbook[$booktour->b_status] }} btn-xs">{{ $statusbook[$booktour->b_status] }}</button>
                                                </td>
                                               
                                                <!-- Điều này là ví dụ, bạn có thể hiển thị các trường khác tùy thuộc vào cơ sở dữ liệu của bạn -->
                                            </tr>
                                       
                                    </tbody>
                                </table>
                            @else
                                <p>No booking data available</p>
                            @endif
                        </td>
                    </tr>
                </tbody>
                
            </table>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn đặt tour</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="modalContent"> <!-- Đặt ID mới cho phần content -->
                            <!-- Nội dung modal sẽ được điền thông qua JavaScript -->
                        </div>
                        <div class="modal-footer bg-light"> <!-- Thêm lớp bg-light để đổi màu nền -->
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        </div>
                        
                    </div>
                </div>
            </div>
            @if (!$loop->last)
                <!-- Đường kẻ ngang hoặc phần tử ghi chú giữa mỗi người dùng -->
                <hr>
            @endif
        @endforeach
    <table class="table">
    @foreach ($users as $user)
        <table class="table">
            <thead>
                <tr>
                    <th>Họ Tên</th>
                    <th>Tổng tiền</th>
                    <th>Tổng Vé</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->bookTours->sum('b_total_price') }}</td>
                    <td>{{ $user->bookTours->sum('b_total_ticket') }}</td>
                </tr>
                <tr>
                    <td colspan="2">
                        @if ($user->bookTours->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã Đơn</th>
                                        <th>Tổng tiền</th>
                                        <th>Vé</th>
                                        <th>Hành động</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->bookTours as $bookTour)
                                        <tr>
                                            <td>
                                                <span>Mã Đơn: {{ $bookTour->id }}</span>
                                                
                                            </td>
                                            <td>
                                                @if ($bookTour->b_total_price == 0)
                                                    Đang cập nhật
                                                @else
                                                    {{ $bookTour->b_total_price }}
                                                @endif
                                            </td>
                                            <td>  {{ $bookTour->b_total_ticket }}</td>
                                            <td><button type="button" class="btn btn-primary btn-view-detail" data-book-tour-id="{{ $bookTour->id }}">
                                                <i class="fa fa-eye"></i> Xem chi tiết
                                            </button><br>
                                            <a href="{{ route('book.tour.update', $bookTour->id) }}" class="btn btn-primary btn-sm"
                                                style="text-decoration: none; padding: 5px 10px; border-radius: 5px; background-color: #007bff; color: #fff; transition: background-color 0.2s;">
                                                 <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                             </a> </td>
                                             <td style="vertical-align: middle; width: 11%">
                                                <button type="button" class="btn btn-block {{ $classStatusbook[$bookTour->b_status] }} btn-xs">{{ $statusbook[$bookTour->b_status] }}</button>
                                                
                                            </td>
                                            
                                           
                                            <!-- Điều này là ví dụ, bạn có thể hiển thị các trường khác tùy thuộc vào cơ sở dữ liệu của bạn -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>No booking data available</p>
                        @endif
                    </td>
                </tr>
            </tbody>
            
        </table>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Chi tiết đơn đặt tour</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modalContent"> <!-- Đặt ID mới cho phần content -->
                        <!-- Nội dung modal sẽ được điền thông qua JavaScript -->
                    </div>
                    <div class="modal-footer bg-light"> <!-- Thêm lớp bg-light để đổi màu nền -->
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    </div>
                    
                </div>
            </div>
        </div>
        @if (!$loop->last)
            <!-- Đường kẻ ngang hoặc phần tử ghi chú giữa mỗi người dùng -->
            <hr>
        @endif
    @endforeach
    <script>
        $('.btn-view-detail').click(function() {
            var bookTourId = $(this).data('book-tour-id');
            // Lấy thông tin chi tiết đơn đặt tour từ server và điền vào modal
            $.ajax({
                url: '{{ route('book.tour.detail', '') }}/' + bookTourId,
                method: 'GET',
                success: function(response) {
                    $('#modalContent').html(response); // Điền thông tin vào phần body của modal
                    $('#exampleModal').modal('show'); // Hiển thị modal
                },
                error: function(error) {
                    console.error(error);
                }
            });
        });
        </script>
</div>
