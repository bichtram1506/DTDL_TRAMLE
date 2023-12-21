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
                        <li class="breadcrumb-item"><a href="{{ route('region.index') }}">Miền</a></li>
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
     
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <a href="{{ route('region.create') }}"><button type="button" class="btn btn-block btn-info"> <i class="fas fa-pencil-alt"></i> Tạo mới</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th width="4%" class=" text-center">STT</th>
                                        <th>Tên miền</th>
                                        <th>Hình ảnh</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class=" text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!$regions->isEmpty())
                                        @php $i = $regions->firstItem(); @endphp
                                        @foreach($regions as $region)
                                            <tr>
                                                <td class="text-center" style="vertical-align: middle;">{{ $i }}</td>
                                                <td class="title-content" style="vertical-align: middle;width: 30% ">
                                                    {{ $region->r_name }}
                                                </td>
                                                <td style="vertical-align: middle; width:20%;">
                                                    @if(isset($region) && !empty($region->r_image))
                                                        <img src="{{ asset(pare_url_file($region->r_image)) }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                                    @else
                                                        <img src="{{ asset('admin/dist/img/no-image.png') }}" alt="" class="margin-auto-div img-rounded"  id="image_render" style="height: 100px; width:100%;">
                                                    @endif
                                                </td>
                                                <td class="text-center" style="vertical-align: middle;">{{ $status[$region->r_status] }}</td>
                                                <td class="text-center" style="vertical-align: middle;">
                                              
                                                    <a class="btn btn-primary btn-sm" href="{{ route('region.update', $region->id) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm btn-delete btn-confirm-delete" href="{{ route('region.delete', $region->id) }}">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @php $i++ @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            @if($regions->hasPages())
                                <div class="pagination float-right margin-20">
                                    {{ $regions->appends($query = '')->links() }}
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
