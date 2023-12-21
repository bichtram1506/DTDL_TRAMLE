<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateInfoAccountRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Models\User;
use App\Models\BookHotel;
use App\Models\Region;
use App\Models\BookTour;
use App\Models\Comment;
use App\Models\QuoteHistory;
use App\Models\EventDate;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;
use App\Models\Favorite;
use Mail;

class AccountController extends Controller
{
    public function __construct(BookTour $bookTour, Tour $tour)
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
            'status' => $bookTour::STATUS,
            'classStatus' => $bookTour::CLASS_STATUS,
            'statustour' => $tour::STATUS,
        ]);
    }
    //
    public function infoAccount()
    {
        $user = Auth::guard('users')->user();
        return view('page.auth.account', compact('user'));
    }

    public function updateInfoAccount(UpdateInfoAccountRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;

            if (isset($request->images) && !empty($request->images)) {
                $image = upload_image('images');
                if ($image['code'] == 1)
                    $user->avatar = $image['name'];
            }

            $user->save();
            \DB::commit();
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể cập nhật tài khoản');
        }
    }

    public function changePassword()
    {
        return view('page.auth.change_password');
    }

    public function postChangePassword(ChangePasswordRequest $request)
    {
        \DB::beginTransaction();
        try {
            $user =  User::find(Auth::guard('users')->user()->id);
            $user->password = bcrypt($request->password);
            $user->save();
            \DB::commit();
            Auth::guard('users')->logout();
            return redirect()->route('page.user.account')->with('success', 'Đổi mật khẩu thành công.');
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể đổi mật khẩu');
        }
    }


  
    public function myTour(Request $request)
    {
        $user = Auth::guard('users')->user();
        
        $status = $request->input('status');
        $orderID = $request->input('id'); // Retrieve the order ID from the request
    
        $bookTours = BookTour::query()
            ->where('b_user_id', $user->id)
            ->when($status, function ($query) use ($status) {
                $query->where('b_status', $status);
            })
            ->when($orderID, function ($query) use ($orderID) {
                $query->where('id', $orderID); // Filter by order ID if provided
            })
            ->orderByDesc('id')
            ->paginate(NUMBER_PAGINATION_PAGE);
        
        return view('page.auth.my_tour', compact('bookTours'));
    }
    
    public function getTourComments(Request $request)
    {
        $user = Auth::guard('users')->user();
        $searchType = $request->input('searchType'); // Loại tìm kiếm (comment, article, tour)
        $keyword = $request->input('keyword'); // Từ khóa tìm kiếm
    
        // Lấy danh sách tất cả các bình luận của người dùng và phân trang
        $userComments = Comment::where('cm_user_id', $user->id)
        ->where(function ($query) use ($searchType) {
            if ($searchType === 'comment') {
                $query->whereNotNull('cm_booktour_id')
                    ->orWhereNotNull('cm_article_id')
                    ->orWhereNotNull('cm_hotel_id')
                    ->orWhereNotNull('cm_tour_id');
            } elseif ($searchType === 'article') {
                $query->whereNotNull('cm_article_id');
            } elseif ($searchType === 'tour') {
                $query->whereNotNull('cm_tour_id');
            } elseif ($searchType === 'hotel') {
                $query->whereNotNull('cm_hotel_id');
            }
        })
        ->when($keyword, function ($query, $keyword) use ($searchType) {
            if ($searchType === 'comment') {
                $query->where('cm_content', 'like', '%' . $keyword . '%');
            } elseif ($searchType === 'article') {
                $query->whereHas('article', function ($query) use ($keyword) {
                    $query->where('a_title', 'like', '%' . $keyword . '%');
                });
            } elseif ($searchType === 'tour') {
                $query->whereHas('tour', function ($query) use ($keyword) {
                    $query->where('t_title', 'like', '%' . $keyword . '%');
                });
            } elseif ($searchType === 'hotel') {
                $query->whereHas('hotel', function ($query) use ($keyword) {
                    $query->where('h_name', 'like', '%' . $keyword . '%');
                });
            }
        })
        ->orderByRaw('cm_rating IS NULL, cm_rating DESC')
        ->paginate(NUMBER_PAGINATION_PAGE);
    
        // Eager loading để tải thông tin chi tiết về tour, article và hotel liên quan
        $userComments->load('tour', 'article', 'hotel');
    
        return view('page.auth.tour_comments', compact('userComments'));
    }
    
        public function getTourComments1(Request $request)
    {
        $user = Auth::guard('users')->user();

        $bookTours = BookTour::with(['tour.comments'])
            ->where('b_user_id', $user->id)
            ->where('b_status', 4)
            ->where(function ($query) {
                $query->whereHas('tour.comments', function ($query) {
                    $query->whereNotNull('cm_rating');
                })
                ->orWhereHas('tour.comments', function ($query) {
                    $query->whereNull('cm_rating');
                });
            })
            ->orderByDesc('id')
            ->get();

        return view('page.common.popup', compact('bookTours'));
    }
            public function getTourComments2(Request $request)
        {
            $user = Auth::guard('users')->user();

            $bookTours = BookTour::with(['tour.comments'])
                ->where('b_user_id', $user->id)
                ->where('b_status', 4)
                ->where(function ($query) {
                    $query->whereHas('tour.comments', function ($query) {
                        $query->whereNotNull('cm_rating');
                    })
                    ->orWhereHas('tour.comments', function ($query) {
                        $query->whereNull('cm_rating');
                    });
                })
                ->orderByDesc('id')
                ->get();

            return view('page.layouts.page', compact('bookTours'));
        }

        public function index()
        {
            $bookTours = BookTour::all(); // Lấy danh sách các tour đã đặt
            
            return view('page.layouts.page', compact('bookTours'));
        }
  public function cancelTour($id)
    {
        \DB::beginTransaction();
        try {
            
            \DB::commit();

            return response([
                'status_code' => 200,
                'message' => 'Hủy Tour thành công',
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            $code = 404;
            return response([
                'status_code' => $code,
                'message' => 'Không thể hủy Tour',
            ]);
        }
    }

    public function updateStatus(Request $request, $status, $id)
    {
        $bookTour = BookTour::find($id);
    
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    
        $numberUser = $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
    
        \DB::beginTransaction();
        try {
            if ($status != $bookTour->b_status) {
                $bookTour->b_status = $status;
                $bookTour->save();
    
                if ($status == 5) {
                    $eventdate = $bookTour->eventdate; // Lấy eventdate từ booktour
                    if ($eventdate) {
                        $tour = $eventdate->tour;
                        $eventdate->td_follow -= $numberUser;
                        $eventdate->save();
                    }
                }
    
                $user = User::find($bookTour->b_user_id);
                $mailuser = $user->email;
    
                Mail::send('emailhuy', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                    $email->subject('Xác nhận HUỶ BOOKING');
                    $email->to($mailuser);
                });
    
                \DB::commit();
    
                return response([
                    'status_code' => 200,
                    'message' => 'Hủy Tour thành công',
                ]);
            } else {
                return redirect()->back()->with('error', 'Trạng thái đã tồn tại');
            }
        } catch (\Exception $exception) {
            \DB::rollBack();
            $code = 404;
            return response([
                'status_code' => $code,
                'message' => 'Không thể hủy Tour',
            ]);
        }
    }

    
        public function getTourFavorites(Request $request)
        {
            $user = Auth::guard('users')->user();
            
            // Check if the user is logged in
            if ($user) {
                // Retrieve the list of favorite tours for the user
                $favoriteTours = $user->favorites()->get();
        
                // Return a view to display the list of favorite tours
                return view('page.auth.tour_favorites', compact('favoriteTours'));
            }
        }
    
        public function getTourRequires(Request $request)
        {
            $user = Auth::guard('users')->user();
            
            // Check if the user is logged in
            if ($user) {
                // Retrieve the list of favorite tours for the user
                $requireTours = $user->tours()->get();
        
                // Return a view to display the list of favorite tours
                return view('page.auth.tour_require', compact('requireTours'));
            }
        }

                public function deleteFavorite($id)
        {
            $user = auth()->guard('users')->user();

            if ($user) {
                // Tìm tour yêu thích cần xóa
                $favoriteTour = $user->favorites()->find($id);

                if ($favoriteTour) {
                    // Xóa tour yêu thích
                    $user->favorites()->detach($id);

                    // Redirect hoặc thực hiện các xử lý khác sau khi xóa
                    return redirect()->back()->with('success', 'Tour đã được xóa khỏi danh sách yêu thích.');
                }
            }

            return redirect()->back()->with('error', 'Không thể xóa tour yêu thích.');
        }


            public function getNotifications(Request $request)
            {
                // Lấy người dùng hiện tại, ví dụ: sử dụng Auth
                $user = Auth::guard('users')->user();

                // Kiểm tra xem người dùng có tồn tại không
                if ($user) {
                    // Truy vấn cơ sở dữ liệu để lấy danh sách các đơn có trạng thái là 3 và thuộc về người dùng
                    // Kết nối bảng 'book_tours' với 'eventdates' và sau đó kết nối 'eventdates' với 'tours'
                    $notifications = DB::table('book_tours')->get();

                    return response()->json($notifications);
                }

                return response()->json([]);
            }

            public function processAction($id, Request $request)
            {
                // Tìm báo giá theo ID
                $quote = QuoteHistory::find($id);
            
                // Lấy giá trị 'action' từ request
                $action = $request->input('action');
            
                // Xử lý duyệt hoặc từ chối
                if ($action == 'approve') {
                    $quote->status = 1; // 1 là trạng thái duyệt
                    $quote->save();
            
                    // Cập nhật giá trị 't_status' là 4 cho tour từ bảng QuoteHistory
                    $tour = $quote->tour;
                    $tour->t_status = 4;
                    $tour->save();
                   $eventdate = $tour->eventdate->first();
                   $bookTour = $eventdate->bookTour->first();
                    // Lấy thông tin người dùng từ bảng User
                    $userId = $bookTour->b_user_id;
                    $user = User::find($userId);
                    $mailUser = $user ? $user->email : $bookTour->b_email;
                    $mailUser = $mailUser ?? $bookTour->b_email;
                    // Lấy eventdate đầu tiên của tour
                 
            
                    // Gửi email thông báo việc hoàn thành tour
                    Mail::send('email_tour_complete', compact('user', 'tour', 'eventdate','bookTour'), function ($email) use ($mailUser, $tour) {
                        $email->subject('Thông báo bạn đã duyệt báo giá Tour ' . $tour->t_code . ' - ' . $tour->t_title . ' thành công');
                        $email->to($mailUser);
                    });
                    if ($bookTour->b_status == 1) {
                        // Lặp qua từng chi tiết đặt tour trong $bookTourDetails
                      
                            // Tính toán tổng số người đặt trong chi tiết này
                            $totalPeople = $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                    
                            // Lấy thông tin về tour từ chi tiết đặt tour
                            $tour = $bookTour->eventdate->tour;
                    
                            // Cập nhật thông tin của EventDate dựa trên số người đặt
                            $eventdate = $bookTour->eventdate;
                           
                            $eventdate->number_registered += $totalPeople;
                        
                            $eventdate->td_follow -= $totalPeople;
                            $bookTour->b_status = 2;
                            $bookTour->save();
                            $eventdate->save();
                            
                            // Gửi email xác nhận booking cho người dùng
                            $user = User::find($bookTour->b_user_id);
                            $mailuser = $user ? $user->email : $bookTour->b_email;
                            Mail::send('email', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                                $email->subject('Xác nhận Booking');
                                $email->to($mailuser);
                            });
                    
                    }
                    return redirect()->back()->with('success', 'Duyệt báo giá thành công và gửi email thông báo hoàn thành tour');
                } elseif ($action == 'reject') {
                    // Xử lý từ chối
                    $quote->status = 2; // 2 là trạng thái từ chối
            
                    // Lấy lý do từ request và lưu vào cột "reason"
                    $reason = $request->input('reason');
                    $quote->reason = $reason;
            
                    $quote->save();
            
                    return redirect()->back()->with('success', 'Từ chối báo giá thành công');
                }
            
                return redirect()->back()->with('error', 'Hành động không hợp lệ');
            }

            
            public function myHotel(Request $request)
            {
                $user = Auth::guard('users')->user(); // Lấy thông tin người dùng đã đăng nhập

                $bookings = BookHotel::with('room','user') // Sử dụng 'room' và 'user' để lấy thông tin phòng và người dùng
                ->where('bh_user_id', $user->id)
                ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo giảm dần
                ->paginate(NUMBER_PAGINATION_PAGE);// Sử dụng paginate để phân trang
                return view('page.auth.my_hotel', compact( 'bookings'));
            }

            public function updateStatusHotel(Request $request, $status, $id)
            {
                $booking = BookHotel::find($id);
            
                if (!$booking) {
                    return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
                }
            
                \DB::beginTransaction();
            
                try {
                    if ($status != $booking->status) {
                        $booking->status = $status;
                        $booking->save();
            
                        $room = $booking->room;
                        $hotel = $room->hotel;
                        $user = User::find($booking->bh_user_id);
                        
                        $mailuser = $user->email;
            
                        Mail::send('thongbaohuyhotel', compact('user', 'booking', 'hotel', 'room'), function ($email) use ($mailuser) {
                            $email->subject('Thông báo HỦY Đơn');
                            $email->to($mailuser);
                        });
            
                        \DB::commit();
            
                        return response([
                            'status_code' => 200,
                            'message' => 'Hủy Đơn thành công',
                        ]);
                    } else {
                        \DB::rollBack();
            
                        return redirect()->back()->with('error', 'Trạng thái đã tồn tại');
                    }
                } catch (\Exception $exception) {
                    \DB::rollBack();
                    $code = 404;
            
                    return response([
                        'status_code' => $code,
                        'message' => 'Không thể hủy đơn',
                    ]);
                }
            }
            
            
    
            public function cancelHotel($id)
            {
                \DB::beginTransaction();
                try {
                    
                    \DB::commit();
        
                    return response([
                        'status_code' => 200,
                        'message' => 'Hủy đơn thành công',
                    ]);
                } catch (\Exception $exception) {
                    \DB::rollBack();
                    $code = 404;
                    return response([
                        'status_code' => $code,
                        'message' => 'Không thể hủy đơn',
                    ]);
                }
            }

          
            public function requestQuote($tourId) {
                // Tìm tour dựa trên $tourId
                $tour = Tour::findOrFail($tourId);
        
                                // Lấy danh sách các location_id từ bảng trung gian tour_location
                $locationIds = $tour->locations()->pluck('locations.id')->toArray();

                // Tìm các tour có chứa các location giống với tour hiện tại và t_type là 0
                $toursWithLocation = Tour::where('t_type', 0)
                    ->whereHas('locations', function ($query) use ($locationIds) {
                        $query->whereIn('locations.id', $locationIds);
                    })
                    ->get();
                    if ($toursWithLocation->isEmpty()) {
                        return redirect()->back()->with('error', 'Không có báo giá cho tour này.');
                    }
                        $totalPrice = $toursWithLocation->sum('t_price_adults');
                        $totalPrice_child = $toursWithLocation->sum('t_price_children');
                    // Tăng số tour chứa điểm đến
                      $totalTours = $toursWithLocation->count();

                        $averagePrice = $totalPrice / $totalTours;
                        $averagePrice_child = $totalPrice_child / $totalTours;
                        $eventdate = $tour->eventdate->first();
                        $bookTour = $eventdate->bookTour->first();
                        $userId = $bookTour->b_user_id;
                        $user = User::find($userId);
                        $mailUser = $user->email;
                        // Tiếp tục xử lý yêu cầu báo giá và sử dụng giá trung bình trong quá trình này
                        $quote = new QuoteHistory();
                        $quote->tour_id = $tour->id;
                        $quote->adult_price = $averagePrice;
                        $quote->child_price = $averagePrice_child;
                        $quote->save();
                        // Tiếp tục xử lý yêu cầu báo giá và sử dụng giá trung bình trong quá trình này
                        // ...
                        Mail::send('emailbaogiacoban', compact('user', 'tour', 'bookTour', 'eventdate','averagePrice','averagePrice_child'), function ($email) use ($mailUser) {
                            $email->subject('Yêu cầu báo giá');
                            $email->to($mailUser);
                        });
                        // Chuyển hướng ngược trở lại trang trước và gửi thông báo thành công
                        return redirect()->back()->with('success', 'Đã yêu cầu báo giá. Vui lòng kiểm tra email để xem báo giá.');
                    }
            
            
}
