
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>

.reset-image {
    background-image: url('https://cdn.pixabay.com/photo/2021/10/20/16/07/forgot-password-6726499_1280.png');
    background-size: cover;
    background-position: left; /* Đặt vị trí hiển thị của hình ảnh bên trái */
    height: 300px; /* Đặt chiều cao của phần tử chứa hình ảnh */
    width: 30%; /* Đặt chiều rộng của phần tử chứa hình ảnh */
    float: left; /* Dịch chuyển phần tử về bên trái */
}


        body {
            background-color: #f8f9fa;
        }

       

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            font-size: 24px;
            padding: 20px;
            text-align: center;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            font-size: 16px;
            padding: 10px;
            width: 300px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
            font-size: 18px;
            padding: 12px 30px;
            margin-top: 20px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .reset-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .reset-image img {
            max-width: 200%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <!-- Column for Image -->
            <div class="col-md-4">
                <div class="reset-image" style="background-image: url('{{ asset('/page/images/fg-img.png') }}');"></div>
            </div>
            
            <!-- Column for Password Reset Form -->
            <div class="col-md-8 " style="margin-top:19px;">
                <div class="card">
                    <h3 class="">{{ __('Đặt lại mật khẩu') }}</h3>
                    
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
