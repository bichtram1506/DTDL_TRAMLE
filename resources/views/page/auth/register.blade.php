@extends('page.layouts.page')
@section('title', 'Đăng ký - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')

    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-12 order-md-last d-flex">
                    <form action="{{ route('post.account.register') }}" method="POST" class="bg-light p-5 contact-form">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label">Họ và tên <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Họ và tên">
                            @if ($errors->first('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label">Email <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                            @if ($errors->first('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label">Số điện thoại <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Số điện thoại">
                            @if ($errors->first('phone'))
                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="address" class="control-label">Địa chỉ <sup class="text-danger">(*)</sup></label>
                            <input type="text" name="address" id="address" class="form-control" placeholder="Địa chỉ">
                            @if ($errors->first('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label">Mật khẩu <sup class="text-danger">(*)</sup></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Mật khẩu">
                            @if ($errors->first('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="r_password" class="control-label">Nhập lại mật khẩu <sup class="text-danger">(*)</sup></label>
                            <input type="password" name="r_password" id="r_password" class="form-control" placeholder="Nhập lại mật khẩu">
                            @if ($errors->first('r_password'))
                                <span class="text-danger">{{ $errors->first('r_password') }}</span>
                            @endif
                        </div>
                        <div class="col-md-12 text-center">
                            <div class="form-group">
                                <input type="submit" value="Đăng ký" class="btn btn-primary py-3 px-5">
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </section>
    <style>
.contact-form {
    border: 1px solid #ccc;
    padding: 30px;
    background-color: #f5f5f5;
    border-radius: 10px;
    transition: border-color 0.3s, box-shadow 0.3s;
    box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
}

.contact-form:hover {
    border-color: #3498db;
    box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
}

.contact-form label {
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.contact-form input[type="text"],
.contact-form input[type="password"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    width: 100%;
    background-color: #ffffff;
    color: #333;
}

.contact-form input[type="text"]:focus,
.contact-form input[type="password"]:focus {
    border-color: #3498db;
}

.contact-form input[type="submit"] {
    padding: 10px 20px;
    background-color: #3498db;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

.contact-form input[type="submit"]:hover {
    background-color: #2980b9;
}

        </style>
@stop
@section('script')
@stop