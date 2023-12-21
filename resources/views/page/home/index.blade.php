@extends('page.layouts.page')
@section('title', 'Cuộc đời là những chuyến du lịch | VietScape Journeys')
@section('style')
@stop
@section('content')

<style>
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
    }
    /* Định dạng cho phần danh sách loại tour */
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
.tourtype-image img {
    max-width: 100%;
    height: auto;
}
/* Định dạng cho phần chúng tôi là công ty du lịch */
.ftco-intro .img {
    position: relative;
    background-size: cover;
    background-position: center center;
    height: 400px;
}

.ftco-intro .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
}

.ftco-intro h2 {
    color: #fff;
    font-size: 32px;
    margin-top: 150px;
}

.ftco-intro p {
    color: #fff;
    margin-top: 10px;
}

.ftco-intro .btn-primary {
    margin-top: 20px;
}

/* Định dạng chung */
.row.justify-content-center {
    margin-bottom: 30px;
}



</style>
<div class="hero-wrap js-fullheight">
    <div class="background-video">
        <video autoplay loop muted playsinline>
            <source src="{{ asset('page/images/COMBO-DU-LICH-TIET-KIEM-1700-×-750-px-1650-×-700-px-4.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
          {{--  @foreach($tour_promotions as $key => $tour_promotions)
                <div class="home_slide__item @if($key === 0) active @endif">
                    <div class="home_slider__content">
                        <div class="home_slider_content_inner animated bounceInDown">
                            <h1>{{ $tour_promotions->t_name }}</h1>
                            <p>Start Date: {{ $couponcode->cc_start_date }}</p>
                            <p>Expiry Date: {{ $couponcode->cc_expiry_date }}</p>
                        
                        </div>
                    </div>
                </div>
            @endforeach  
            <div class="main_slide__nav nav__prev"><i onclick="plusSlides(-1)" class="fas fa-chevron-circle-left"></i></div>
            <div class="main_slide__nav nav__next"><i onclick="plusSlides(1)" class="fas fa-chevron-circle-right"></i></div>--}}
        </div>
    </div>
