@extends('page.layouts.page')
@section('title', 'Tour yêu thích - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-12 ftco-animate">
                    <h3 class="mb-0 bread text-center ">Tour Yêu thích</h3>
                    <table class="table table-hover table-bordered my-tour">
                        <thead class="thead-dark">
                            <tr>
                                <th style="vertical-align: middle; width: 3%">STT</th>
                                <th style="vertical-align: middle;">Tour</th>
                                <th style="vertical-align: middle;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($favoriteTours as $favoriteTour)
                                <tr>
                                    <td style="vertical-align: middle; width: 3%">{{ $loop->iteration }}</td>
                                    <td style="vertical-align: middle; width: 60%">
                                        <p><a href="{{ route('tour.detail', ['id' => $favoriteTour->id, 'slug' => safeTitle($favoriteTour->t_title)]) }}">{{ $favoriteTour->t_title }}</a></p>
                                        <img src="{{ $favoriteTour->t_image ? asset(pare_url_file($favoriteTour->t_image)) : asset('admin/dist/img/no-image.png') }}" alt="" class="img-fluid" style="width: 300px; height: 200px;">
                                    </td>
                                    <td style="vertical-align: middle; width: 30%">
                                        <a href="{{ route('tour.deleteFavorite', ['id' => $favoriteTour->id]) }}" class="btn-confirm-delete">
                                            <i class="fa fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                    </div>
                    </div>
                </div>
            </div>
            <!-- .col-md-8 -->
        </div>
    </section>
@stop
@section('script')
@stop
