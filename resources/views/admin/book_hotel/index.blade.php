@extends('admin.layouts.main')
@section('title', '')
@section('content')
@include('admin.common.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('book.hotel.index') }}">Đặt khách sạn</a></li>
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
                                    <button type="submit" class="btn btn-success"><i class="fas fa-search"></i> Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
        
        </section>
            <div class="row">
                <div class="col-12">
                    <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    <div class="card">
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th>ID Đơn hàng</th>
                                    <th>Khách hàng</th>
                                    <th>Thông tin</th>  
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
                                @if (!$bookHotels->isEmpty())
                                    @php $i = $bookHotels->firstItem(); @endphp
                                    @foreach($bookHotels as $book)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; width: 2%">{{ $i }}</td>
                                            <td class="text-center" style="vertical-align: middle; width: 10%">{{ $book->id }}</td>
                                            <td style="vertical-align: middle; width: 14%" class="title-content">
                                                <p>
                                                    @if ($book->user)
                                                        {{ $book->user->name }}
                                                        <p >SĐT: {{ $book->user->phone }}</p>
                                                    @else
                                                        {{ $book->b_name }}
                                                    @endif
                                                </p>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle; width: 19%">
                                                <p>Khách sạn: {{ $book->room->hotel->h_name }}</p>
                                                <p>Phòng: {{ $book->room->rm_name }}</p>
                                                <p>Số phòng: {{ $book->room->rm_code }}</p>
                                                <p>Tầng: {{ $book->room->rm_floor }}</p>
                                                <p>Số ngày thuê: {{ \Carbon\Carbon::parse($book->check_in)->diffInDays(\Carbon\Carbon::parse($book->check_out)) }}</p>
                                                <p>Số khách: {{ $book->num_guest }}</p>
                                                <p>Tổng giá tiền: {{ $book->total_price }}</p>
                                                <p>Thời gian check-in: {{ \Carbon\Carbon::parse($book->check_in)->format('H:i d/m/Y') }}</p>
                                                <p>Thời gian check-out: {{ \Carbon\Carbon::parse($book->check_out)->format('H:i d/m/Y') }}</p>
                                            </td>
                                           
                                            
                                            <td style="vertical-align: middle; width: 8%" class="title-content">    
                                                <p> {{ 	$book->num_guest }}</p>
                                            </td>   
                                            <td style="vertical-align: middle; width: 10%" class="title-content">   
                                                <p> {{ number_format($book->total_price, 0,',','.') }} vnd</p>
                                                
                                           </td>
                                           <td style="vertical-align: middle; width: 10%" class="title-content">   
                                            <p>
                                                @if ($book->bh_payment_method === 'direct_payment')
                                                    Thanh toán bằng chuyển khoản
                                                @elseif ($book->bh_payment_method === 'vnpay')
                                                    Tiền mặt
                                                @else
                                                    {{ $book->b_payment_method }}
                                                @endif
                                            </p>
                                        </td>
                                        
                                             
                                            <td style="vertical-align: middle; width: 11%">
                                                <button type="button" class="btn btn-block {{ $classStatus[$book->status] }} btn-xs">{{ $status[$book->status] }}</button>
                                            </td>
                                            @if(Auth::user()->can(['full-quyen-quan-ly', 'xoa-va-cap-nhat-trang-thai-book-hotel']))
                                            <td style="vertical-align: middle; width: 15%">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu action-transaction" role="menu">
                                                        <li><a href="{{ route('book.hotel.delete', $book->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                        @foreach($status as $key => $item)
                                                        <li class="update_book_tour" url='{{ route('book.hotel.update.status', ['status' => $key, 'id' => $book->id]) }}'>
                                                            <a>
                                                                @if ($key == 1) <!-- Ví dụ: Trạng thái 1 -->
                                                                    <i class="fas fa-check-circle"></i> {{ $item }}
                                                                @elseif ($key == 2) <!-- Ví dụ: Trạng thái 2 -->
                                                                    <i class="fas fa-clock"></i> {{ $item }}
                                                                @elseif ($key == 3) <!-- Ví dụ: Trạng thái 3 -->
                                                                    <i class="fas fa-money-bill"></i> {{ $item }}
                                                               @elseif ($key == 5) <!-- Trạng thái 5 - Đã hủy -->
                                                                <i class="fas fa-times"></i> {{ $item }}
                                                                @endif
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                    
                                                    </ul>
                                                  
                                                    <a href="{{ route('book.hotel.update', $book->id) }}" class="btn btn-primary btn-sm"
                                                        style="text-decoration: none; padding: 5px 10px; border-radius: 5px; background-color: #007bff; color: #fff; transition: background-color 0.2s;">
                                                         <i class="fas fa-pencil-alt"></i> Chỉnh sửa
                                                     </a>
                                                     
                                                </div>
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
                          
                            @if($bookHotels->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $bookTours->appends($query = '')->links() }}
                                </div>
                            @endif
                        </div>
              
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@stop
