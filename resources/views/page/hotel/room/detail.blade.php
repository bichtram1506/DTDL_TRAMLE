@extends('page.layouts.page')
@section('title', $room->rm_name)
@section('style')
@stop
@section('seo')
@stop
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('/page/images/hotel1.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Khách sạn <i class="fa fa-chevron-right"></i></span></p>
                    <h1 class="mb-0 bread">Phòng</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ftco-animate mt-md-5 fadeInUp ftco-animated">
                    <h2 class="mb-3">{{ $room->rm_name }}</h2>
                </div>
                <div class="col-lg-8 ftco-animate fadeInUp ftco-animated">
                    <div style="text-align: center;">
                        <img src="{{ $room->image ? asset(pare_url_file($room->image)) : asset('admin/dist/img/no-image.png') }}" alt="{{ $room->rm_name }}" class="img-fluid" style="width: 100%">
                    </div>
                    <h2 class="mb-3 mt-5">#2. Mô tả</h2>
                    <div style="font-size: 16px;">
                        {!! $room->rm_description !!}
                    </div>
                    <h2 class="mb-3 mt-5">#3. Thông tin phòng</h2>
                    <ul style="list-style-type: none; padding: 0;">
                        <li><b>Loại phòng:</b> 
                            @if($room->rm_type == 1)
                                Phòng đơn
                            @elseif($room->rm_type == 2)
                                Phòng đôi
                            @elseif($room->rm_type == 3)
                                Phòng gia đình
                            @elseif($room->rm_type == 4)
                                Phòng hướng biển
                            @elseif($room->rm_type == 5)
                                Phòng hạng sang
                            @else
                                Không xác định
                            @endif
                        </li>
                        <li><strong>Giá:</strong> {{ number_format($room->rm_price, 0, ',', '.') }} VNĐ</li>
                        <li><strong>Tầng:</strong> {{ $room->rm_floor }}</li>
                        <li><strong>Mã phòng:</strong> {{ $room->rm_code }}</li>
                    </ul>
                </div>
                <div class="col-lg-4 sidebar ">
                    <div class="register-tour">
                        <p class="price-tour">Giá <span>{{ number_format($room->rm_price, 0, ',', '.') }}</span> VNĐ</p>
                        <a href="{{ route('book.room', ['id' => $room->hotel->id, 'slug' => safeTitle($room->hotel->h_name)]) }}" class="btn btn-primary px-4 mr-3">
                            <i class="fas fa-shopping-cart mr-2"></i> Đặt ngay
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop
@section('script')
@stop