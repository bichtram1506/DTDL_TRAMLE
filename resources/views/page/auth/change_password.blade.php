@extends('page.layouts.page')
@section('title', 'Thông tin tài khoản - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('seo')
@stop
@section('content')

    <section class="ftco-section ftco-no-pt ftco-no-pb">
        <div class="container">
            <div class="row" style="margin-right: -100px;">
                @include('page.common.sideBarUser')
                <div class="col-lg-3" ></div>
                <div class="col-lg-6 ftco-animate sidebar-box ftco-animate fadeInUp ftco-animated"> 
                    <h3 class="text-center mt-5">Đổi Mật Khẩu</h3>
                    <form action="{{ route('post.change.password') }}" method="POST" class="p-5 contact-form">
                        @csrf
                        <div class="form-group">
                            <label for="currentPassword" class="control-label">Mật khẩu hiện tại <sup class="text-danger">*</sup></label>
                            <input type="password" name="c_password" class="form-control" id="currentPassword" placeholder="Mật khẩu hiện tại">
                            @if ($errors->first('c_password'))
                                <span class="text-danger">{{ $errors->first('c_password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="newPassword" class="control-label">Mật khẩu mới <sup class="text-danger">*</sup></label>
                            <input type="password" name="password" class="form-control" id="newPassword" placeholder="Mật khẩu mới">
                            @if ($errors->first('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="confirmPassword" class="control-label">Xác nhận mật khẩu mới <sup class="text-danger">*</sup></label>
                            <input type="password" name="r_password" class="form-control" id="confirmPassword" placeholder="Xác nhận mật khẩu mới">
                            @if ($errors->first('r_password'))
                                <span class="text-danger">{{ $errors->first('r_password') }}</span>
                            @endif
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Cập nhật</button>
                        </div>
                    </form>
                </div> <!-- .col-md-8 -->
            </div>
        </div>
    </section>
@stop
@section('script')
@stop