</div>



  
    <section class="ftco-section ftco-no-pb ftco-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="ftco-search d-flex justify-content-center">
                        <div class="row">
                            {{--
                            <div class="col-md-12 nav-link-wrap">
                                <div class="nav nav-pills text-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                       <ul class="search_tabs__list">
                                        <li class="search_tabs__item"><a href="#tabs-1"><i
                                                class="fas fa-hotel"></i><span>Khách sạn</span></a>
                                        </li>
                                      
                                        <li class="search_tabs__item"><a href="#tabs-4"><i
                                                class="fas fa-umbrella-beach"></i><span>Trips</span></a>
                                        </li>
                                        <li class="search_tabs__item"><a href="#tabs-5"><i
                                                class="fas fa-ship"></i><span>Du thuyền</span></a>
                                        </li>
                                        <li class="search_tabs__item"><a href="#tabs-6"><i class="fas fa-hiking"></i><span>Hoạt động</span></a>
                                        </li>
                                    </ul>

                                </div>
                            </div>--}}
                            <div class="col-md-12 tab-wrap ">
                                <div class="tab-content " id="v-pills-tabContent">
                                    <div class="tab-pane2 fade show active" id="v-pills-1" role="tabpanel" aria-labelledby="v-pills-nextgen-tab">
                                        @include('page.common.searchTour')
                                    </div>
                                {{--    <div class="tab-pane2 fade" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-performance-tab">
                                        @include('page.common.searchHotel', compact('locations'))
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

   
  {{--  <section class="ftco-section img ftco-select-destination" style="background-image: url({{ asset('page/images/bg_3.jpg') }});">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading">Chọn cuộc phiêu lưu của bạn</span>
                    <h2 class="mb-4">Chúng tôi sẽ lo phần còn lại</h2>
                </div>
            </div>
        </div>
        <div class="container container-2">
            <div class="row">
                <div class="col-md-12">
                    <div class="carousel-destination owl-carousel ftco-animate">
                        @if ($locations->count() > 0)
                            @foreach($locations as $location)
                                <div class="item">
                                    <div class="project-destination">
                                        <a href="{{ route('tours.by_location', ['t_location_id' => $location->id]) }}" class="img"   style="background-image: url({{ $location->l_image ? asset(pare_url_file($location->l_image)) : asset('page/images/place-1.jpg') }});">

                                            <div class="text">
                                                <h3>{{ $location->l_name }}</h3>
                                                <span>{{ $location->tours ? $location->tours->count() : 0 }} Tours</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="">
        <div class="container d-flex align-items-center">
            <img loading="lazy" width="56" height="60" src="https://www.bestprice.vn/assets/img/core-value/13-nam.png" alt="13 năm chặng đường">
            <div class="accomplishment-content" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456745" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456748" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <p class="title"><strong>13</strong> năm chặng đường</p>
                <span class="description">CHINH PHỤC MỘT NIỀM TIN</span>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 why-us" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                <div class="row" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                    <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-1" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456746" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                        <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/luon-co-gia-tot-2.png" alt="Luôn có giá tốt">
                        <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452079" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463837" data-gtm-vis-recent-on-screen-6393024_357="4463839" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Luôn có giá tốt</div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-2" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                        <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/dam-bao-chat-luong-2.png" alt="Đảm bảo chất lượng">
                        <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Đảm bảo chất lượng</div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-3" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463878" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                        <img height="42" width="42" loading="lazy" src="https://www.bestprice.vn/assets/img/core-value/am-hieu-tuyen-diem-2.png" alt="Am hiểu tuyến điểm, tận tình chu đáo">
                        <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452079" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Am hiểu tuyến điểm, tận tình chu đáo</div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 text-center why-us-item why-us-item-4" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-first-on-screen-6393024_357="4456747" data-gtm-vis-total-visible-time-6393024_357="15700" data-gtm-vis-first-on-screen-6393024_356="4456749" data-gtm-vis-total-visible-time-6393024_356="5600" data-gtm-vis-recent-on-screen-6393024_357="4463876" data-gtm-vis-recent-on-screen-6393024_356="4463877" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">
                        <img height="42" width="42" loading="lazy" src="https://vegayacht.vn/wp-content/uploads/2020/02/icon-staff.png" alt="Nhân viên tận tâm">
                        <div class="title" data-gtm-vis-first-on-screen-6393024_358="4452077" data-gtm-vis-total-visible-time-6393024_358="3000" data-gtm-vis-first-on-screen-6393024_356="4452078" data-gtm-vis-total-visible-time-6393024_356="8800" data-gtm-vis-first-on-screen-6393024_357="4452080" data-gtm-vis-total-visible-time-6393024_357="18900" data-gtm-vis-has-fired-6393024_358="1" data-gtm-vis-recent-on-screen-6393024_356="4463838" data-gtm-vis-recent-on-screen-6393024_357="4463840" data-gtm-vis-has-fired-6393024_356="1" data-gtm-vis-has-fired-6393024_357="1">Hướng dẫn viên tận tâm</div>
                    </div>
                </div>
            </div>
        </div>
        
        </section>
        <section class="ftco-section ">
            <div class="container">
                <div class="row justify-content-center pb-4">
                    <div class="col-md-12 heading-section text-center ftco-animate">
                        <span class="subheading" style="font-family: 'Roboto Slab', serif; font-size: 18px; color: #9932CC;">DANH SÁCH</span>
                        <h2 class="mb-4 " style="font-family: 'Roboto Slab', serif; font-size: 36px; color: #333333; letter-spacing: 1px; font-weight: 400;">LOẠI TOUR</h2>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="row" id="tourtype-carousel">
                            @foreach($tourtypes as $tourtype)
                            <div class="col-md-4 home_slide__item">
                                <div class="home_slider__content">
                                    <div class="home_slider_content_inner animated bounceInDown">
                                        <a href="{{ route('showToursByTourType', ['tourtype_id' => $tourtype->id]) }}">
                                            <h1 style="color: black;">{{ $tourtype->tt_name }}</h1>
                                        </a>
                                        <a href="{{ route('showToursByTourType', ['tourtype_id' => $tourtype->id]) }}">
                                            @if(isset($tourtype) && !empty($tourtype->tt_image))
                                            <img src="{{ asset(pare_url_file($tourtype->tt_image)) }}" alt="" class="margin-auto-div img-rounded" id="image_render" style="height: 250px; width:350px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);">
                                            @else
                                            <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded" id="image_render" style="height: 200px; width:100%;">
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="main_slide__nav nav__prev" style="top: 90px;">
                            <i onclick="plusSlides(-1)" class="fas fa-chevron-circle-left"></i>
                        </div>
                        <div class="main_slide__nav nav__next" style="top: 90px;">
                            <i onclick="plusSlides(1)" class="fas fa-chevron-circle-right"></i>
                        </div>
                    </div>
                </div>
                
             </div> 
        </section>

    <section class="ftco-section" style="margin-top: 140px;">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="subheading" style="font-family: 'Roboto Slab', serif; font-size: 18px; color: #9932CC;">DANH SÁCH</span>
                    <h2 class="mb-4 " style="font-family: 'Roboto Slab', serif; font-size: 36px; color: #333333; letter-spacing: 1px; font-weight: 400;">TOUR DU LỊCH MỚI NHẤT</h2>
                </div>
            </div> 
            <div class="row">
              
            @if($tours->count() > 0)
                    {{-- Hiển thị danh sách loại tour --}}
                    {{--   <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                        <div class="scrollable-list">
                            <div class="tour-type-list">
                                <h2 class="section-title">Danh sách loại tour</h2>
                                <ul class="tour-type-items">
                                    @foreach ($tourtypes as $tourtype)
                                        <li class="tour-type-item">
                                            <a href="{{ route('showToursByTourType', ['tourtype_id' => $tourtype->id]) }}">
                                                {{ $tourtype->tt_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div> --}}
                    
                    
                    {{-- Hiển thị danh sách tour du lịch mới nhất --}}
                    @foreach($tours as $tour)
                        <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                            @include('page.common.itemTour', ['tour' => $tour, 'itemTour' => ''])
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container" style="margin-top: -150px;"> <!-- Điều chỉnh khoảng cách lên trên đây -->
            <h2 class="mb-4 text-center" style="font-family: 'Roboto Slab', serif; font-size: 36px; color: #333333; letter-spacing: 1px; font-weight: 400;">Câu hỏi thường gặp</h2>
            @include('page.common.ask')
        </div>
    </section>
    
  {{--   <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                   <span class="subheading">Danh Sách</span>
                    <h2 class="mb-4">Tour ẩm thực Nổi Bật</h2>
                </div>
            </div>
            <div class="row">
                @if($featuredTours->count() > 0)
               
                    @foreach($featuredTours as $tour)
                        @include('page.common.itemTour', compact('tour'))
                    @endforeach
                   
                @endif
            </div>
           
        </div>
    </section> --}}

   
   {{-- @include('page.common.listCommentHot', compact('comments'))--}}

    <section class="ftco-section " style="margin-top: -120px;">
        <div class="container">
            <div class="row justify-content-center pb-4">
                <div class="col-md-12 heading-section text-center ftco-animate">
                    <span class="">DANH SÁCH</span>
                    <h2 class="mb-4">BÀI ĐĂNG MỚI NHẤT</h2>
                </div>
            </div>
            <div class="row d-flex">
                @if ($articles->count() > 0)
                    @foreach($articles as $article)
                        @include('page.common.itemArticle', compact('article'))
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <section class="ftco-intro ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img"  style="background-image: url({{ asset('page/images/bg_2.jpg') }});">
                        <div class="overlay"></div>
                        <h2>Chúng tôi là Công ty Du lịch VietScapeJourneys</h2>
                        <p>Chúng tôi sẽ mang đến cho quý khách những trãi nghiệm tuyệt vời nhất</p>
                        <p class="mb-0"><a href="#" class="btn btn-primary px-4 py-3">Liên hệ qua Messager của chúng tôi</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var slideIndex = 0;
    
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }
    
        function showSlides(n) {
            var slides = document.getElementsByClassName("home_slide__item");
            if (n >= slides.length) {
                slideIndex = 0;
            }
            if (n < 0) {
                slideIndex = slides.length - 3;
            }
            for (var i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (var i = slideIndex; i < slideIndex + 3; i++) {
                if (slides[i]) {
                    slides[i].style.display = "block";
                }
            }
        }
    
        showSlides(slideIndex);
    </script>
    <script>
        let slideIndex = 0;
        showSlide(slideIndex);
    
        function showSlide(n) {
            const slides = document.querySelectorAll(".home_slide__item");
    
            if (n >= slides.length) {
                slideIndex = 0;
            }
            if (n < 0) {
                slideIndex = slides.length - 1;
            }
    
            for (let i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
    
            slides[slideIndex].style.display = "block";
        }
    
        function plusSlides(n) {
            showSlide(slideIndex += n);
        }
    </script>
    <script>
        $(document).ready(function () {
            $("#tour-type-carousel").owlCarousel({
                items: 3, // Số lượng hiển thị trên mỗi trang
                nav: true, // Hiển thị nút "Tới trang trước" và "Tới trang sau"
                loop: true, // Vòng lặp vô hạn
                margin: 10, // Khoảng cách giữa các phần tử
                responsive: {
                    0: {
                        items: 1 // Số lượng hiển thị trên màn hình nhỏ
                    },
                    600: {
                        items: 3 // Số lượng hiển thị trên màn hình lớn hơn
                    }
                }
            });
        });
    </script>
   
@stop
@section('script')
@stop