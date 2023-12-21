<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\HotelType;
use App\Models\User;
use App\Models\Location;
use App\Models\BookHotel;
use App\Models\Room;
use Carbon\Carbon;
use Mail;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
class HotelController extends Controller
{
    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
    }
    //
    public function index(Request $request)
    {
        $locations = Location::all();
        $filteredHotels = Hotel::with('rooms');
        $hoteltypes = HotelType::get();
        if ($request->key_hotel) {
            $filteredHotels->where('h_name', 'like', '%' . $request->key_hotel . '%');
        }
    
        if ($request->location_id) {
            $filteredHotels->where('h_location_id', $request->location_id);
        }
       
        if ($request->hoteltype_id) {
            $filteredHotels = $filteredHotels->where('h_hoteltype_id', $request->hoteltype_id);
        }
        if ($request->price) {
            $price = explode('-', $request->price);
            $filteredHotels->whereBetween('h_price', [$price[0], $price[1]]);
        }
    
        if ($request->has('check_in') && $request->has('check_out')) {
            $checkinDate = $request->input('check_in');
            $checkoutDate = $request->input('check_out');
            
            if ($checkinDate && $checkoutDate) {
                $filteredHotels->whereHas('rooms', function ($query) use ($checkinDate, $checkoutDate) {
                    $query->whereDoesntHave('bookings', function ($query) use ($checkinDate, $checkoutDate) {
                        $query->where(function ($query) use ($checkinDate, $checkoutDate) {
                            $query->whereBetween('check_in', [$checkinDate, $checkoutDate])
                                ->orWhereBetween('check_out', [$checkinDate, $checkoutDate]);
                        });
                    });
                });
            }
        }
    
        $filteredHotels = $filteredHotels->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
        
        // Tính toán số lượng phòng còn trống
     
        // Kiểm tra xem đã có tìm kiếm được thực hiện hay chưa
        $isSearching = ($request->key_hotel || $request->location_id || $request->price || ($request->has('check_in') && $request->has('check_out')));

        return view('page.hotel.index', compact('filteredHotels', 'locations', 'isSearching','hoteltypes'));
    }

    public function detail(Request $request, $id)
    {
        $hotel = Hotel::with(['comments' => function($query) use ($id){
            $query->where('cm_hotel_id', $id)->whereIn('cm_status', [1, 2])->limit(20)->orderByDesc('id');
        }])->find($id);
        
        if (!$hotel) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
// Lấy danh sách các phòng thuộc về khách sạn
        $rooms = $hotel->rooms()->get();
        $hotels = Hotel::where(['h_location_id' => $hotel->h_locationn_id])->where('id', '<>', $id)->active()->orderByDesc('id')->limit(NUMBER_PAGINATION_PAGE)->get();
        return view('page.hotel.detail', compact('hotel', 'hotels','rooms'));
    }


    public function bookRoom(Request $request, $id, $slug)
    {
       
        if (!Auth::guard('users')->check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt tour');
        }
    
        $hotel = Hotel::find($id);
    
        $user = User::find(Auth::guard('users')->user()->id);
        // Lấy danh sách phòng thuộc về khách sạn
        $rooms = $hotel->rooms;


    
        return view('page.hotel.book', compact('rooms' ,'user','hotel'));
    }
    public function filterRooms(Request $request)
    {
        $checkInDate = $request->input('check_in');
        $checkOutDate = $request->input('check_out');
        $hotelId = $request->input('rm_hotel_id');
    
        // Lọc danh sách phòng dựa trên ngày nhận phòng và ngày trả phòng của khách sạn
        $filteredRooms = Room::where('rm_hotel_id', $hotelId)
            ->whereDoesntHave('bookings', function ($query) use ($checkInDate, $checkOutDate) {
                $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                    $q->whereBetween('check_in', [$checkInDate, $checkOutDate])
                        ->orWhereBetween('check_out', [$checkInDate, $checkOutDate])
                        ->orWhere(function ($qq) use ($checkInDate, $checkOutDate) {
                            $qq->where('check_in', '<=', $checkInDate)
                                ->where('check_out', '>=', $checkOutDate);
                        });
                });
            })->get();
    
        // Trả về danh sách phòng đã lọc dưới dạng JSON
        return response()->json(['rooms' => $filteredRooms]);
    }
    public function getAvailableRooms(Request $request)
    {
        $checkInDate = $request->input('check_in');
        $checkOutDate = $request->input('check_out');
        
        // Lấy danh sách phòng khách sạn có sẵn dựa trên ngày nhận và ngày trả
        $availableRooms = Room::whereDoesntHave('bookings', function ($query) use ($checkInDate, $checkOutDate) {
            $query->where(function ($q) use ($checkInDate, $checkOutDate) {
                $q->where('check_in', '<=', $checkInDate)
                  ->where('check_out', '>', $checkInDate);
            })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                $q->where('check_in', '<', $checkOutDate)
                  ->where('check_out', '>=', $checkOutDate);
            })->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                $q->where('check_in', '>=', $checkInDate)
                  ->where('check_out', '<=', $checkOutDate);
            });
        })->get();
        
        // Trả về danh sách phòng khách sạn có sẵn dưới dạng JSON
        return response()->json($availableRooms);
    }

    public function postBookRoom(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'num_guest' => 'required|integer',
        ]);
    
        // Get the authenticated user
        $user = Auth::guard('users')->user();
    
        // Get the room
        $room = Room::find($request->input('bh_room_id'));
        $hotel = $room->hotel;
        if (!$room) {
            // Handle the case when the room is not found
            return redirect()->back()->with('error', 'Room not found.');
        }
    
        // Calculate the total price
        $checkInDate = Carbon::parse($request->input('check_in'));
        $checkOutDate = Carbon::parse($request->input('check_out'));
        $pricePerNight = $room->rm_price;
        $diff = $checkInDate->diff($checkOutDate);
        $totalPrice = $pricePerNight * $diff->days;
    
        // Create a booking
      // Trong hàm postBookRoom
        $booking = new BookHotel();
        $booking->bh_user_id = $user->id;
        $booking->bh_room_id = $room->id;
        $booking->check_in = $checkInDate;
        $booking->check_out = $checkOutDate;
        $booking->status = 1;
        // Tính toán lại tổng giá tiền dựa trên giá phòng và số ngày thuê
        $pricePerNight = $room->rm_price;
        $diff = $checkInDate->diff($checkOutDate);
        $totalPrice = $pricePerNight * $diff->days;

        $booking->total_price = $totalPrice;
        $booking->num_guest = $request->input('num_guest');
        $booking->bh_payment_method = $request->input('bh_payment_method'); 
        $booking->save();
        $mail = $user->email;
        Mail::send('emailtn_hotel', compact('hotel', 'room','booking', 'user'), function ($email) use ($mail) {
            $email->subject('Xác Nhận Đặt Phòng');
            $email->to($mail);
        });
    
        // Redirect with success message
        return redirect()->route('page.home')->with('success', 'Thank you for booking. We will contact you soon for confirmation.');
    }
    
    
    public function bookTour()
    {
        return view('page.tour.book');
    }
    public function Roomdetail(Request $request, $id)
    {
        $room = Room::find($id);
      // Lấy thông tin về khách sạn từ phòng
    // Lấy ID khách sạn từ phòng
  // Lấy thông tin về khách sạn từ phòng
       $hotel = $room->hotel;
        if (!$room) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
// Lấy danh sách các phòng thuộc về khách sạn
        return view('page.hotel.room.detail', compact('room','hotel'));
    }

}
