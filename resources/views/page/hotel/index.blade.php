@extends('page.layouts.page')
@section('title', 'Khách Sạn - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')
<style>
    .search-wrap-1 {
    position: absolute;
    bottom: 20px; /* Điều chỉnh khoảng cách từ bottom theo ý muốn */
    margin-left:90px;
    transform: translateX(-50%);
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease-in-out;
}
    </style>

    <section class="" style="background-image: url({{ asset('/page/images/ks.jpg') }});">
        <div class="overlay"></div>
            <div class="container">
                
                <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center" >
                    
                
                    <div class="row ftco-section ftco-no-pb">
                        <div class="col-md-12">
                            <div class="search-wrap-1 ftco-animate fadeInUp ftco-animated">
                                @include('page.common.searchHotel', compact('regions'))
                            </div>
                        </div>
                    </div>
         
             </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row">
                @if ($filteredHotels->count())
                    @foreach($filteredHotels as $hotel)
                        @include('page.common.itemHotel', compact('hotel'))
                    @endforeach
                @endif
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        {{ $filteredHotels->links('page.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop