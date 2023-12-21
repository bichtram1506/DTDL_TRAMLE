<?php

namespace App\Http\Controllers\Page\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Region;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\VerificationEmail;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
        //$this->middleware('guest');
    }

    public function register()
    {
        if (Auth::guard('users')->check()) {
            return redirect()->back();
        }

        return view('page.auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
        $existingUser = User::where('email', $request->email)->first();
        
        if ($existingUser) {
            if ($existingUser->email_verified_at !== NULL) {
                // Email đã tồn tại và đã được xác thực, không cho phép đăng ký
                return redirect()->back()->with('error', 'Email đã tồn tại. Vui lòng đăng nhập.');
            } else {
                // Email đã tồn tại nhưng chưa được xác thực, cho phép đăng ký lại và gửi email xác thực mới
                // Gửi email xác thực mới tại đây (tạo mã xác thực mới, gửi email, cập nhật verification_token)
                $existingUser->name = $request->name; // Cập nhật tên mới
                $existingUser->password = bcrypt($request->password);
                $existingUser->phone = $request->phone;
                $existingUser->address = $request->address;
                $existingUser->verification_token = Str::random(40);
                $existingUser->save();
                Mail::send('verification_email', ['user' => $existingUser], function ($email) use ($existingUser) {
                    $email->subject('Xác thực tài khoản');
                    $email->to($existingUser->email);
                });
                
                return redirect()->route('page.home')->with('success', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản.');
            }
        }
    
        // Tiếp tục xử lý đăng ký nếu email chưa tồn tại trong CSDL
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->password = bcrypt($request->password);
        $user->verification_token = Str::random(40);
    
        // Gửi email xác thực cho tài khoản mới
        Mail::send('verification_email', ['user' => $user], function ($email) use ($user) {
            $email->subject('Xác thực tài khoản');
            $email->to($user->email);
        });
    
        \DB::beginTransaction();
        try {
            // Lưu thông tin user vào CSDL
            $user->save();
            \DB::commit();
    
            return redirect()->route('page.home')->with('success', 'Vui lòng kiểm tra email của bạn để xác thực tài khoản.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể đăng ký tài khoản');
        }
    }
    
    

    public function verifyAccount($token)
    {
        // Tìm user với verification_token tương ứng
        $user = User::where('verification_token', $token)->first();
    
        if (!$user) {
            return redirect()->route('page.user.account')->with('error', 'Mã xác thực không hợp lệ.');
        }
    
        // Kiểm tra xem tài khoản đã được xác thực hay chưa
        if ($user->email_verified_at !== null) {
            // Tài khoản đã được xác thực, chuyển hướng đến trang đăng nhập hoặc trang thông báo thành công
            return redirect()->route('page.user.account')->with('success', 'Tài khoản đã được xác thực. Vui lòng đăng nhập.');
        } else {
            // Cập nhật trạng thái xác thực cho user
            $user->email_verified_at = now();
            $user->verification_token = null; // Xóa mã xác thực
            $user->save();
    
            // Đăng nhập user sau khi xác thực thành công
    
            // Chuyển hướng đến trang chủ hoặc trang thông báo thành công
            return redirect()->route('page.home')->with('success', 'Xác thực tài khoản thành công. Vui lòng đăng nhập.');
        }
    }
    
    
    
}
