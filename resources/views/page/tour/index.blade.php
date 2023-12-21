@extends('page.layouts.page')
@section('title', 'Tours - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ isset($region) ? asset(pare_url_file($region->r_image)) : asset('/page/images/tour_1.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <style>
           
            /* Định dạng kiểu chữ cho tiêu đề h3 */
            h3 {
                font-size: 24px;
                font-weight: bold;
                text-align: center;
                color: #333; /* Màu chữ */
            }
        
        
        
            /* Định dạng kiểu chữ cho tiêu đề h4 */
            h4 {
                font-size: 20px;
                font-weight: bold;
                text-align: center;
                color: #333; /* Màu chữ */
            }
        
                     .sorting-options {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 0;
                border-bottom: 1px solid #a71b1b;
            }
        
            .sorting-label {
                font-size: 18px;
                font-weight: bold;
                margin-right: 10px;
            }
        
            .sorting-radio-container {
                display: flex;
                align-items: center;
            }
        
            .sorting-radio {
                margin-right: 5px;
            }
        
            /* Đặt màu sắc cho radio button và label khi được chọn */
            .sorting-radio:checked + label {
                color: #007bff;
                font-weight: bold;
            }
            .scrollable-list {
            max-height: 300px; /* Điều chỉnh độ cao tùy ý */
            overflow-y: scroll;
            /* Định dạng cho phần danh sách loại tour */
            }
        .tour-type-list {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .tour-type-list .section-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        
        .tour-type-items {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .tour-type-item {
            font-size: 18px;
            color: #555;
            margin-bottom: 10px;
            transition: color 0.3s ease-in-out;
        }
        
        .tour-type-item:hover {
            color: #3498db; /* Thay đổi màu khi hover */
        }
        
        /* Định dạng cho phần bài đăng gần đây */
        .tour-type-section {
            margin-bottom: 50px;
        }
        
        .tour-type-section .heading-section h2 {
            font-size: 36px;
            color: #333;
            letter-spacing: 1px;
            font-weight: 400;
            margin-bottom: 20px;
        }
            .search-wrap-1 {
            position: absolute;
            bottom: -100px; /* Điều chỉnh khoảng cách từ bottom theo ý muốn */
            margin-left:200px;
            transform: translateX(-50%);
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease-in-out;
        }
        
        </style>
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-12 text-center">
                <div class="home_slide__item">
                    <div class="home_slider__contentht">
                        <div class="home_slider_content_inner animated bounceInDown">
                                        <h1>
                                            @if(isset($region))
                                            Du lịch {{ $region->r_name }}
                                        @elseif(isset($location))
                                        
                                            Du lịch {{ $location->l_name }}
                                        @else
                                            Tour
                                        @endif
                                        
                                       </h1>

                        </div>
                    </div>
                </div>
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Tour <i class="fa fa-chevron-right"></i></span></p>
                </div>
            </div>
        </div>

       
    </section>
    <section class="ftco-section  justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap-1 ftco-animate fadeInUp ftco-animated">
                        @include('page.common.searchTour')
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-section mt-3">
  
  
        <div class="container">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 ">
                        @if(isset($selectedTourType))
                        <div class="text-center">
                            <h3>{{ $selectedTourType->tt_name }}</h3>
                            <p>{!! $selectedTourType->tt_description !!}</p>
                        </div>
                        @endif
            
                        @if(isset($region))
                        <div class="region-info text-center"> <!-- Đặt chiều dài ngang mong muốn và căn giữa nội dung -->
                            <h4 class="mb-3">Du lịch {{ $region->r_name }}</h4>
                            <p>{{ $region->r_content }}</p>
                        </div>
                        @endif
            
                        @if(isset($location))
                        <div class="region-info text-center"> <!-- Đặt chiều dài ngang mong muốn và căn giữa nội dung -->
                            <h4 class="mb-3">Du lịch {{ $location->l_name }}</h4>
                            <p>{!! $location->l_description !!}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="row ">
                @if($tours->count() > 0)
                
                    @foreach($tours as $tour)
                        @include('page.common.itemTour', compact('tour'))
                    @endforeach
                    @else
                    <!-- Hiển thị hình ảnh và lời nhắn khi không có tour -->
                    <div class="text-center">
                        <img src="https://www.matbao.net/Content/images/LandingPageFreeVN/Gan_luoi.svg" alt="Hình ảnh mặc định">
                        <p>Xin lỗi, không có tour nào cho điều kiện đã chọn.</p>
                    </div>
            
                @endif
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        {{ $tours->links('page.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop