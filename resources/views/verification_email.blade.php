<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực tài khoản</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        a:hover {
            background-color: #a04c9c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Xin chào, {{ $user->name }}!</h2>
        <p>Chúc mừng bạn đã đăng ký tài khoản. Để tiếp tục sử dụng dịch vụ của chúng tôi, vui lòng xác thực tài khoản bằng cách nhấp vào liên kết dưới đây:</p>
        <a href="{{ route('verify-account', $user->verification_token) }}">Xác thực tài khoản</a>
        <p>Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này.</p>
        <p>Trân trọng,</p>
        <p>Đội ngũ hỗ trợ của chúng tôi</p>
    </div>
</body>
</html>
