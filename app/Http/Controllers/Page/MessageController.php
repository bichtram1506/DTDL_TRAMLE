<?php
namespace App\Http\Controllers\Page;

use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('page.message.index', compact('messages'));
    }

    public function store(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (Auth::check()) {
            // Lấy thông tin người dùng đăng nhập
            $user = Auth::user();
    
            // Lấy thông tin người nhận từ request hoặc logic của bạn
            $receiverId = $request->input('receiver_id');
    
            // Kiểm tra và lưu tin nhắn vào cơ sở dữ liệu
            $message = new Message;
            $message->message = $request->input('message');
            $message->sender_id = $user->id;
            $message->receiver_id = $receiverId;
            $message->save();
          
        }
        // Lấy danh sách tin nhắn mới nhất
        $messages = Message::orderBy('created_at', 'asc')->get();
       
        // Trả về view 'chatbox' với dữ liệu tin nhắn
        return view('page.message.index', compact('messages'));
    }
    
    
}
