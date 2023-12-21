<?php

namespace App\Http\Controllers\Page\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {  
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
        //$this->middleware('guest')->except('logout');
        $this->user = $user;
      
    }
    


    public function login()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->back();
        }

        return view('page.auth.login');
    }

   public function postLogin(LoginRequest $request)
{
    $data = $request->except('_token');
    $user = $this->user->getInfoEmail($data['email']);

    if (!$user) {
        return redirect()->back()->with('danger', 'Thông tin tài khoản không tồn tại');
    }

    if ($user->email_verified_at === null) {
        return redirect()->back()->with('danger', 'Tài khoản chưa được xác thực email. Vui lòng kiểm tra email và xác thực tài khoản.');
    }

    if (Auth::guard('users')->attempt($data)) {
        return redirect()->route('page.home');
    }

    return redirect()->back()->with('danger', 'Đăng nhập thất bại.');
}
    public function logout()
    {
        Auth::guard('users')->logout();
        return redirect()->route('page.home');
    }
}
