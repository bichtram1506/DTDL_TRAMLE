<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookHotel;
use App\Models\Hotel;
use App\Models\User;
use App\Models\Room;
use App\Models\Staff;
use Mail;

class BookHotelController extends Controller
{
    public function __construct(BookHotel $bookHotel)
    {
        view()->share([
            'book_hotel_active' => 'active',
            'status' => $bookHotel::STATUS,
            'classStatus' => $bookHotel::CLASS_STATUS,
            'PAYMENT_METHODS' => $bookHotel:: PAYMENT_METHODS,
        ]);
    
        $this->bookHotel = $bookHotel;
    }
    
    public function index(Request $request)
    {
        $bookHotels = BookHotel::with(['user']);
   
        $bookHotels = $bookHotels->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
       
        return view('admin.book_hotel.index', compact('bookHotels', 'request'));
    }
    public function edit($id)
    {
        // Find the BookTour record by ID
        $bookHotel = BookHotel::findOrFail($id);
      // Lấy danh sách tất cả các mã giảm giá
        // Lấy danh sách phòng thuộc về khách sạn
      // Lấy danh sách phòng thuộc về khách sạn của phòng hiện tại
       $rooms = Room::where('rm_hotel_id', $bookHotel->room->rm_hotel_id)->get();
        // Check if the BookTour record exists
        if (!$bookHotel) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    
        return view('admin.book_hotel.edit', compact('bookHotel','rooms'));
    }
    
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            // Lấy bản ghi BookTour cần cập nhật
            $bookHotel = $this->bookHotel->find($id);
    
            if (!$bookHotel) {
                return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
            }
    
            // Cập nhật thông tin BookTour từ request
            $bookHotel->check_in = \Carbon\Carbon::parse($request->input('check_in'));
            $bookHotel->check_out = \Carbon\Carbon::parse($request->input('check_out'));
            $bookHotel->bh_room_id = $request->input('bh_room_id');
            $bookHotel->num_guest = $request->input('num_guest');
    
            // Lấy giá phòng từ bh_room_id
            $room = Room::find($bookHotel->bh_room_id);
            $roomPrice = $room->rm_price;
    
            // Tính số ngày lưu trú
            $checkIn = \Carbon\Carbon::parse($request->input('check_in'));
            $checkOut = \Carbon\Carbon::parse($request->input('check_out'));
            $numDays = $checkOut->diffInDays($checkIn);
    
            // Tính tổng tiền
            $totalPrice = $numDays * $roomPrice;
            $bookHotel->total_price = $totalPrice;
    
            $bookHotel->save();
    
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }

    public function delete($id)
    {
        $bookHotel = BookHotel::find($id);
        if (!$bookHotel) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $bookHotel->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
    public function updateStatus(Request $request, $status, $id)
    {
        $booking = BookHotel::find($id);
    
        \DB::beginTransaction();
        try {
            $booking->status = $status;
            $room= $booking->room;
            $hotel = $room->hotel;
            $user = User::find($booking->bh_user_id);
            // Lấy danh sách tất cả các booking tour liên quan đến eventdat
         
            if ($status == 5) {
            
                $booking->update(['status' => $status]);
            
                        // Gửi email xác nhận booking cho người dùng
                        $user = User::find($booking->bh_user_id);
                          $mailuser = $user ? $user->email : $bookTour->b_email;
                        Mail::send('thongbaohuyhotel', compact('user', 'booking', 'hotel', 'room'), function ($email) use ($mailuser) {
                            $email->subject('Thông báo HỦY Đơn');
                            $email->to($mailuser);
                        });
           
            }
              $booking->save();
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
}
