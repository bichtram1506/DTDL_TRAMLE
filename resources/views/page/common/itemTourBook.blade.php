
<div class="{{ !isset($itemTour) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemTour) ? $itemTour : '' }}">
    <div class="project-wrap">
        <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" class="img" style="background-image: url({{ $tour->t_image ? asset(pare_url_file($tour->t_image)) : asset('admin/dist/img/no-image.png') }});">
            @if ($tour)
                @if ($tour->t_sale > 0)
                    <span class="price">Sale {{ $tour->t_sale }}%</span>
                    <span class="price" style="margin-left:100px">
                        {{ number_format($tour->t_price_adults - ($tour->t_price_adults * $eventdate->t_sale / 100), 0, ',', '.') }} vnd/người <br>
                        <span style="text-decoration: line-through;margin-left:35px;color:#ddd">{{ number_format($tour->t_price_adults, 0, ',', '.') }}</span>
                    </span>
                @else
                    <span class="price">{{ number_format($tour->t_price_adults, 0, ',', '.') }} vnd/người</span>
                @endif
            @endif
        </a>
  
      <div class="text p-4">   
          

    
            @if ($eventdate)
            @if ($eventdate->number_registered == $tour->t_number_guests)
            <h5 class="days" style="color:red">Đã hết chỗ</h5>
        @endif
              @endif 
            <span class="days">{{ $tour->t_schedule }}  </span>
            <h3>
                <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}" title="{{ $tour->t_title }}">
                    {{ the_excerpt($tour->t_title, 100) }}
                </a>

            </h3>
            @if($tour->commentCount() > 0)
            @php
               $totalRating = 0;
               $commentCount = 0;
            foreach($tour->comments as $comment) {
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
            <div class="d-inline-block "style="margin-bottom: -12px;">
                <p class="mb-0">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $avgRating)
                            <span class="fa fa-star text-warning"></span>
                        @else
                            @if($i - $avgRating <= 0.5)
                            <span class="fa fa-star-half-o text-warning" style="font-family: 'FontAwesome';"></span>
                            @else
                                <span class="fa fa-star text-muted"></span>
                            @endif
                        @endif
                    @endfor
                    <span class="starability-text"style="color: orange">{{ $avgRating }} sao</span>
                </p>
                <p class="mt-1"><a href="#"><span class="fa fa-comment"></span> {{ $tour->commentCount() }} bình luận</a></p>
            </div>
        @endif
        <p class="location"><span class="fa fa-map-marker"></span> Từ : {{ isset($tour->t_starting_gate) ? $tour->t_starting_gate : '' }}</p>
        <p class="location"><span class="fa fa-plane"></span> Đến : {{ isset($tour->t_destination) ? $tour->t_destination : '' }}</p>
    
    @if ($eventdate)
        <p class="location"><span class="fa fa-calendar-check-o"></span> Khởi hành: {{ date('d/m/Y', strtotime($eventdate->td_start_date)) }}  
            <span class="fa fa-clock-o"></span>  {{ date('H:i', strtotime($eventdate->td_start_date)) }}</p>
        @php
            $number = $tour->t_number_guests - $eventdate->number_registered;
        @endphp

        <p class="location"><span class="fa fa-user">Còn trống: {{ $number }}</p>
            @if($number-$eventdate->e_follow<2 && $eventdate->number_registered!=$tour->t_number_guests)
                <a style="color:red"> Sắp hết </a>
                @endif
    @else
        <p class="location">Không có lịch trình khả dụng.</p>
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
