<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yêu Cầu Báo Giá</title>
</head>
<body>
    <h2>Yêu Cầu Báo Giá</h2>
    <p>Xin chào {{ $user->name }},</p>
    <p>Chúng tôi đã nhận được yêu cầu của bạn về báo giá sơ bộ cho tour "{{ $tour->t_title }}".</p>
    <p>Bộ phận tư vấn của chúng tôi sẽ liên hệ với bạn sớm nhất để trao đổi chi tiết lịch trình và đáp ứng mọi nhu cầu của bạn. Sau cuộc trò chuyện đó, chúng tôi sẽ gửi cho bạn báo giá chính thức của tour.</p>
    <p>Dưới đây là báo giá sơ bộ:</p>
    <p>Ngày khởi hành {{ $eventdate->td_start_date}} </p>
    <ul>
        <li>Mã Tour: {{ $tour->t_code }}</li>
        <li>Giá người lớn: {{ $averagePrice }}</li>
        <li>Giá trẻ em: {{ $averagePrice_child }}</li>
       
    </ul>
    <p>Cảm ơn bạn đã chọn chúng tôi và mong sớm được phục vụ!</p>
</body>
</html>
