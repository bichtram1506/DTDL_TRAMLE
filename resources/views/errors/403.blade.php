@extends('admin.layouts.main')

@section('content')
    @include('admin.common.header')

    <section class="content-header">
        <div class="error-container">
            <div class="error-content">
                <div class="error-header text-center">
                    <div class="error-icon">
                        <span class="digit thirdDigit"></span>
                        <span class="digit secondDigit"></span>
                        <span class="digit firstDigit"></span>
                    </div>
                    <div class="error-title">OH!<span class="triangle"></span></div>
                </div>
                <div class="error-message text center">
                    <h2 class="h1">Xin lỗi!</h2>
                    <p>Bạn không có quyền truy cập chức năng này.</p>
                    <button type="button" class="btn btn-info btn-lg" onclick="window.history.back()"><i class="fa fa-hand-o-left" aria-hidden="true"></i> Quay trở lại</button>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
        .error-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .error-content {
            text-align: center;
        }

        .error-header {
            font-family: 'Anton', sans-serif;
            font-size: 120px;
            color: #555;
            margin-bottom: 20px;
        }

        .error-title {
            font-family: 'Passion One', cursive;
            font-size: 60px;
            color: #555;
            margin-top: 20px;
        }

        .error-message {
            margin-top: 40px;
        }

        .error-message h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .error-message p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .error-message button {
            font-size: 16px;
        }
    </style>
@endsection

@section('script')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script>
        function randomNum() {
            "use strict";
            return Math.floor(Math.random() * 9) + 1;
        }

        var loop1, loop2, loop3, time = 30, i = 0, number,
            selector3 = document.querySelector('.thirdDigit'),
            selector2 = document.querySelector('.secondDigit'),
            selector1 = document.querySelector('.firstDigit');

        loop3 = setInterval(function() {
            "use strict";
            if (i > 40) {
                clearInterval(loop3);
                selector3.textContent = 4;
            } else {
                selector3.textContent = randomNum();
                i++;
            }
        }, time);

        loop2 = setInterval(function() {
            "use strict";
            if (i > 80) {
                clearInterval(loop2);
                selector2.textContent = 0;
            } else {
                selector2.textContent = randomNum();
                i++;
            }
        }, time);

        loop1 = setInterval(function() {
            "use strict";
            if (i > 100) {
                clearInterval(loop1);
                selector1.textContent = 3;
            } else {
                selector1.textContent = randomNum();
                i++;
            }
        }, time);
    </script>
@endsection