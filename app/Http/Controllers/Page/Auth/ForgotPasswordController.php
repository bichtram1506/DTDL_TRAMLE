<?php

namespace App\Http\Controllers\Page\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password; 
use Illuminate\Http\Request;
use App\Models\User;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    // Hiển thị form yêu cầu khôi phục mật khẩu
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Xử lý gửi email yêu cầu khôi phục mật khẩu
 // Trong phương thức sendResetLinkEmail của ForgotPasswordController
 public function sendResetLinkEmail(Request $request)
 {
     $this->validateEmail($request);
 
     $user = User::where('email', $request->email)->first();
 
     if (!$user || $user->email_verified_at === null) {
         // Chuyển hướng đến trang đăng ký nếu email không tồn tại trong bảng "users" hoặc chưa được xác nhận
         return redirect()->route('user.register')->with('error', 'Email chưa có tài khoản. Vui lòng đăng ký tài khoản mới.');
     }
 
     $response = Password::broker('users')->sendResetLink(
         $request->only('email')
     );
 
     return $response == Password::RESET_LINK_SENT
         ? back()->with('status', trans($response))
         : back()->withErrors(['email' => trans($response)]);
 }

}
