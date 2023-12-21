<!DOCTYPE html>
<html>
<head>
    <title>Đang chuyển hướng thanh toán...</title>
</head>
<body>
    <form id="redirectForm" action="{{ $vnpayUrl }}" method="POST">
        @csrf
        <input type="hidden" name="b_total_price" value="{{ session('b_total_price') }}">
        <input type="hidden" name="vnp_TxnRef" value="{{ $vnp_TxnRef }}">
        
    </form>

    <script type="text/javascript">
        document.getElementById('redirectForm').submit();
    </script>
</body>
</html>
