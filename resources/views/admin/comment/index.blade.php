@extends('admin.layouts.main')
@section('title', '')
@section('content')
@include('admin.common.header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <div class="app-title">
                        <ul class="app-breadcrumb breadcrumb">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"> <i class="nav-icon fas fa fa-home"></i> Trang chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('comment.index') }}">Bình luận</a></li>
                        <li class="breadcrumb-item active">Danh sách</li>
                    </ol>
                </ul>
                </div>
            </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h3 class="card-title">Tìm kiếm</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-search"></i> Thu gọn
                            </button>
                        </div>
                    </div>
                    
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control mg-r-15" placeholder="Tên người bình luận">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <div class="form-group">
                                        <input type="text" name="email" class="form-control mg-r-15" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="input-group-append">
                                        <select name="searchType" class="form-control" id="searchType">
                                            <option value="">Chọn loại tìm kiếm</option>
                                            <option value="cm_tour_id">Tour du lịch</option>
                                            <option value="cm_article_id">Bài Viết</option>
                                            <option value="cm_hotel_id">Khách sạn</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-success " style="margin-right: 10px"><i class="fas fa-search"></i> Tìm kiếm </button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th>Tên user</th>
                                    <th>Email</th>
                                    <th>Nội dung</th>
                                    <th>Đánh giá</th>
                                    <th>Tiêu đề</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class=" text-center">Hành động</th>
                               
                                </tr>
                                </thead>
                                <tbody>
                                @if (!$comments->isEmpty())
                                    @php $stt = $comments->firstItem(); @endphp
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td class="text-center" style="vertical-align: middle; width: 2%">{{ $stt }}</td>
                                            <td style="vertical-align: middle; width: 10%" class="title-content">
                                                {{ isset($comment->user) ? $comment->user->name : '' }}
                                            </td>
                                            <td style="vertical-align: middle; width: 10%" class="title-content">
                                                {{ isset($comment->user) ? $comment->user->email : '' }}
                                            </td>
                                             <td style="vertical-align: middle;">
                                                {{ $comment->cm_content }}
                                            </td>
                                            <td style="vertical-align: middle; width: 15%">
                                                @if ($comment->cm_rating)
                                                    <div class="starability-result" data-rating="{{ $comment->cm_rating }}">
                                                        <span class="starability-outer">
                                                            <span class="starability-inner" style="width: {{ $comment->cm_rating/5*100 }}%"></span>
                                                        </span>
                                                        <span class="starability-text">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                @if ($i <= $comment->cm_rating)
                                                                    <span class="fa fa-star checked"></span>
                                                                @else
                                                                    <span class="fa fa-star"></span>
                                                                @endif
                                                            @endfor
                                                        </span>
                                                    </div>
                                                @else
                                                    Chưa có đánh giá
                                                @endif
                                            </td>                                            
                                            <td style="vertical-align: middle; width: 10%" class="title-content">
                                                @if (isset($comment->tour))
                                                    {{ $comment->tour->t_title }}
                                                @elseif (isset($comment->hotel))
                                                    {{ $comment->hotel->h_name }}
                                                @endif
                                            </td>
                                            
                                            <td style="vertical-align: middle; width: 11%">
                                                <button type="button" class="btn btn-block {{ $classStatus[$comment->cm_status] }} btn-xs">{{ $status[$comment->cm_status] }}</button>
                                            </td>
                                           
                                                <td style="vertical-align: middle; width: 17%" class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-success btn-sm">Action</button>
                                                        <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu action-transaction" role="menu">
                                                            <li><a href="{{ route('comment.delete', $comment->id) }}" class="btn-confirm-delete"><i class="fa fa-trash"></i>  Delete</a></li>
                                                            @foreach($status as $key => $item)
                                                                <li class="update_book_tour" url='{{ route('comment.update.status', ['status' => $key, 'id' => $comment->id]) }}'><a><i class="fas fa-check"></i>  {{ $item }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </td>
                                           
                                        </tr>
                                        @php $stt++ @endphp
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if($comments->hasPages())
                            <div class="pagination float-right margin-20">
                                {{ $comments->appends($query = '')->links() }}
                            </div>
                        @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <style>
                        .starability-result .checked {
                    color: #FFD700; /* Đây là màu sắc ví dụ, bạn có thể thay đổi thành màu sắc mong muốn */
                    }
                   </style>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@stop
