@extends('admin.layouts.main')
@section('title', '')
@section('content')
@include('admin.common.header')
    <section class="content-header">
        <?php

use App\Models\QuoteHistory;
?>
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('book.tour.index') }}">Đặt tour</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                       </ul>
                   </div>
                 </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <section class="content">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3 class="card-title">Tìm kiếm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-search"></i> Thu gọn
                            </button>
                        </div>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="" class="row">
                            <div class="col-sm-12 col-md-3">
                                <label>Tên khách hàng</label>
                                <div class="form-group">
                                    <input type="text" name="user_name" class="form-control" placeholder="Tên">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Mã Đơn</label>
                                    <input type="number" name="b_id" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label for="b_status">Trạng thái</label>
                                    <select class="form-control" id="b_status" name="b_status">
                                        <option value="">Tất cả</option>
                                        @foreach($status as $value => $label)
                                            <option value="{{ $value }}" class="{{ $status[$value] }}" @if($value == $request->b_status) selected @endif>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="t_code">Mã Tour:</label>
                                <input type="text" name="t_code" id="t_code" value="{{ request('t_code') }}" class="form-control" placeholder="Nhập Mã Tour">
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <label>Ngày khởi hành</label>
                                    <input type="date" name="td_start_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
        
        </section>
            <div class="row">
                <div class="col-12">
      
                    <div class="card">
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th>ID Đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Ngày đặt</th>  
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th>Thanh toán</th>
                                    <th class="text-center">Tình trạng</th>
                                    @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                    <th class=" text-center">Hành động</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @if (!$bookTours->isEmpty())
                                    @php $i = $bookTours->firstItem(); @endphp
                                    @foreach($bookTours as $book)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; width: 2%">{{ $i }}</td>
                                            <td class="text-center" style="vertical-align: middle; width: 10%">{{ $book->id }}</td>
                                            <td style="vertical-align: middle; width: 14%" class="title-content">
                                                <p>
                                                    @if ($book->user)
                                                    <div class="user-info">
                                                        <h3>{{ $book->user->name }}</h3>
                                                        <p class="contact-info">SĐT: {{ $book->user->phone }}</p>
                                                        <p class="contact-info">{{ $book->user->email }}</p>
                                                    </div>
                                                @else
                                                    <div class="booking-info">
                                                        <h3>{{ $book->b_name }}</h3>
                                                        <p class="contact-info">SĐT: {{ $book->b_phone }}</p>
                                                        <p class="contact-info">{{ $book->b_email }}</p>
                                                    </div>
                                                @endif
                                                </p>
                                               

                                            </td>
                                            <td class="text-center" style="vertical-align: middle; width: 8%">
                                                {{ \Carbon\Carbon::parse($book->b_book_date)->format('H:i d/m/Y') }}
                                            </td>                                            
                                            
                                           
                                            
                                            <td style="vertical-align: middle; width: 8%" class="title-content">    
                                                <p> {{  $book->b_number_adults + $book->b_number_children + $book->b_number_child6 +$book->b_number_child2 }}</p>
                                            </td>   
                                            <td style="vertical-align: middle; width: 10%" class="title-content">   
                                                <p>{{ $book->b_total_price > 0 ? number_format($book->b_total_price, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}</p>

                                                
                                           </td>
                                           <td style="vertical-align: middle; width: 10%" class="title-content">   
                                            <p>
                                                @if ($book->b_payment_method === 'VNPay')
                                                Thanh toán bằng VNPAY
                                            @elseif ($book->b_payment_method === 'cash')
                                                Tiền mặt
                                            @elseif ($book->b_payment_method === 'bankTransfer')
                                                Chuyển khoản ngân hàng
                                            @else
                                                {{ $book->b_payment_method }}
                                            @endif
                                            </p>
                                        </td>
                                        
                                             
                                            <td style="vertical-align: middle; width: 11%">
                                                @if ($book->eventdate->tour && $book->eventdate->tour->t_type == 1 )
                                                @php

                                        $latestQuote = QuoteHistory::where('tour_id', $book->eventdate->tour->id)->orderBy('id', 'desc')->first();
                                        $status_admin = $latestQuote ? $latestQuote->status_admin : null;
                                                @endphp
                                             @if ($latestQuote)
                                             @php
                                             $statusText = "";
                                             switch ($latestQuote->status) {
                                                 case 0:
                                                     $statusText = "Chưa duyệt";
                                                     break;
                                                 case 1:
                                                     $statusText = "Duyệt";
                                                     break;
                                                 case 2:
                                                     $statusText = "Từ chối";
                                                     break;
                                             }
                                             @endphp
                                         
                                             <a class="btn btn-sm" style="background-color: #28a745; color: #fff;">({{ $statusText }})</a><br>
                                         @endif 
                                              @if ($status_admin === 0)
                                              <a class="btn btn-sm" style="background-color: #28a745; color: #fff;">Chưa báo giá</a>
                                          @elseif($status_admin === 1)
                                              <a class="btn btn-sm" style="background-color: #28a745; color: #fff;">Đã báo giá</a>
                                          @endif
                                            
                                            @endif
                                            
                                            
                                                <button type="button" class="btn btn-block {{ $classStatus[$book->b_status] }} btn-xs">{{ $status[$book->b_status] }}</button>
                                            </td>
                                            @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai']))
                                            <td style="vertical-align: middle; width: 15%">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu action-transaction" role="menu">
                                                        <li><a href="{{ route('book.tour.delete', $book->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                        @foreach($status as $key => $item)
                                                        <li class="update_book_tour" url='{{ route('book.tour.update.status', ['status' => $key, 'id' => $book->id]) }}'>
                                                            <a>
                                                                @if ($key == 1) <!-- Ví dụ: Trạng thái 1 -->
                                                                    <i class="fas fa-check-circle"></i> {{ $item }}
                                                                @elseif ($key == 2) <!-- Ví dụ: Trạng thái 2 -->
                                                                    <i class="fas fa-clock"></i> {{ $item }}
                                                                @elseif ($key == 3) <!-- Ví dụ: Trạng thái 3 -->
                                                                    <i class="fas fa-money-bill"></i> {{ $item }}
                                                                @elseif ($key == 4) <!-- Trạng thái 4 - Đã kết thúc -->
                                                                <i class="fas fa-check"></i> {{ $item }}
                                                               @elseif ($key == 5) <!-- Trạng thái 5 - Đã hủy -->
                                                                <i class="fas fa-times"></i> {{ $item }}
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    
                                                    </ul>
                                                    <button type="button" class="btn btn-primary btn-view-detail" data-book-tour-id="{{ $book->id }}">
                                                       <i class="fa fa-eye"></i> Xem chi tiết
                                                    </button>
                                             
                                            
                                                </div>          
                                                @if($book->b_status >= 2)
                                                
                                                <a href="{{ route('book.tour.update', $book->id) }}" class="btn btn-primary btn-sm"
                                                    style="text-decoration: none; padding: 5px 10px; border-radius: 5px; background-color: #007bff; color: #fff; transition: background-color 0.2s;">
                                                     <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                                 </a>
                                                 @if($book->b_status == 3)
                                                 <a  href="{{ route('download_invoice', ['bookId' => $book->id]) }}"class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i class="fas fa-file-pdf"></i> IN ĐƠN</a>
                                                 @endif
                                                @endif
                                                {{--<a class="btn btn-info btn-sm" target="_blank" href="" title="Thông tin đơn hàng">--}}
                                                    {{----}}
                                                {{--</a>--}}
                                            </td>
                                            @endif
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
                            @if($bookTours->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $bookTours->appends($query = '')->links() }}
                                </div>
                            @endif
                        </div>
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@stop
