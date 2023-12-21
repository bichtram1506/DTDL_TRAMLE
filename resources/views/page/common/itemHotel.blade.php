<div class="{{ !isset($itemHotel) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemHotel) ? $itemHotel : '' }}">
    <div class="project-wrap hotel">
        <a href="{{ route('hotel.detail', ['id' => $hotel->id, 'slug' => safeTitle($hotel->h_name)]) }}"
           class="img" style="background-image: url({{ $hotel->h_image ? asset(pare_url_file($hotel->h_image)) : asset('admin/dist/img/no-image.png') }});">
     
        </a>
        <div class="text p-4">
            <h3>
                <a href="{{ route('hotel.detail', ['id' => $hotel->id, 'slug' => safeTitle($hotel->h_name)]) }}" title="{{ $hotel->h_name }}">
                    {{ the_excerpt($hotel->h_name, 100) }}
                </a>
            </h3>
            @if ($hotel->commentCount() > 0)
                @php
                    $totalRating = 0;
                    $commentCount = 0;
                    foreach ($hotel->comments as $comment) {
                        if ($comment->cm_status == 1 || $comment->cm_status == 2) {
                            $totalRating += $comment->cm_rating;
                            $commentCount++;
                        }
                    }
                    if ($commentCount > 0) {
                        $avgRating = round($totalRating / $commentCount, 1);
                    } else {
                        $avgRating = 0;
                    }
                @endphp
                <div class="d-inline-block" style="margin-bottom: -12px;">
                    <p class="mb-0">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $avgRating)
                                <span class="fa fa-star text-warning"></span>
                            @else
                                @if ($i - $avgRating <= 0.5)
                                <span class="fa fa-star-half-o text-warning" style="font-family: 'FontAwesome';"></span>
                                @else
                                    <span class="fa fa-star text-muted"></span>
                                @endif
                            @endif
                        @endfor
                        <span class="starability-text" style="color: orange">{{ $avgRating }} sao</span>
                    </p>
                    <p class="mt-1"><a href="#"><span class="fa fa-comment"></span> {{ $hotel->commentCount() }} bình luận</a></p>
                </div>
            @endif
            <p class="location"><span class="fa fa-map-marker" style="margin-right: 10px"></span>{{ isset($hotel->location) ? $hotel->location->l_name : '' }}</p>
            <p>{!! the_excerpt($hotel->h_description, 200) !!}<a href="{{ route('hotel.detail', ['id' => $hotel->id, 'slug' => safeTitle($hotel->h_name)]) }}" title="{{ $hotel->h_name }}" class="btn btn-primary">Xem thêm</a></p>
            @php
            $remainingRooms = $hotel->rooms->count(); // Đếm số lượng phòng còn lại của khách sạn
        @endphp
    
        <!-- Hiển thị thông tin khách sạn -->
        <h2>{{ $hotel->name }}</h2>
        <!-- Các chi tiết khác về khách sạn -->
    
        @if ($isSearching)
            @if ($remainingRooms > 0)
                <p style="font-weight: bold; color: red;">
                    Chỉ còn {{ $remainingRooms }} phòng với giá này trên trang của chúng tôi
                </p>
            @else
                <p style="font-weight: bold; color: red;">
                    Hiện không còn phòng trống với giá này
                </p>
            @endif
        @endif
    

            @if ($hotel)
            <div style="text-align: right;">
               
                    <span style="font-size: 25px; font-weight: bold; color: #FFA500;">{{ number_format($hotel->h_price, 0, ',', '.') }} <span style="font-weight: normal;">VND</span></span>
              
            </div>
        @endif
        </div>
    </div>
</div>
