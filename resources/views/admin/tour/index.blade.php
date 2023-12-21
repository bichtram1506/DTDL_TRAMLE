@extends('admin.layouts.main')
@section('title', '')
@section('content')
@include('admin.common.header')
<?php

use App\Models\QuoteHistory;
?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tour.index') }}">Tour</a></li>
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
                <h3 class="card-title" style="font-family: 'Arial', sans-serif; font-weight: bold; color: #007bff; text-align: center;">Tìm kiếm</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-search"></i> Thu gọn
                            </button>
                        </div>
                    </div>
            
                    <div class="card-body">
                        <form action="" class="row">
                            <div class="col-sm-12 col-md-3">
                                <label style="font-weight: bold;">Tên Tour</label>
                                <div class="form-group">
                                    <input type="text" name="t_title" class="form-control" placeholder="Tên tour" style="font-family: 'Arial', sans-serif;">
                                </div>
                            </div>
                       
                            <div class="col-sm-12 col-md-3">
                                <label style="font-weight: bold;">Loại Tour</label>
                                <div class="form-group">
                                    <select name="tt_name" class="form-control" style="font-family: 'Arial', sans-serif;">
                                        <option value="">Chọn loại tour</option>
                                        @foreach ($tourType as $tour)
                                            <option value="{{ $tour->tt_name }}">{{ $tour->tt_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label style="font-weight: bold;">Mã tour</label>
                                <div class="form-group">
                                    <input type="text" name="t_code" class="form-control" placeholder="Mã tour" style="font-family: 'Arial', sans-serif;">
                                </div>
                            </div>
    
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success" style="font-family: 'Arial', sans-serif; font-weight: bold;"><i class="fas fa-search"></i> Tìm kiếm</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <a href="{{ route('tour.create') }}"><button type="button" class="btn btn-block btn-info"> <i class="fas fa-pencil-alt"></i> Tạo mới</button></a>
                                </div>
                               
                            </div>
                            <a href="{{ route('tour.index') }}" class="btn btn-outline-primary{{ request()->routeIs('tour.index') ? ' active' : '' }}">Tất cả tour</a>
                            <a href="{{ route('tour.index0') }}" class="btn btn-outline-primary{{ request()->routeIs('tour.index0') ? ' active' : '' }}">Tour ghép khách lẻ</a>
                            <a href="{{ route('tour.index1') }}" class="btn btn-outline-primary{{ request()->routeIs('tour.index1') ? ' active' : '' }}">Tour theo yêu cầu</a>
                        </div>
              
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                           
                       
                            <table class="table table-hover text-nowrap table-bordered">
                                 <thead class="thead-dark">
                                    <tr>
                                        <th width="4%" class="text-center gray-header">STT</th>
                                       <th class="gray-header">Hình ảnh</th> 
                                       <th class="gray-header">Tour</th>
                                        <th class="gray-header">Lich trình / Giá</th>
                                      {{--  <th class="gray-header">Khách sạn</th> --}}
                                        <th class="gray-header">Thông tin / Địa điểm</th>
                                        <th class="text-center gray-header">Trạng thái</th>
                                        <th class="text-center gray-header">Hành động</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @if (!$tours->isEmpty())
                                        @php $i = $tours->firstItem(); @endphp
                                        @foreach($tours as $tour)
                                            <tr>
                                                <td class=" text-center" style="vertical-align: middle;">{{ $i }}</td>
                                             <td style="vertical-align: middle; width:20%;">
                                                    @if(isset($tour) && !empty($tour->t_image))
                                                        <img src="{{ asset(pare_url_file($tour->t_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                                    @else
                                                        <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                                    @endif
                                                </td>      
                                                <td style="vertical-align: middle; width: 50%" class="title-content">
                                                 
                                                    <p><b>Mã tour:</b><a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_code)]) }}">{{ $tour->t_code }}</a></p>
                                                    <p><b>Tên tour:</b>{{ $tour->t_title }}</p>
                                                    <p><b>Loại tour:</b> {{ isset($tour->tourtype) ? $tour->tourtype->tt_name : '' }}</p>

                                                </td>
                                                <td style="vertical-align: middle; width: 25%" class="title-content">
                                              
                                                    <p><b>Lịch trình :</b> {{ $tour->t_day }} ngày {{ $tour->t_night }} đêm</p>
                                                     @if($tour->t_number_guests !== null)
                                                       <p> <b>Số người :</b> {{ $tour->t_number_guests }} </p>
                                                        @endif
                                                   
                                                    <p><b>Số người tối thiểu :</b> {{ $tour->t_min_participants }}</p>
                                                    @if (!empty($tour))
                                                    @php
                                                        $price = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
                                                    @endphp
                                                    <b>Giá từ: </b>
                                                    @if($price > 0)
                                                        <span>{{ number_format($price, 0, ',', '.') }} </span>🔥VND
                                                    @else
                                                        <span style="font-style: italic; color: red;">Đang cập nhật</span>
                                                    @endif
                                                @endif
                                                
                                                </td>
                                              {{-- <td style="vertical-align: middle;">
                                                    <!-- Danh sách khách sạn -->
                                                    @foreach ($tour->hotels as $hotel)
                                                        <p>{{ $hotel->h_name }}</p>
                                                    @endforeach
                                                </td> --}} 
                                                
                                                <td style="vertical-align: middle; width: 7%">
                                                   
                                                    <p><b>Phương tiện:</b>
                                                        @if ($tour->vehicle_ids)
                                                            @foreach (json_decode($tour->vehicle_ids) as $vehicleId)
                                                                @php
                                                                $vehicle = \App\Models\Vehicle::find($vehicleId);
                                                                @endphp
                                                               @if ($vehicle)
                                                               {{ $vehicle->v_name }}
                                                           @endif
                                                            @endforeach
                                                        @endif
                                                        </p>
                                                        
                                                    <p><b>Điểm xuất phát :</b> {{ $tour->t_starting_gate }}</p>
                                                    <p><b>Điểm đến :</b>  <!-- Danh sách khách sạn -->
                                                        @foreach ($tour->locations as $key => $location)
                                                        <span>{{ $location->l_name }}</span>
                                                        @if ($key < count($tour->locations) - 1)
                                                            <span>, </span>
                                                        @endif
                                                    @endforeach
                                                    
                                                </td>
                                                <td class="text-center" style="vertical-align: middle;">
                                                    @if ($tour->t_type == 1)
                                                    <p style="color: red;">Tour theo yêu cầu</span> <br><span style="color: green;">{{ $status[$tour->t_status] }}
                                                </p> @endif
                                                    @if ($tour->t_type == 1)
                                                    
                                                        @foreach ($tour->eventdate as $eventdate)
    
                                                                <ul>
                                                                    @foreach ($eventdate->bookTour as $bookTour)
                                                                        <li>
                                                                            @if ($bookTour->b_status == 5)
                                                                                <span style="color: red;">Hủy đơn</span>
                                                                            @elseif ($bookTour->b_status == 4)
                                                                                <span style="color: orange;">Đã hoàn thành</span>
                                                                            @elseif ($bookTour->b_status == 3)
                                                                                <span style="color: green;">Đã thanh toán</span>
                                                                            @elseif ($bookTour->b_status == 2)
                                                                                <span style="color: blue;">Đã xác nhận</span>
                                                                            @else
                                                                                <span style="color: gray;">Chưa xác định</span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endforeach
                                                    @else
                                                        {{ $status[$tour->t_status] }}
                                                    @endif

                                                </td>
                                                
                                                

                                                <td class="text-center" style="vertical-align: middle;">
                                                 @if ($tour && $tour->t_type == 1 )
                                                    @php

                                            $latestQuote = QuoteHistory::where('tour_id', $tour->id)->orderBy('id', 'desc')->first();
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
                                                
                                                
                                                
                                                
                                                     <!-- Hành động -->
                                                     
                                                    <!-- <a class="btn btn-success btn-sm" href="#">
                                                        <i class="fas fa-eye"></i>
                                                    </a> -->
                                                                                                      
                                                    <a class="btn btn-primary btn-sm" href="{{ route('tour.update', $tour->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('tour.delete', $tour->id) }}">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if($tours->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $tours->appends($query = '')->links() }}
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
