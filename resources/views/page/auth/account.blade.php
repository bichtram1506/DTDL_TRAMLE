@extends('page.layouts.page')
@section('title', 'Thông tin tài khoản - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')
<style>
 

 h1 {
        text-align: center;
    }

    form {
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-weight: bold;
    }

    input[type="text"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input[type="file"] {
        width: 100%;
        padding: 10px;
    }

    .avatar-container {
        text-align: center;
    }

    .avatar-container img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
    }

    .btn-update {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-update:hover {
        background-color: #0056b3;
    }

    .text-danger {
        color: red;
    }
</style>
    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container ">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-12 ftco-animate py-md-5 sidebar-box ftco-animate fadeInUp ftco-animated">
                    <h1>Thông tin tài khoản</h1>
                    <form action="{{ route('update.info.account', $user->id) }}" method="POST" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="name">Họ và tên <sup class="text-danger">(*)</sup></label>
                              <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
                              @if ($errors->first('name'))
                              <span class="text-danger">{{ $errors->first('name') }}</span>
                              @endif
                            </div>
                            <div class="form-group">
                              <label for="email">Email <sup class="text-danger">(*)</sup></label>
                              <input type="text" name="email" value="{{ old('email', $user->email) }}" required>
                              @if ($errors->first('email'))
                              <span class="text-danger">{{ $errors->first('email') }}</span>
                              @endif
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="phone">Số điện thoại <sup class="text-danger">(*)</sup></label>
                              <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                              @if ($errors->first('phone'))
                              <span class="text-danger">{{ $errors->first('phone') }}</span>
                              @endif
                            </div>
                            <div class="form-group">
                              <label for="address">Địa chỉ <sup class="text-danger">(*)</sup></label>
                              <input type="text" name="address" value="{{ old('address', $user->address) }}" required>
                              @if ($errors->first('address'))
                              <span class="text-danger">{{ $errors->first('address') }}</span>
                              @endif
                            </div>
                            <div class="form-group">
                              <label for="avatar">Ảnh đại diện</label>
                              <input type="file" id="avatar" name="images">
                            </div>
                            <div class="avatar-container">
                              <img
                                src="{{  $user->avatar ? asset(pare_url_file($user->avatar)) :  asset('page/images/user_default.png') }}"
                                alt="Avatar">
                            </div>
                          </div>
                        </div>
                        <button class="btn-update" type="submit">Cập nhật</button>
                      </form>
                </div> <!-- .col-md-8 -->
            </div>
        </div>
    </section>
@stop
@section('script')
@stop