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
                        <li class="breadcrumb-item"><a href="#">Tour theo yêu cầu</a></li>
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
                    <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i class="fas fa-file-pdf"></i> Xuất PDF</a>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="btn-group">
                                    <a href="{{ route('bespoketour.create') }}"><button type="button" class="btn btn-block btn-info"> <i class="fas fa-pencil-alt"></i> Tạo mới</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover table-bordered">
                                <thead class="gray-header">
                                <tr>
                                    <th width="4%" class=" text-center">STT</th>
                                    <th  class="text-center">Tên mã</th>
                                    <th  class="text-center">Mã giảm</th>

                                
                                </tr>
                                </thead>
                                <tbody>
                          
                                  
                                </tbody>
                            </table>
                          
                        </div>
                      
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
             <!-- /.card -->
       
@stop
