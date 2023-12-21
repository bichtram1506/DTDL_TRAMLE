@if($tour->t_status == 1 )
<div class="{{ !isset($itemTour) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemTour) ? $itemTour : '' }}">
    <div class="project-wrap">
        <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" class="img" style="background-image: url({{ $tour->t_image ? asset(pare_url_file($tour->t_image)) : asset('admin/dist/img/no-image.png') }});">
            @php
            $eventdate = $tour->eventdate()->where('td_status', 1)->first();
        @endphp
        
            @if ($tour)
                @if ($tour->t_sale > 0)
                    <span class="price">Sale {{ $tour->t_sale }}%</span>
    
                @endif
            @endif
        
            <h6 class="ten_tour">{{ the_excerpt($tour->t_title, 100) }}</h6>
        </a>
        
      <div class="text p-4">   
       
           
            <span class="days">{{ $tour->t_schedule }}  </span>
            @if($tour->commentCount() > 0)
            @php
                $totalRating = 0;
                $commentCount = 0;
            @endphp
  
            @foreach($tour->comments as $comment )
            @if ($comment->cm_status == 1 || $comment->cm_status == 2)
                @if ($comment->cm_rating !== null)
                    <?php
                        $totalRating += $comment->cm_rating;
                        $commentCount++;
                    ?>
                @endif
            @endif
        @endforeach

        @if ($commentCount > 0)
            <?php $avgRating = round($totalRating / $commentCount, 1); ?>
        @else
            <?php $avgRating = 0; ?>
        @endif
          
            
            <div class="d-inline-block " style="margin-bottom: -12px; margin-top: -55px;">
          @if ($avgRating !== null && $avgRating > 0 )  <p class="mb-0">
            
            <p class="mb-0" style="font-size: 24px;"> 
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avgRating)
                        <i class="fas fa-star text-warning" style="font-size: 24px;"></i> {{-- Use solid star icons --}}
                        @else
                            @if($i - $avgRating <= 0.5)
                            <i class="far fa-star text-muted" style="font-size: 24px;"></i> {{-- Use regular (empty) star icons --}}
                            @else
                            <i class="far fa-star text-muted" style="font-size: 24px;"></i> {{-- Use regular (empty) star icons --}}
                            @endif
                        @endif
                    @endfor
                    
                    @php
                    $descriptions = [
                        "Tệ", 
                        "Chưa tốt",
                        "Bình thường",
                        "Tốt",
                        "Xuất sắc"
                    ];
                @endphp
          <span style="font-size: 15px; font-weight: bold; font-family: 'Arial', sans-serif; color: #214c7a;">
           / {{ $descriptions[floor($avgRating) - 1] }}
        </span>
                @endif
                </p>
            </div>
        @else 
        <p style="color: red;">Chưa có đánh giá nào.</p>
        @endif
        
        <div class="tour-view-count">
            <div class="view-count">
                <i class="fas fa-eye"></i>
                <span>{{ $tour->t_views }} lượt xem</span>
            </div>
            <div class="comment-count">
                <a href="#">
                    <i class="fa fa-comment"></i>
                    {{ $tour->commentCount() }} bình luận
                </a>
            </div>
            <div class="favorite-count">
                <i class="fa fa-heart" style="color: red;"></i>
                {{ $tour->favorite_count }}
            </div>
        </div>
        
        <p class="location"><i class="fas fa-map-marker"></i> Từ : {{ isset($tour->t_starting_gate) ? $tour->t_starting_gate : '' }}</p>
        <p class="location"><i class="fas fa-plane"></i> Đến:
            @if(isset($tour->locations) && count($tour->locations) > 0)
                @foreach ($tour->locations as $key => $location)
                    {{ $location->l_name }}
                    @if ($key < count($tour->locations) - 1)
                        - {{-- Thêm dấu phẩy nếu không phải là điểm đến cuối cùng --}}
                    @endif
                @endforeach
            @else
                <span class="unavailable">Không có thông tin địch đến</span>
            @endif
        </p>
        <p class="location"><i class="fas fa-clock"></i> {{ isset($tour->t_day) ? $tour->t_day : '' }} ngày {{ isset($tour->t_night) ? $tour->t_night : '' }} đêm</p>
        @php
        $eventdate = $tour->eventdate()
            ->where('td_status', 1)
            ->where('td_start_date', '>', now()) // Điều kiện td_start_date lớn hơn ngày hiện tại
            ->first();
        @endphp
        <p class="location">
            <i class="far fa-calendar-check"></i> Khởi hành: 
            @if ($eventdate)
                <strong>{{ date('d/m/Y', strtotime($eventdate->td_start_date)) }}</strong>
            @else
                <strong><span class="unavailable">Đang cập nhật...</span></strong>
            @endif
        </p>

    @if ($tour)
    <div style="text-align: right;">
        @if ($tour->t_sale > 0)
            <span style="font-size: 25px; font-weight: bold; color: #FFA500;">{{ number_format($tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100), 0, ',', '.') }} <span style="font-weight: normal;">VND</span></span><br>
            <span style="font-size: 20px; text-decoration: line-through; color: #090101;">{{ number_format($tour->t_price_adults, 0, ',', '.') }} <span style="font-weight: normal;">VND</span></span>
        @else
            <span style="font-size: 25px; font-weight: bold; color: #FFA500;">{{ number_format($tour->t_price_adults, 0, ',', '.') }} <span style="font-weight: normal;">VND</span></span>
        @endif
    </div>
@endif


    
         {{-- <p class="location"><span class="fa fa-calendar-check-o"></span> Khởi hành : {{ $tour->t_start_date  }}</p>
                     
            {{--<p class="location"><span class="fa fa-user"></span> Số chỗ : {{ $tour->t_number_guests  }} - Còn trống: {{  $number  }} </p>
          
          <p class="location"><span class="fa fa-user"></span> Đã xác nhận : {{  $tour->t_number_registered  }}</p>
            @if($tour->t_number_registered<$tour->t_number_guests)
            
            <a class="location"><span class="fa fa-user"></span> Số người đang đăng ký: {{ $tour->t_follow  }} </a>
            @endif
            @if($number-$tour->t_follow<2 && $tour->t_number_registered!=$tour->t_number_guests)
            <a style="color:red"> Sắp hết </a>
            @endif }}
           {{----}}
            {{--<i class="fa fa-user" aria-hidden="true"></i> 2</li>--}}
            {{--<li><i class="fa fa-user" aria-hidden="true"></i> 3--}}
            {{----}}
        </div>
    </div>
</div>
@endif