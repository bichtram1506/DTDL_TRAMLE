@extends('page.layouts.page')
@section('title', 'Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('/page/images/bg_ab.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center" >
                <div class="home_slide__item">
                    <div class="home_slider__contentht">
                        <div class="home_slider_content_inner animated bounceInDown">
                            <h1>Giới Thiệu</h1>
                        </div>
                    </div>
                </div>
           
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Giới Thiệu <i class="fa fa-chevron-right"></i></span></p>
            </div>
         </div>
    </div>
    </section>
    
   <section class="ftco-section services-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about">
                    <div class="box about__box">
                        <div class="about__image"><img src="{{ asset('page/images/intro.png') }}" alt=""></div>
                        <div class="about__content">
                            <div class="about__title">Về chúng tôi</div>
                            <p class="about__text">ViVuViet là trang website bán tour du lịch hàng đầu Việt Nam, với tiêu chí
                                tour không hoàn, không hủy, không thay đổi lịch trình. Gía cả tốt nhất thị trường hơn hết đảm
                                bảo cho du khách có những trải nghiệm thú vị nhất, dịch dụ chuyên nghiệp nhất khi mua tour tại
                                đây. ViVuViet phục vụ du khách đi tham quan du lịch trên cả 5 châu, du lịch ra nước ngoài tại
                                đây rất được khách hàng tin tưởng và đánh giá cao.</p>
                            <div class="button button_about">
                                <div class="button_bcg"></div>
                                <a href="#">Đọc thêm <span></span><span></span><span></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="statistic">
                    <div class="box statistic__box">
                        <h2>Thống kê theo năm</h2>
                        <p class="statistic__text">Thống kê số lượng khách hàng, khách hàng quay lại, các hoạt động và số lượng
                            tour giữa năm 2018 và 2019 của chúng tôi</p>
                        <div class="statistic__content">
                            <div class="statistic__item">
                                <div class="stats">
                                    <div class="stats__icon"><i class="fas fa-user-friends"></i></div>
                                    <div class="stats__content">
                                        <div class="stats__number">13456</div>
                                        <div class="stats__type">Khách hàng</div>
                                    </div>
                                </div>
                                <div class="stats__bar">
                                    <div class="stats__year">2018 <i class="fas fa-level-down-alt"></i></div>
                                    <div class="stats__bar1"></div>
                                    <div class="tooltip bar_1 stats__bar2" title="Tăng 20%"></div>
                                </div>
                            </div>
                            <div class="statistic__item">
                                <div class="stats">
                                    <div class="stats__icon"><i class="fas fa-hiking"></i></div>
                                    <div class="stats__content">
                                        <div class="stats__number">656</div>
                                        <div class="stats__type">Khách hàng </div>
                                    </div>
                                </div>
                                <div class="stats__bar">
                                    <div class="stats__year">2018 <i class="fas fa-level-down-alt"></i></div>
                                    <div class="stats__bar1"></div>
                                    <div class="tooltip bar_2 stats__bar2" title="Giảm 10%"></div>
                                </div>
                            </div>
                            <div class="statistic__item">
                                <div class="stats">
                                    <div class="stats__icon"><i class="fas fa-umbrella-beach"></i></div>
                                    <div class="stats__content">
                                        <div class="stats__number">906</div>
                                        <div class="stats__type">Hoạt động</div>
                                    </div>
                                </div>
                                <div class="stats__bar">
                                    <div class="stats__year">2018 <i class="fas fa-level-down-alt"></i></div>
                                    <div class="stats__bar1"></div>
                                    <div class="tooltip bar_3 stats__bar2" title="Giảm 7%"></div>
                                </div>
                            </div>
                            <div class="statistic__item">
                                <div class="stats">
                                    <div class="stats__icon"><i class="fas fa-globe-asia"></i></div>
                                    <div class="stats__content">
                                        <div class="stats__number">1320</div>
                                        <div class="stats__type">Số lượng tour</div>
                                    </div>
                                </div>
                                <div class="stats__bar">
                                    <div class="stats__year">2018 <i class="fas fa-level-down-alt"></i></div>
                                    <div class="stats__bar1"></div>
                                    <div class="tooltip bar_4 stats__bar2" title="Tăng 15%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

   
   
@stop
@section('script')
@stop