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
                        <li class="breadcrumb-item"><a href="{{ route('tourtype.index') }}">Loại tour</a></li>
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
                                        <input type="text" name="tt_name" class="form-control mg-r-15" placeholder="Tên địa điểm">
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
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <a href="{{ route('tourtype.create') }}"><button type="button" class="btn btn-block btn-info"> <i class="fas fa-pencil-alt"></i> Tạo mới</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="4%" class=" text-center">STT</th>
                                        <th>Tên</th>
                                        <th>Hình ảnh</th>
                                       
                                        <th class=" text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$tourtypes->isEmpty())
                                        @php $i = $tourtypes->firstItem(); @endphp
                                        @foreach($tourtypes as $tourtype)
                                            <tr>
                                                <td class="text-center" style="vertical-align: middle;">{{ $i }}</td>
                                                <td class="title-content" style="vertical-align: middle;width: 30% ">
                                                    {{ $tourtype->tt_name }}
                                                </td>
                                                <td style="vertical-align: middle; width:20%;">
                                                    @if(isset($tourtype) && !empty($tourtype->tt_image))
                                                        <img src="{{ asset(pare_url_file($tourtype->tt_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 200px; width:200px;">
                                                    @else
                                                        <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                                    @endif
                                                </td>      
                                               
                                                
                                                <td class="text-center" style="vertical-align: middle;">
                                             
                                                    <a class="btn btn-primary btn-sm" href="{{ route('tourtype.update', $tourtype->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('tourtype.delete', $tourtype->id) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if($tourtypes->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $tourtypes->appends($query = '')->links() }}
                                </div>
                            @endif
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
@stop
