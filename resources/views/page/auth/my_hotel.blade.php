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
                <div class="col-lg-12 ftco-animate sidebar-box ftco-animate fadeInUp ftco-animated">
                    <h3 class="mb-0 bread text-center ">LỊCH SỬ ĐẶT PHÒNG</h3>
                    <table class="table table-hover table-bordered my-tour">
                        <thead class="thead-dark">
                            <tr>
                                <th>ID</th>
                                <th>Ngày nhận</th>
                                <th>Ngày trả</th>
                                <th>Khách sạn</th>
                                <th>Thông tin phòng</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d/m/Y') }}</td>
                                    <td>{{ $booking->room->hotel->h_name }}</td>
                                    <td>
                                        Mã phòng: {{ $booking->room->rm_code }}<br> 
                                        {{ $booking->room->rm_name }}<br>
                                        Lầu: {{ $booking->room->rm_floor }}<br>
                                    </td>
                                    <td>{{ $booking->total_price }}</td>
                                    <td style="vertical-align: middle; width: 17%">
                                        @if($booking->status != 1)
                                            <button type="button" class="btn btn-block {{ $classStatus[$booking->status] }} btn-sm btn-status-order">{{ $status[$booking->status] }}</button>
                                        @endif
                                        @if($booking->status == 1)
                                            <a class="btn btn-block btn-danger btn-sm btn-cancel-order" href="{{ route('post.cancel.order.hotel', ['status' => 5, 'id' => $booking->id]) }}">Hủy</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  </div>  </div>      
            
            </section>
        @stop
        @section('script')
        @stop