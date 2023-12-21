<?php
      $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $b_total_price ?? 0;
        $redirectUrl = route('payment.success');
        $ipnUrl = route('payment.ipn');
        $extraData = "";
    
?>

<!DOCTYPE html>
<html>
<head>
    <title>Đang chuyển hướng thanh toán...</title>
</head>
<body>
    <form id="redirectForm" action="{{ $payUrl }}" method="POST">
        @csrf
        <input type="hidden" name="partnerCode" value="{{ $partnerCode }}">
        <input type="hidden" name="accessKey" value="<?= $accessKey ?>">
        <input type="hidden" name="secretKey" value="<?= $secretKey ?>">
        <input type="hidden" name="orderInfo" value="<?= $orderInfo ?>">
        <input type="hidden" name="amount" value="<?= $amount ?>">
        <input type="hidden" name="orderId" value="<?= $orderId ?>">
        <input type="hidden" name="redirectUrl" value="<?= $redirectUrl ?>">
        <input type="hidden" name="ipnUrl" value="<?= $ipnUrl ?>">
        <input type="hidden" name="extraData" value="<?= $extraData ?>">
    </form>

    <script type="text/javascript">
        document.getElementById('redirectForm').submit();
    </script>
</body>
</html>