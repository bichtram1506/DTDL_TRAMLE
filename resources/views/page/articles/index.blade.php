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
                            <h1>Tin Tức</h1>
                        </div>
                    </div>
                </div>
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <p class="breadcrumbs"><span class="mr-2"><a href="{{ route('page.home') }}">Trang chủ <i class="fa fa-chevron-right"></i></a></span> <span>Tin Tức <i class="fa fa-chevron-right"></i></span></p>
            </div>
         </div>
    </div>
    </section>
    <section class="ftco-section ftco-no-pb">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-wrap-1 ftco-animate fadeInUp ftco-animated" style="margin-top: 20px;">
                        <form action="{{ route('articles.index') }}" class="search-property-1">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <div class="form-group p-4 border-0">
                                        <label for="#" style="font-size: 18px; font-weight: bold;">Từ khóa </label>
                                        <div class="form-field">
                                            <div class="icon"><span class="fa fa-search"></span></div>
                                            <input type="text" name="key_search" class="form-control" placeholder="Từ khóa " style="padding: 10px; border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group p-4 border-0">
                                        <label for="#" style="font-size: 18px; font-weight: bold;">Danh mục </label>
                                        <div class="form-field">
                                            <div class="icon"><span class="fa fa-list"></span></div>
                                            <select name="category" class="form-control" style="padding: 10px; border-radius: 5px;">
                                                <option value="">Chọn danh mục</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->c_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex">
                                    <div class="form-group d-flex w-100 border-0">
                                        <div class="form-field w-100 align-items-center d-flex">
                                            <input type="submit" value="Tìm kiếm" class="align-self-stretch form-control btn btn-primary" style="padding: 10px; border-radius: 5px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    <section class="ftco-section">
        <div class="container">
            <div class="row d-flex">
                @if ($articles->count() > 0)
                    @foreach($articles as $article)
                        @include('page.common.itemArticle', compact('article'))
                    @endforeach
                @endif
            </div>
            <div class="row mt-5">
                <div class="col text-center">
                    <div class="block-27">
                        {{ $articles->links('page.pagination.default') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop