<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookTour;
use App\Models\EventDate;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Mail;

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}
class PaymentController extends Controller
{
    //
    public function vnpay_payment(Request $request)
    {
        
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $totalPrice = session('b_total_price');
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay_return?totalPrice=" . $totalPrice;
        $vnp_TmnCode = "TY70DY9U"; //Mã website tại VNPAY 
        $vnp_HashSecret = "XTSMGZBREUNBTKIJTDMBAOLDSWSLLQAS"; //Chuỗi bí mật

        // Lấy tổng tiền từ request

        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $vnp_OrderInfo = "Thanh toán tour ";
        $vnp_OrderType = "Tour Du Lịch";
        $vnp_Amount = $totalPrice * 100; // Sử dụng tổng tiền từ request
        $vnp_Locale = "VN";
        $vnp_BankCode = "";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
         
        );
        
        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }
        
        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array('code' => '00'
            , 'message' => 'success'
            , 'data' => $vnp_Url);
            if (isset($_POST['redirect'])) {
                header('Location: ' . $vnp_Url);
                die();
            } else {
                echo json_encode($returnData);
            }
            
            header('Location: ' . $vnp_Url);
            die();
     
    }
    public function vnpay_return(Request $request)
    {
        // Lấy dữ liệu từ yêu cầu POST
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        // ... (các thông tin khác từ VNPAY)
        
        // Xử lý kết quả thanh toán tại đây
        $bookTour = BookTour::where('id', $vnp_TxnRef)->first();
        
        if (!$bookTour) {
            return redirect()->route('page.home')->with('error', 'Không tìm thấy đơn đặt tour.');
        }
        
        $eventdate = $bookTour->eventdate;
        
        if (!$eventdate) {
            return redirect()->route('page.home')->with('error', 'Ngày sự kiện không tồn tại');
        }
        
        $tour = $eventdate->tour;
        $extraServiceArray = [];
    
        // Decode the JSON string from the extra_service_id field of the BookTour model
        $extraServices = json_decode($bookTour->extra_service_id, true);
    
        // Store the decoded extra service information in the array
        $extraServiceArray[$bookTour->id] = $extraServices;

        
      
        if ($vnp_ResponseCode == "00") {
            if ($bookTour->b_status == 1) {
                $eventdate->number_registered += $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                $eventdate->td_follow -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                $eventdate->save();
            }
        }
            // Lưu thông tin thanh toán dựa trên kết quả thanh toán
            Payment::create([
                'p_booktour_id' => $vnp_TxnRef, // Sử dụng ID của đơn đặt tour
                'p_total_price' => $bookTour->b_total_price, // Lấy tổng tiền từ đơn đặt tour
                'p_vnp_response_code' => $vnp_ResponseCode,
                'p_code_vnpay' => $request->input('vnp_TransactionNo'), // Sử dụng thông tin từ VNPAY
                'p_code_bank' => $request->input('vnp_BankCode'), // Sử dụng thông tin từ VNPAY
            ]);
        
        
        // Đặt trạng thái đơn đặt tour dựa trên kết quả thanh toán
        $bookTour->b_status = ($vnp_ResponseCode == "00") ? 3 : 5; // 3 là thành công, 5 là thất bại
        $bookTour->save();
    
        \DB::commit();
        $user = User::find($bookTour->b_user_id);
        $mailuser = $user ? $user->email : $bookTour->b_email;
            $emailSubject = ($vnp_ResponseCode == "00") ? 'Xác nhận thanh toán thành công' : 'Xác nhận thanh toán thất bại';
            Mail::send('emailttvnpay', compact('user', 'bookTour', 'eventdate', 'tour',  'vnp_ResponseCode','extraServices','extraServiceArray'), function ($email) use ($mailuser, $emailSubject) {
                $email->subject($emailSubject);
                $email->to($mailuser);
            });
        if ($vnp_ResponseCode == "00") {
            return redirect()->route('page.home')->with('success', 'Thanh toán thành công.');
        } else {
            return redirect()->route('page.home')->with('error', 'Thanh toán thất bại.');
        }
    }
    public function processPayment(Request $request)
    {
        $b_total_price = $request->input('b_total_price');
        session(['b_total_price' => $b_total_price]);
        
        // Lấy ID đơn hàng từ request
        $booktourId = $request->input('booktourId');
        
        // Tạo mã đơn hàng từ ID của bản ghi đơn hàng
        $vnp_TxnRef = $booktourId;
     // Kiểm tra trạng thái b_status của đơn hàng
        $order = BookTour::find($booktourId);
        if ($order && $order->b_status === 3 || $order->b_status === 4) {
            // Đơn hàng đã có trạng thái 3 (đã thanh toán)
            return "Đơn hàng đã được thanh toán thành công.";
        }
        // Sử dụng JavaScript để tạo và gửi một form để khởi tạo một yêu cầu POST
        return view('page.payment.redirect_to_vnpay', ['vnpayUrl' => route('vnpay_payment'), 'vnp_TxnRef' => $vnp_TxnRef]);
    }

    public function momo_payment(Request $request){
       
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $b_total_price ?? 0;
        $orderId = $request->input('booktour_id') . "_" . time();
        $redirectUrl = route('payment.success');
        $ipnUrl = route('payment.ipn');
        $extraData = "";
    
    if (!empty($_POST)) {
        $partnerCode = $_POST["partnerCode"];
        $accessKey = $_POST["accessKey"];
        $serectkey = $_POST["secretKey"];
        $orderId = $_POST["orderId"]; // Mã đơn hàng
        $orderInfo = $_POST["orderInfo"];
        $amount = $_POST["amount"];
        $ipnUrl = $_POST["ipnUrl"];
        $redirectUrl = $_POST["redirectUrl"];
        $extraData = $_POST["extraData"];
        // Truyền giá trị ID đơn vào biến $orderId
        $orderId = $_POST["orderId"];

        $requestId = time() . "";
        $requestType = "payWithATM";
        $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array('partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json
        //Just a example, please check more in there
        return redirect()->to($jsonResult['payUrl']);
    }
    }
    public function success(Request $request)
    {
        // Xử lý khi thanh toán thành công
        // Lưu thông tin thanh toán dựa trên kết quả thanh toán
        $orderId = $request->input('orderId'); // Lấy giá trị orderId từ dữ liệu POST
        $orderIds = explode("_", $orderId); // Tách chuỗi orderId thành mảng, phần tử đầu tiên sẽ là ID đơn đặt tour
    
        if (count($orderIds) > 0) {
            $bookTourId = $orderIds[0]; // Lấy ID đơn đặt tour từ mảng
            $bookTour = BookTour::find($bookTourId); // Tìm đơn đặt tour dựa trên ID
            $eventdate = $bookTour->eventdate;
            $tour = $eventdate->tour;
            $extraServiceArray = [];
        
            // Decode the JSON string from the extra_service_id field of the BookTour model
            $extraServices = json_decode($bookTour->extra_service_id, true);
        
            // Store the decoded extra service information in the array
            $extraServiceArray[$bookTour->id] = $extraServices;
    
            if ($bookTour) {
                Payment::create([
                    'p_booktour_id' => $bookTour->id,
                    'p_total_price' => $bookTour->b_total_price,
                    'p_vnp_response_code' => '00',
                ]);
                if ($bookTour->b_status == 1) {
                    $eventdate->number_registered += $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                    $eventdate->td_follow -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                    $eventdate->save();
                }
                $bookTour->b_status = 3; // 3 là thành công, 5 là thất bại
                $bookTour->save();
                $user = User::find($bookTour->b_user_id);
                $mailuser = $user ? $user->email : $bookTour->b_email;

                Mail::send('emailtt_momo', compact('user', 'bookTour', 'eventdate', 'tour', 'extraServices', 'extraServiceArray'), function ($email) use ($mailuser) {
                    $email->subject('Thanh toán Thành công');
                    $email->to($mailuser);
                });
                // Tiếp tục xử lý và chuyển hướng tới trang thành công
                return redirect()->route('page.home')->with('success', 'Thanh toán thành công!');
            }
        }
    
        // Xử lý lỗi khi không tìm thấy đơn đặt tour hoặc xử lý lỗi khác
        return redirect()->route('page.home')->with('error', 'Có lỗi xảy ra trong quá trình thanh toán!');
    }
    public function ipn(Request $request)
    {
        $orderId = $request->input('orderId'); // Lấy giá trị orderId từ dữ liệu POST
            // Lấy dữ liệu từ thông báo IPN
            $transId = $request->input('transId');
            $errorCode = $request->input('errorCode');
            $message = $request->input('message');
            $localMessage = $request->input('localMessage');
            $payType = $request->input('payType');
            $responseTime = $request->input('responseTime');
        
            // Kiểm tra trạng thái thanh toán
            if ($errorCode == 00) {
                // Thanh toán thành công
                // Cập nhật trạng thái thanh toán trong hệ thống của bạn
                // ...
            } else {
                // Thanh toán thất bại
                // Xử lý lỗi hoặc thông báo cho người dùng
                // ...
            }
        
            // Trả về phản hồi cho MoMo
            return response()->json([
                'status' => 'success'
            ]);
        }
            public function processPaymentMOMO(Request $request)
    {
                
        $orderId = $request->input('booktourId'). "_" . time();
        $b_total_price = $request->input('b_total_price');
        $order = BookTour::find($orderId);
    
        if ($order && ($order->b_status === 3 || $order->b_status === 4)) {
        // Đơn hàng đã có trạng thái 3 (đã thanh toán)
        return "Đơn hàng đã được thanh toán thành công.";
    }
    
                    // Use JavaScript to create and submit a form to initiate a POST request
         return view('page.payment.redirect_to_momo', ['payUrl' => route('momo_payment'), 'b_total_price' => session('b_total_price'), 'orderId' => $orderId]);
                
    }
}