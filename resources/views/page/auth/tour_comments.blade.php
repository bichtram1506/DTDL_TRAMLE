@extends('page.layouts.page')
@section('title', 'Đánh giá tour - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')
 
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-12 ftco-animate ">
                    <form action="{{ route('tour-comments') }}" method="GET" class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="searchType">Loại tìm kiếm:</label>
                                <select name="searchType" id="searchType" class="form-control">
                                    <option value="all">Tất cả</option>
                                    <option value="hotel">Khách sạn</option>
                                    <option value="article">Bài viết</option>
                                    <option value="tour">Tour</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keyword">Từ khóa:</label>
                                <input type="text" name="keyword" id="keyword" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                        </div>
                    </form>
                    <h3 class="mb-0 bread text-center">ĐÁNH GIÁ VÀ BÌNH LUẬN</h3>
                    <table class="table table-hover table-bordered my-tour ">
                        <thead class="thead-dark">
                            <tr>
                                <th style="vertical-align: middle; width: 3%">STT</th>
                                <th style="vertical-align: middle;">Tiêu đề</th>
                                <th style="vertical-align: middle;">Loại</th>
                                <th style="vertical-align: middle;">Bình luận</th>
                                <th style="vertical-align: middle;">Đánh giá</th>
                                <th style="vertical-align: middle;">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = $userComments->firstItem(); @endphp
                            @foreach($userComments as $comment)
                                <tr>
                                    <td style="vertical-align: middle; width: 3%">{{ $i }}</td>
                        
                                    <td style="vertical-align: middle; width: 30%">
                                        @if($comment->booktour && $comment->booktour->eventdate && $comment->booktour->eventdate->tour)
                                        <b>
                                            <p>{!! $comment->booktour->eventdate->tour->t_title !!}</p>
                                            <p>{!! $comment->booktour->eventdate->td_start_date !!}</p>
                                        </b>
                                    @elseif($comment->tour)
                                        <p>{!! $comment->tour->t_title !!}</p>
                                  
                                    @endif
                                    
                                    <!-- Hiển thị thông tin về article -->
                                    @if ($comment->article)
                                    
                                        <p>{!! $comment->article->a_title !!}</p>
                                        <!-- ... -->
                                    @endif
                                    
                                    <!-- Hiển thị thông tin về hotel -->
                                    @if ($comment->hotel)
                                     
                                        <p> {!! $comment->hotel->h_name !!}</p>
                                        <!-- ... -->
                                    @endif
                                    </td>
                        <td style="vertical-align: middle; width: 15%">
                              @if($comment->booktour && $comment->booktour->eventdate && $comment->booktour->eventdate->tour || $comment->tour)
                            <p>Tour</p>
                                @elseif($comment->article)
                                <p>Bài viết</p>
                                @else   <p>Khách sạn</p>
                                @endif
                        </td>
                        
                                    <td style="vertical-align: middle; width: 30%">
                                        <p>{{ $comment->cm_content }}</p>
                                    </td>
                                    
                                    <td style="vertical-align: middle; width: 20%">
                                        @include('page.common.rating')
                                    </td>
                                    
                                    <td style="vertical-align: middle; width: 30%">
                                        <p>{{ $comment->created_at->format('H:i d/m/Y') }}</p>
                                    </td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        </tbody>
                        
                    </table>
                    
                <div class="row mt-5">
                    <div class="col text-center">
                        <div class="block-27">
                            {{$userComments->links('page.pagination.default') }}
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
