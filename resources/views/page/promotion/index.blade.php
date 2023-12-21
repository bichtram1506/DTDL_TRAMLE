@extends('page.layouts.page')
@section('title', 'Tours - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url({{ isset($region) ? asset(pare_url_file($region->r_image)) : asset('/page/images/tour_1.jpg') }});">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-12 text-center">
                <div class="home_slide__item">
                    <div class="home_slider__contentht">
                    </div>
                </div>
                <div class="col-md-9 ftco-animate pb-5 text-center">
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Tour <i class="fa fa-chevron-right"></i></span></p>
                </div>
            </div>
        </div>

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
    margin-left:140px;
    transform: translateX(-50%);
    background-color: #fff;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}

</style>
    </section>

    <section class="ftco-section mt-3">
  
  
        <div class="container">
            
      
            <div class="row justify-content-center pb-4">
            </div>  <section class="mt-2 mb-2">
                    <div class="container">
                        <div class="sorting-options">
                            <label class="sorting-label">Sắp xếp theo:</label>
                            <div class="sorting-radio-container">
                                <input type="radio" class="sorting-radio" id="default" name="sorting" value="default" checked>
                                <label for="default">Mặc định</label>
                            </div>
                            <div class="sorting-radio-container">
                                <input type="radio" class="sorting-radio" id="price_asc" name="sorting" value="price_asc">
                                <label for="price_asc">Giá: Tăng dần</label>
                            </div>
                            <div class="sorting-radio-container">
                                <input type="radio" class="sorting-radio" id="price_desc" name="sorting" value="price_desc">
                                <label for="price_desc">Giá: Giảm dần</label>
                            </div>
                            <div class="sorting-radio-container">
                                <input type="radio" class="sorting-radio" id="rating_desc" name="sorting" value="rating_desc">
                                <label for="rating_desc">Đánh giá: Cao đến thấp</label>
                            </div>
                            <div class="sorting-radio-container">
                                <input type="radio" class="sorting-radio" id="rating_asc" name="sorting" value="rating_asc">
                                <label for="rating_asc">Đánh giá: Thấp đến cao</label>
                            </div>
                        </div>
                        <!-- Nội dung khác trong phần section -->
                    </div>
                    </section>
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