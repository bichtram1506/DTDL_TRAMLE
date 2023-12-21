@extends('page.layouts.page')
@section('title', 'Thông tin tài khoản - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-12 ftco-animate ">
                    <?php

                    use App\Models\QuoteHistory;
                    ?>
                    <form class="form-inline" method="get" action="{{ route('my.tour') }}">
                        <div class="form-group mb-2">
                            <label for="order-id" class="sr-only">Tìm mã đơn:</label>
                            <input type="text" class="form-control" id="order-id" name="id" placeholder="Tìm mã đơn">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">Tìm</button>
                        <ul class="nav nav-pills status-bar">
                            <li class="nav-item">
                                <a class="nav-link active" href="{{ route('my.tour') }}" data-status="">
                                    <i class="fas fa-list"></i>
                                    <span>Tất Cả</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my.tour', ['status' => '1']) }}" data-status="1">
                                    <i class="far fa-clock"></i>
                                    <span>Chưa xác nhận</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my.tour', ['status' => '2']) }}" data-status="2">
                                    <i class="fas fa-check"></i>
                                    <span>Đã xác nhận</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my.tour', ['status' => '3']) }}" data-status="3">
                                    <i class="far fa-credit-card"></i>
                                    <span>Đã Thanh Toán</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my.tour', ['status' => '4']) }}" data-status="4">
                                    <i class="fas fa-check-square"></i>
                                    <span>Đã Kết thúc</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('my.tour', ['status' => '5']) }}" data-status="5">
                                    <i class="fas fa-times-circle"></i>
                                    <span>Đã Hủy</span>
                                </a>
                            </li>
                        </ul>
                    </form>
                    
                   <script>            
                // Lắng nghe sự kiện click trên các liên kết trong thanh ngang
                    var navLinks = document.querySelectorAll('.nav-link');
                    navLinks.forEach(function(link) {
                    link.addEventListener('click', function(event) {
                        event.preventDefault();
                        var status = this.getAttribute('data-status');
                        // Lưu giá trị trạng thái đã chọn vào local storage
                        localStorage.setItem('selectedStatus', status);
                        // Đánh dấu liên kết được chọn
                        markSelectedLink(this);
                        // Thực hiện các thay đổi cần thiết dựa trên giá trị trạng thái đã chọn
                        handleStatusChange(status);
                    });
                    });

                    // Kiểm tra và đánh dấu liên kết đã chọn khi tải lại trang
                    var selectedStatus = localStorage.getItem('selectedStatus');
                    if (selectedStatus) {
                    var selectedLink = document.querySelector('.nav-link[data-status="' + selectedStatus + '"]');
                    if (selectedLink) {
                        markSelectedLink(selectedLink);
                    }
                    }

                    // Đánh dấu liên kết được chọn
                    function markSelectedLink(selectedLink) {
                    // Xóa lớp active trên tất cả các liên kết
                    navLinks.forEach(function(link) {
                        link.classList.remove('active');
                    });
                    // Thêm lớp active vào liên kết được chọn
                    selectedLink.classList.add('active');
                    }

                    // Xử lý thay đổi trạng thái
                    function handleStatusChange(status) {
                    // Kiểm tra nếu status là rỗng (liên kết "Tất Cả" được bấm)
                    if (status === '') {
                        // Xóa lưu trữ trong local storage
                        localStorage.removeItem('selectedStatus');
                        // Đánh dấu liên kết "Tất Cả" là được chọn
                        markSelectedLink(document.querySelector('.nav-link[data-status=""]'));
                        // Thay đổi URL trang để hiển thị tất cả
                        var url = "{{ route('my.tour') }}";
                        window.location.href = url;
                        return;
                    }
                    // Thực hiện các thay đổi cần thiết dựa trên giá trị trạng thái đã chọn
                    // Ví dụ: chuyển hướng trang với giá trị trạng thái mới
                    var url = "{{ route('my.tour') }}?status=" + status;
                    window.location.href = url;
                    }

                    // Kiểm tra trạng thái ban đầu để hiển thị tất cả
                    var selectedStatus = localStorage.getItem('selectedStatus');
                    if (!selectedStatus) {
                    // Nếu không có trạng thái đã chọn trong local storage, đánh dấu liên kết "Tất Cả" là được chọn
                    markSelectedLink(document.querySelector('.nav-link[data-status=""]'));
                    }
                     </script>
                    <table class="table table-hover table-bordered my-tour">
                        <thead class="thead-dark">
                            <tr>
                                <th style="vertical-align: middle; width: 3%">STT</th>
                                <th style="vertical-align: middle; width: 20%">Tên tour</th>
                                <th style="vertical-align: middle;">Thông tin</th>
                                <th style="vertical-align: middle;" class=" text-center">Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$bookTours->isEmpty())
                            @php $i = $bookTours->firstItem(); @endphp
                            @foreach($bookTours as $tour)
                                <tr>
                                    <td style="vertical-align: middle; width: 3%">{{ $i }}</td>
                                    <td style="vertical-align: middle; width: 50%">
                                        <p><b>Điểm đón : </b> {{ $tour->b_address }}</p>
                                
                                   <p><b>Tour : </b><a href="{{ route('tour.detail', ['id' => $tour->eventdate->tour->id, 'slug' => safeTitle( $tour->eventdate->tour->t_title)]) }}">{{  $tour->eventdate->tour->t_title }}</a></p>
                                        
                                    @if ($tour->eventdate->tour->t_type == 1)
                                    <span style="color: red;">Tour theo yêu cầu</span> <br><span style="color: green;"></span>
                                   @endif
                            
                                   
                                    </td>
                                    <td style="vertical-align: middle; width: 30%">
                                        <p><b>Mã booking: </b>{{ $tour->id }}</p>
                                        <p><b>Ngày đi: </b>{{ $tour->eventdate->td_start_date }}</p>
                                        
                                        <p><b>Tổng tiền: </b>
                                            @if ($tour->eventdate->tour->t_type == 1 && $tour->b_total_price == 0)
                                            <span class="badge badge-success">Đang cập nhật</span>
                                            @else
                                                {{ number_format($tour->b_total_price, 0, ',', '.') }} vnd
                                            @endif
                                        </p>
                                        
                                        <p><b>Số lượng vé: </b>{{ $tour->b_number_adults + $tour->b_number_children + $tour->b_number_child6 + $tour->b_number_child2 }}</p>
                                        <p><b>Ghi chú: </b>{{ $tour->b_note }}</p>
                                    </td>
                                    <td style="vertical-align: middle; width: 14%">
                            @if($tour->eventdate->tour->t_type==1 )
                            
                                   @php
                                   $quoteStatus = QuoteHistory::where('tour_id', $tour->eventdate->tour->id)->where('status', 1)->first();
                                   $rejectedStatus = QuoteHistory::where('tour_id', $tour->eventdate->tour->id)->where('status', 2)->first();
                                   $latestUpdate = $tour->eventdate->tour->updated_at;
                                   $formattedUpdate = $latestUpdate->format('H:i:s, d/m/Y');
                               @endphp
                                Trạng thái báo giá:
                                @if ($quoteStatus)
                                    <a class="btn btn-sm" style="background-color: #5a37e5; color: #fff;">Đã Duyệt</a>
                                    <span class="badge badge-info">Cập nhật gần đây: {{ $formattedUpdate }}</span>
                                @elseif ($rejectedStatus)
                                    <a class="btn btn-sm" style="background-color: #FF0000; color: #fff;">Từ chối</a>
                                    <span class="badge badge-info">Cập nhật gần đây: {{ $formattedUpdate }}</span>
                                @else
                                    <a class="btn btn-sm" style="background-color: #ccc; color: #000;">Chưa có</a>
                                @endif
                          
                                @if (($tour->b_status ==1 && $tour->b_status != 5 &&  $tour->eventdate->tour->quoteHistory()->latest()->first()?->status !== 1 )) 
                                @if (!$tour->eventdate->tour->quoteHistory()->latest()->exists() || ($tour->eventdate->tour->quoteHistory()->latest()->first()->status > 0 && $tour->eventdate->tour->quoteHistory()->latest()->first()->status_admin > 0))
                                <a id="btn-request-quote" href="{{ route('quote.request', ['tourId' => $tour->eventdate->tour->id]) }}" class="btn btn-primary"><i class="fa fa-comment"></i> Yêu cầu báo giá</a>
                            @else
                                <a id="btn-request-quote" href="#" class="btn btn-primary"><i class="fa fa-check"></i> Đã gửi yêu cầu</a>
                            @endif
                            @endif   
                    
                    
                     
                   
                            @if ($tour->eventdate->tour->quoteHistory()->latest()->first() && $tour->eventdate->tour->quoteHistory()->latest()->first()->status == 0 && $tour->eventdate->tour->quoteHistory()->latest()->first()->status_admin == 1)
                                       @foreach ($tour->eventdate->tour->quoteHistory_user as $quote)
                                   
                                       <form method="POST" action="{{ route('quote.processAction', ['id' => $quote->id]) }}">
                                           @csrf
                                           <input type="radio" name="action" value="approve" id="approve{{ $quote->id }}">
                                           <label for="approve{{ $quote->id }}">Duyệt</label>
                                   
                                           <input type="radio" name="action" value="reject" id="reject{{ $quote->id }}">
                                           <label for="reject{{ $quote->id }}">Từ chối</label>
                                   
                                           <div id="reason-input{{ $quote->id }}" style="display: none;">
                                               <input type="text" name="reason" placeholder="Lý do từ chối">
                                           </div>
                                   
                                           <button type="submit">Cập nhật</button>
                                       </form>
                                       
                                     
                                       <script>
                                           const approveInput{{ $quote->id }} = document.getElementById(`approve{{ $quote->id }}`);
                                           const rejectInput{{ $quote->id }} = document.getElementById(`reject{{ $quote->id }}`);
                                           const reasonInput{{ $quote->id }} = document.getElementById(`reason-input{{ $quote->id }}`);
                                   
                                           // Xác minh trạng thái mặc định
                                           if (rejectInput{{ $quote->id }}.checked) {
                                               reasonInput{{ $quote->id }}.style.display = 'block';
                                           }
                                   
                                           approveInput{{ $quote->id }}.addEventListener('change', function() {
                                               reasonInput{{ $quote->id }}.style.display = 'none';
                                           });
                                   
                                           rejectInput{{ $quote->id }}.addEventListener('change', function() {
                                               reasonInput{{ $quote->id }}.style.display = 'block';
                                           });
                                       </script>
                                       @endforeach
                                      
                                  
                                @endif   @endif
                                   <!-- Các trường dữ liệu khác của đơn hàng -->
                                   @if ($tour->b_status ==2  && $tour->b_payment_method == "VNPay")
                                   <form action="{{ route('process_payment') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booktourId" value="{{ $tour->id }}">
                                    <input type="hidden" name="b_total_price" value="{{ $tour->b_total_price }}">
                                    <!-- Các trường dữ liệu khác của đơn hàng -->
                                    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Tiếp tục thanh toán</button>
                                </form>
                                @endif
                                @if ($tour->b_status == 2    && ($tour->b_payment_method == 'MOMO'))
                                <form action="{{ route('process_payment_momo') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="booktourId" value="{{ $tour->id }}">
                                    <input type="hidden" name="b_total_price" value="{{ $tour->b_total_price }}">
                                    <!-- Các trường dữ liệu khác của đơn hàng -->
                                    <button type="submit" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Tiếp tục thanh toán</button>
                                </form>
                            @endif
                                        @if($tour->b_status != 1)
                                            <button type="button" class="btn btn-block {{ $classStatus[$tour->b_status] }} btn-sm btn-status-order">{{ $status[$tour->b_status]  }}</button>
                                        @endif
                                        @if($tour->b_status == 1)
                                            <a class="btn btn-block btn-danger btn-sm btn-cancel-order" href="{{ route('post.cancel.order.tour', ['status' => 5, 'id' => $tour->id]) }}" >Hủy</a>
                                        @endif
                                        <button type="button" class="btn btn-primary btn-view-detail" data-book-tour-id="{{ $tour->id }}">
                                            <i class="fa fa-eye"></i> Xem chi tiết
                                         </button>
                                        
                                    @if ($tour->b_status == 4) {{-- Chỉ hiển thị nút đánh giá khi đơn đã thanh toán --}}
                                            @php
                                                $commentExists = \App\Models\Comment::where('cm_booktour_id', $tour->id)->exists();
                                            @endphp

                                            <div class="text-center">
                                                @if ($commentExists)
                                                    <button class="btn btn-success" disabled><i class="fas fa-star"></i> Đã Đánh giá</button>
                                                @else
                                                    <a href="{{ route('danh.gia.don', ['id' => $tour->id]) }}" class="btn btn-primary"><i class="fas fa-star"></i> Đánh giá</a>
                                                @endif
                                            </div>
                                        @endif

                                    
                                    </td>
                                </tr>
                                @php $i++ @endphp
                            @endforeach
                            
                        @endif
                        
                        </tbody>
          
                    </table>
                                         <!-- Modal -->
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
                           
                    <div class="row mt-5">
                        <div class="col text-center">
                            <div class="block-27">
                                {{ $bookTours->links('page.pagination.default') }}
                            </div>
                        </div>
                        
                    </div>
                  
                </div>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                $('.btn-view-detail').click(function() {
                    var bookTourId = $(this).data('book-tour-id');
                    // Lấy thông tin chi tiết đơn đặt tour từ server và điền vào modal
                    $.ajax({
                        url: '{{ route('book1.tour.detail', '') }}/' + bookTourId,
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
                <!-- .col-md-8 -->
            </div>

        </div>
        
    </section>
    
@stop

@section('script')
@stop