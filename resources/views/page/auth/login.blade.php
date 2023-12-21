@extends('page.layouts.page')
@section('title', 'Đăng nhập - Tin tức Du lịch - Thông tin Du lịch, Tin tức Du Lịch Việt Nam 2021')
@section('style')
@stop
@section('content')

    <section class="ftco-section ftco-no-pb contact-section mb-4">
        <div class="container">
            <div class="row block-9">
                <div class="col-md-12 order-md-last bg-light p-5 d-flex">
                    <div class="col-md-6" style="margin: auto" >
                        <form action="{{ route('account.login') }}" method="POST" class="contact-form">
                            @csrf
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Email <sup class="text-danger">(*)</sup></label>
                                <input type="text" name="email" class="form-control" placeholder="Email">
                                @if ($errors->first('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Mật khẩu <sup class="text-danger">(*)</sup></label>
                                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                                @if ($errors->first('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="col-md-12 text-center">
                                <div class="form-group" style="text-align: center;">
                                    <input type="submit" value="Đăng nhập" class="btn btn-primary py-3 px-5" style="display: inline-block;">
                                </div>                                
                               
                                <div class="form-group">
                                    <a class="btn btn-link" href="{{ route('password.email') }}">
                                        {{ __('Quên mật khẩu?') }}
                                    </a>
                                </div>                                
                            
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
@stop