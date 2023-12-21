<?php


namespace App\Http\Controllers\Page\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password; 
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    
     protected $redirectTo = '/'; // Chuyển hướng đến route có tên 'page.home' sau khi đăng nhập thành công

        protected function guard()
    {
        return Auth::guard('users'); // Sử dụng guard 'users' khi đặt lại mật khẩu
    }
    public function broker()
    {
        return Password::broker('users'); // Sử dụng broker 'users' cho guard 'users'
    }

}
