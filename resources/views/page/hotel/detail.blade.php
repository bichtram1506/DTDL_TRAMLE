@extends('page.layouts.page')
@section('title', $hotel->h_name)
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
                    <h1 class="mb-0 bread">Khách Sạn</h1>
                </div>
            </div>
        </div>
    </section>
  <section class="ftco-section">
    <div class="container">
        <h2 class="">{{ $hotel->h_name }}</h2>
        <p>
            <img src="{{ $hotel->h_image ? asset(pare_url_file($hotel->h_image)) : asset('admin/dist/img/no-image.png') }}" alt="{{ $hotel->h_name }}" class="img-fluid" style="width: 100%">
        </p>
        <h2 class="text-center" style="color: blue; font-size: 24px; margin-top: 20px;">Danh sách Phòng</h2>
        @if ($rooms->count())
        <div id="tourCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <?php $itemRoom = 'item-related-tour' ?>
               @foreach($rooms->chunk(3) as $index => $chunk)
                  <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                     <div class="row">
                        @foreach($chunk as $room)
                           <div class="col-md-4 ftco-animate fadeInUp ftco-animated">
                              @include('page.common.itemRoom', compact('room', 'hotel','itemRoom'))
                           </div>
                        @endforeach
                     </div>
                  </div>
               @endforeach
            </div>
            <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev" style=" margin-right: 10px;">
                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: yellow;margin-right : 140px;"></span>
                <span class="sr-only">Previous</span>
             </a>
             <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next" style=" margin-left: 10px;">
                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: green; margin-left : 140px;"></span>
                <span class="sr-only">Next</span>
             </a>
         </div>
        
        <script>
            $(document).ready(function() {
                $('#tourCarousel').carousel();
            });
        </script>
        @endif
    </div>
</section>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-top: -180px;">
                <div class="col-lg-8 ftco-animate fadeInUp ftco-animated">
                    <h2 class="">#1. Thông tin liên hệ</h2>
                    <table class="table table-bordered">
                        <tr>
                            <td width="30%">Địa điểm</td>
                            <td>{{ isset($hotel->location) ? $hotel->location->l_name : '' }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Địa chỉ</td>
                            <td>{{ $hotel->h_address }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Điện thoại</td>
                            <td>{{ $hotel->h_phone }}</td>
                        </tr>
                        <tr>
                            <td width="30%">Giá từ</td>
                            <td>{{ number_format($hotel->h_price,0,',','.') }} vnđ</td>
                        </tr>
                    </table>
                    <h2 class="mb-3 mt-5">#2. Mô tả</h2>
                    {!! $hotel->h_description  !!}
                    <h2 class="mb-3 mt-5">#3. Nội dung</h2>
                    {!! $hotel->h_content  !!}

                    <div class="pt-5 mt-5 py-5" style="border-top: 1px solid #ccc;">
                        @if($hotel->commentCount() > 0)
                        @php
                            $totalRating = 0;
                            $commentCount = 0;
                    foreach($hotel->comments as $comment) {
                      if($comment->cm_status == 1 || $comment->cm_status == 2){
                          $totalRating += $comment->cm_rating;
                          $commentCount++;
                           }
                         }
                      if($commentCount > 0){
                          $avgRating = round($totalRating / $commentCount, 1);
                        } else {
                          $avgRating = 0;
                            }
                         @endphp
                        <span class="font-weight-bold">Điểm đánh giá:</span>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $avgRating)
                                <span class="fa fa-star checked" style="color: gold;"></span>
                            @else
                                @if($i - $avgRating <= 0.5)
                                    <span class="fa fa-star-half-o checked" style="color: gold; font-family: 'FontAwesome';"></span>
                                @else
                              
                                    <span class="fa fa-star unchecked" style="color: gray;"></span>
                                @endif
                            @endif
                        @endfor
                        <span class="starability-text">{{ $avgRating }} sao</span>
                    @endif
                        <h3 class="mb-5" style="font-size: 20px; font-weight: bold;">Danh sách bình luận</h3>
                        <ul class="comment-list">
                            @if ($hotel->comments->count() > 0)
                                @foreach($hotel->comments as $key => $comment)
                                    @include('page.common.itemComment', compact('comment'))
                                @endforeach
                            @endif
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5">
                            <h3 class="mb-5" style="font-size: 20px; font-weight: bold;">{{ Auth::guard('users')->check() ? 'Để lại bình luận của bạn' : 'Bạn cần đăng nhập để bình luận' }}</h3>
                            @if (Auth::guard('users')->check())
                                <form action="#" class="p-5 bg-light">
                                    <input type="hidden" name="cm_rating" id="rating-input" value="">
                                    <div class="form-group">
                                        <label for="stars">Đánh giá:</label>
                                        <div class="stars" data-rating="0">
                                            <span class="star" data-value="1"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="2"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="3"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="4"><i class="fa fa-star"></i></span>
                                            <span class="star" data-value="5"><i class="fa fa-star"></i></span>
                                        </div>
                                        <span id="rating-text"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="message">Nội dung</label>
                                        <textarea name="" id="message" cols="30" rows="5" class="form-control"></textarea>
                                        <span class="text-errors-comment" style="display: none;">Vui lòng nhập nội dung bình luận !!!</span>
                                    </div>
                                    <div class="form-group">
                                        <input type="" value="Gửi bình luận" class="btn py-3 px-4 btn-primary btn-comment" hotel_id="{{ $hotel->id }}">
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                    <script>
                        const stars = document.querySelectorAll('.star');
                        const ratingInput = document.querySelector('#rating-input');
                        const ratingText = document.querySelector('#rating-text');
                        let ratingValue = 0;
                    
                        stars.forEach((star, index) => {
                            star.addEventListener('click', () => {
                                ratingValue = star.dataset.value;
                                ratingInput.value = ratingValue;
                                ratingText.textContent = `Đánh giá ${ratingValue} sao`;
                                // Thêm class 'selected' cho các sao được chọn
                                stars.forEach((s, i) => {
                                    if (i <= index) {
                                        s.classList.add('selected');
                                    } else {
                                        s.classList.remove('selected');
                                    }
                                });
                            });
                        });
                    </script>
                </div> <!-- .col-md-8 -->
                <div class="col-lg-4 sidebar ">
                    <div class="register-tour">
                        <p class="price-tour">Giá từ : <span>{{ number_format($hotel->h_price, 0, ',', '.') }}</span> vnd</p>
                        <a href="{{ route('book.room', ['id' => $hotel->id, 'slug' => safeTitle($hotel->h_name)]) }}" class="btn btn-primary px-4 mr-3">
                            <i class="fas fa-shopping-cart mr-2"></i> Đặt Khách Sạn
                        </a>
                    </div>

                    @if ($hotels->count() > 0)
                    <div class="bg-light sidebar-box ftco-animate fadeInUp ftco-animated related-tour">
                        <h3>Danh Sách Khách Sạn Liên Quan</h3>
                        <?php $itemHotel = 'item-related-tour' ?>
                        @foreach($hotels as $hotel)
                            @include('page.common.itemHotel', compact('hotel', 'itemHotel'))
                        @endforeach
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </section>
@stop
@section('script')
@stop