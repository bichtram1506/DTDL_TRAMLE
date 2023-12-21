@extends('page.layouts.page')
@section('title', 'Liên hệ')
@section('style')
@stop
@section('seo')
@stop
@section('content')
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ asset('/page/images/contact.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center" >
                <div class="home_slide__item">
                    <div class="home_slider__contentht">
                        <div class="home_slider_content_inner animated bounceInDown">
                            <h1>Liên Hệ</h1>
                        </div>
                    </div>
                </div>
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Liên Hệ <i class="fa fa-chevron-right"></i></span></p>
            </div>
         </div>
    </div>
    </section>
    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row d-flex contact-info">
    <div class="col-md-6 d-flex">
        <div class="align-self-stretch box p-4 text-center">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-fw fa-credit-card"></span>
            </div>
            <h3 class="mb-2">Thanh toán trực tiếp</h3>
            <p>Vui lòng đến cửa hàng của chúng tôi để thanh toán trực tiếp:</p>
            <p>CÔNG TY CỔ PHẦN DU LỊCH VIETOURIST
                Địa chỉ: 154 Lý Chính Thắng, Phường 7, Quận 3, TP. HCM
                Điện thoại: 08. 62 61 63 65
                Hotline: 089 990 9145</p>
        </div>
    </div>
    
    <div class="col-md-6 d-flex">
        <div class="align-self-stretch box p-4 text-center">
            <div class="icon d-flex align-items-center justify-content-center">
                <span class="fa fa-fw fa-university"></span>
            </div>
            <h3 class="mb-2">Chuyển khoản ngân hàng</h3>
            <p>Vui lòng sử dụng thông tin tài khoản dưới đây để chuyển khoản:</p>
            <p>VIETOURIST HOLDINGS JOINT STOCK CO.</p>
            <p>Chi nhánh: Chi nhánh XYZ</p>
            <p>Số tài khoản: 1601100633008</p>
            <p>Chủ tài khoản: Lê Thi Bích Trâm</p>
            <p>Nội dung chuyển khoản: [Mã đơn hàng, Tên khách hàng]</p>
        </div>
    </div>
</div>
</div>

<section class="contact-section">
    <div class="container">
        <div class="row contact-info">
            <div class="col-md-3">
                <div class="box text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fas fa-map-marker-alt"></span>
                    </div>
                    <h3 class="mb-2">Địa chỉ</h3>
                    <p>Quận Ninh Kiều, TPHCM</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fas fa-phone"></span>
                    </div>
                    <h3 class="mb-2">Số điện thoại liên hệ</h3>
                    <p><a href="tel://0336095722">0336095722</a></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fas fa-envelope"></span>
                    </div>
                    <h3 class="mb-2">Địa chỉ email</h3>
                    <p><a href="mailto:info@yoursite.com">admin@gmail.com</a></p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box text-center">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fas fa-globe"></span>
                    </div>
                    <h3 class="mb-2">Website</h3>
                    <p><a href="#">Your Website</a></p>
                </div>
            </div>
        </div>
    </div>
</section>


    <section class="ftco-section contact-section ftco-no-pt">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-12 order-md-last d-flex">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d251546.40281337738!2d105.52165895338082!3d9.899556725484251!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x31a08830e83dcfbf%3A0xd7d72c317e7a5333!2zRHUgTOG7i2NoIFZpZXRzdW50b3VyaXN0LCDEkC4gTmd1eeG7hW4gVsSDbiBMaW5oLCBIxrBuZyBM4bujaSwgTmluaCBLaeG7gXUsIEPhuqduIFRoxqEsIFZp4buHdCBOYW0!3m2!1d10.0204534!2d105.7663025!5e0!3m2!1svi!2s!4v1679293783978!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
    <section class="ftco-intro ftco-section ftco-no-pt">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img" style="background-image: url({{ asset('page/images/bg_2.jpg') }});">
                        <div class="overlay"></div>
                        <h2>Chào mừng bạn đến với VietScapeJourneys</h2>
                        <p>Chúng tôi sẽ đem đến trãi nghiệm các tour du lịch tốt nhất dành cho bạn</p>
                        <p class="mb-0"><a href="https://www.facebook.com/tram.oppa/" class="btn btn-primary px-4 py-3">Liên hệ qua Messager của chúng tôi</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop
