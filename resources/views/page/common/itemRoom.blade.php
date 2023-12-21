<div class="{{ !isset($itemRoom) ? 'col-md-4' : '' }} ftco-animate fadeInUp ftco-animated {{ isset($itemRoom) ? $itemRoom : '' }}">
    <div class="project-wrap hotel">
        <a href="{{ route('room.detail', ['id' => $room->id, 'slug' => safeTitle($room->rm_name)]) }}"
           class="img" style="background-image: url({{ $room->image ? asset(pare_url_file($room->image)) : asset('admin/dist/img/no-image.png') }});">
           @if ($room)
           @if ($room->rm_sale > 0)
               <span class="price">Sale {{ $room->rm_sale }}%</span>

           @endif
       @endif
        </a>
        <div class="text p-4">
            <h3>
                <a href="{{ route('room.detail', ['id' => $room->id, 'slug' => safeTitle($room->rm_name)]) }}" title="{{ $room->rm_name }}">
                    {{ the_excerpt($room->rm_name, 100) }}
                </a>
            </h3>
           
            <p class="location"><span class="fa fa-map-marker" style="margin-right: 10px"></span>{{ isset($room->location) ? $hotel->location->l_name : '' }}</p>
            <p>{!! the_excerpt($room->rm_description, 200) !!}<a href="{{ route('room.detail', ['id' => $room->id, 'slug' => safeTitle($room->rm_name)]) }}" title="{{ $room->rm_name }}" class="btn btn-primary">Xem thêm</a></p>
    
        <!-- Hiển thị thông tin khách sạn -->
        <h2>{{ $room->rm_name }}</h2>
        <!-- Các chi tiết khác về khách sạn -->
            @if ($hotel)
            <div style="text-align: right;">
                    <span style="font-size: 25px; font-weight: bold; color: #FFA500;">{{ number_format($room->rm_price, 0, ',', '.') }} <span style="font-weight: normal;">VND</span></span>
            </div>
        @endif
        </div>
    </div>
</div>
