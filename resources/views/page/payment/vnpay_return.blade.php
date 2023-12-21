<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
</head>
<body>
    <form id="redirectForm" action="{{ route('vnpay_return') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="vnp_ResponseCode" value="00">
        <input type="hidden" name="vnp_TxnRef" value="123456">
        <!-- Các trường dữ liệu khác -->
    </form>
    <script type="text/javascript">
        document.getElementById('redirectForm').submit();
    </script>
</body>
</html>
