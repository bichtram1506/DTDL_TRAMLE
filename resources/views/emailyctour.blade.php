<!DOCTYPE html>
<html>
<head>
    <title>Đã nhận đơn đặt tour thiết kế </title>
</head>
<body>
    <table align="center" width="600" cellpadding="0" cellspacing="0" style="border-collapse: collapse; margin: auto; font-family: Arial, sans-serif;">
        <tr>
            <td align="center" bgcolor="#f2f2f2" style="padding: 40px 0;">
                <img src="https://www.vietiso.com/images/2023/blog/2-2023/Role-of-logo.png" alt="Logo" style="max-width: 150px;">
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px;">
                <h3>Xin chân thành cảm ơn quý khách đã lựa chọn dịch vụ của chúng tôi!</h3>
                <p style="text-align: center;">Chúng tôi đã nhận được đơn đặt tour yêu cầu của quý khách và sẽ liên hệ trong thời gian sớm nhất để hoàn tất quá trình xác nhận. Trân trọng!</p> 
                <ul>
                    <li><strong>Mã Tour:</strong> {{$tour->t_code}}</li>
                    @if ($user)
                    <li><strong>Tên Khách Hàng:</strong> {{ $user->name }}</li>
                @else
                    <li><strong>Tên Khách Hàng:</strong> {{ $booktour->b_name }}</li>
                @endif
                    <li><strong>Điểm khởi hành:</strong> {{$tour->t_starting_gate }}</li>
                    <li><strong>Điểm Đến Mong Muốn:</strong>  @foreach ($tour->locations as $key => $location)
                        <span>{{ $location->l_name }}</span>
                        @if ($key < count($tour->locations) - 1)
                            <span>, </span>
                        @endif
                    @endforeach
                </li>
                <p><b>Mã booking:</b> <span style="color:#FF0000;">{{$booktour->id}}</span><br><span style="color:#FF0000;">Xin quý khách vui lòng nhớ số booking để thuận tiện cho giao dịch sau này</span></p>
       
                <p><b>Trị giá booking:</b> {{ $booktour->b_total_price > 0 ? number_format($booktour->b_total_price, 0, ',', '.') . ' VND' : 'Đang cập nhật' }}</p>
                <p><b>Người lớn:</b> {{ $booktour->b_number_adults }} </p>
                @if ($booktour->b_number_children > 0)
                    <p><b>Trẻ em: </b>{{ $booktour->b_number_children }}</p>
                @endif
                @if ($booktour->b_number_child6 > 0)
                    <p><b>Trẻ dưới 6 tuổi: </b>{{ $booktour->b_number_child6 }}</p>
                @endif
                @if ($booktour->b_number_child2 > 0)
                    <p><b>Trẻ dưới 2 tuổi: </b>{{ $booktour->b_number_child2 }}</p>
                @endif  
                    <li><strong>Ngày Đi Dự Kiến:</strong> {{$eventdate->td_start_date}}</li>
                </ul>
                <p><b>Phương thức thanh toán:</b></p>
                @if ($booktour->b_payment_method === 'cash')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-money" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Tiền mặt</span>
                    </p>
                    <p style="margin-bottom: 10px;">Vui lòng đến cửa hàng của chúng tôi để thanh toán trực tiếp:</p>
                    <p style="margin-bottom: 5px;">CÔNG TY CỔ PHẦN DU LỊCH VIETOURIST</p>
                    <p style="margin-bottom: 5px;">Địa chỉ: 154 Lý Chính Thắng, Phường 7, Quận 3, TP. HCM</p>
                    <p style="margin-bottom: 5px;">Điện thoại: 08. 62 61 63 65</p>
                    <p style="margin-bottom: 5px;">Hotline: 089 990 9145</p>
                @elseif ($booktour->b_payment_method === 'VNPay')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-bank" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Thanh toán VNPay</span>
                    </p>
                    @elseif ($booktour->b_payment_method === 'MOMO')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-bank" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Thanh toán Ví MOMO</span>
                    </p>
                @elseif ($booktour->b_payment_method === 'bankTransfer')
                    <p style="margin-bottom: 20px;">
                        <i class="fa fa-university" style="font-size: 20px; margin-right: 10px;"></i>
                        <span style="font-weight: bold;">Chuyển khoản ngân hàng</span>
                    </p>
                    <p style="margin-bottom: 10px;">Vui lòng sử dụng thông tin tài khoản dưới đây để chuyển khoản:</p>
                    <p style="margin-bottom: 5px;">Ngân hàng: Tên ngân hàng</p>
                    <p style="margin-bottom: 5px;">Chi nhánh: Chi nhánh XYZ</p>
                    <p style="margin-bottom: 5px;">Số tài khoản: 1601100633008</p>
                    <p style="margin-bottom: 5px;">Chủ tài khoản: Lê Thi Bích Trâm</p>
                    <p style="margin-bottom: 5px;">Nội dung chuyển khoản: [Mã đơn hàng, Tên khách hàng]</p>
                @endif
       
             
                <p>Thông tin tour yêu cầu tại đây: <a href="{{ route('tour.detail', ['id' => $tour->id, 'slug' => safeTitle($tour->t_title)]) }}">{{ $tour->t_title }}</a></p>
                <p>Chúng tôi hiểu rằng việc lựa chọn một chuyến du lịch hoàn hảo là một quyết định quan trọng và đòi hỏi sự tận tâm và kỹ lưỡng. Chúng tôi cam kết sẽ làm việc chăm chỉ để tạo ra một trải nghiệm du lịch độc đáo và đáp ứng đúng mong đợi của Quý Khách hàng.</p>
                <p>Chúng tôi sẽ nhanh chóng xem xét yêu cầu của Quý Khách hàng và liên hệ lại trong thời gian sớm nhất để thảo luận thêm về các chi tiết cụ thể và tạo ra một tour hoàn hảo cho Quý Khách hàng.</p>
                <p>Trong trường hợp có bất kỳ câu hỏi hoặc thắc mắc nào, Quý Khách hàng vui lòng liên hệ với chúng tôi qua email này hoặc số điện thoại: [Số Điện Thoại Liên Hệ].</p>
                <p>Chúng tôi hy vọng sẽ được làm đối tác du lịch của Quý Khách hàng và tạo ra một trải nghiệm du lịch đáng nhớ.</p>
                <p>Xin chân thành cảm ơn và kính chúc Quý Khách hàng một ngày tràn đầy niềm vui và hạnh phúc!</p>
                <p>Trân trọng và tôn trọng,</p>
                <p>ABC Travel Company</p> <p>123 Đường Du Lịch, Thành phố X, Quốc gia Y</p> <p>+1234567890</p> <p>info@abctravel.com</p>
            </td>
        </tr>
        <div style="background-color: #f2f2f2; padding: 10px; border: 1px solid #ccc; width: 300px; text-align: center; margin: 0 auto;">
            <p style="font-size: 18px; color: #333;">Hỗ trợ khách hàng</p>
            <p style="color: #007bff;">Hotline: 1900 1808</p>
            <p style="color: #007bff;">Email: info@saigontourist.net</p>
            <p style="color: #007bff;">Bạn muốn được gọi lại?</p>
          </div>
          
        <tr>
            <td bgcolor="#f2f2f2" style="padding: 20px; text-align: center; font-size: 12px;">
                © {{ date('Y') }} Du lịch Việt. All rights reserved.
            </td>
        </tr>
    </table>
</body>
</html>
