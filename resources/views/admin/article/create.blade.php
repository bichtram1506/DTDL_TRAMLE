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
                        <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Bài viết</a></li>
                        <li class="breadcrumb-item active">Tạo mới</li>
                    </ol>
                </ul>
            </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('admin.article.form')
    </section>
@stop