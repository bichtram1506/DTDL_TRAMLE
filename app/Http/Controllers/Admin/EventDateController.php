<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Eventdate;
use App\Models\User;
use App\Models\Staff;
use App\Models\BookTour;
use Illuminate\Support\Facades\Mail;
use App\Models\Tour;
use App\Http\Requests\EventDateRequest;
class EventDateController extends Controller
{
    protected $eventdate;

    public function __construct(EventDate $eventdate ,BookTour $bookTour)
    {
    

        view()->share([
            'eventdate_active' => 'active',
            'status' => $eventdate::STATUS,
            'classStatus' => $eventdate::CLASS_STATUS,
            'statusbook' => $bookTour::STATUS,
            'classStatusbook' => $bookTour::CLASS_STATUS,
        ]);
          $this->eventdate = $eventdate;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getBookedDates($tourId)
    {
        // Sử dụng Eloquent để truy vấn các ngày từ mô hình EventDate với điều kiện tourId
        $bookedDates = EventDate::where('td_tour_id', $tourId)->pluck('td_start_date')->toArray();
    
        return $bookedDates;
    }
    
    public function index(Request $request)
    {
        $eventdates = EventDate::with('tour');
        $tourList = Tour::get();
        $id = $request->input('tour_id'); // Thêm dòng này để lấy giá trị của $id từ request
          // Xử lý tham số "Lọc lịch khởi hành trong tương lai"
       
          $futureDays = $request->input('future_days', 0);
          // Giá trị mặc định là 0 (Tất cả) // Giá trị mặc định là null nếu không có giá trị nào được chọn
       
          $bookedDates = $this->getBookedDates($id);
          if ($request->td_status !== null) {
            $eventdates->where('td_status', $request->td_status);
        }
        
        if ($request->t_title) {
            $eventdates->whereHas('tour', function ($query) use ($request) {
                $query->where('t_title', 'like', '%' . $request->t_title . '%');
            });
        }
        
        if ($request->td_start_date) {
            $eventdates->whereDate('td_start_date', $request->td_start_date);
        }
        
        if ($futureDays > 0) {
            $startDate = now(); // Lấy ngày hiện tại
            $startDate->addDays($futureDays); // Thêm số ngày tương lai
            $eventdates->whereDate('td_start_date', $startDate);
        }
        
        $staffs = Staff::whereHas('roles', function ($query) {
            $query->where('role_id', 12);
        })->get();
        $eventdates = $eventdates->orderByDesc('id')->paginate(NUMBER_PAGINATION);
    
        return view('admin.eventdate.index', compact('eventdates', 'tourList','request','futureDays','staffs','bookedDates'));
    }
    
    public function show_tourguide(Request $request)
    {
        $user = Auth::user();
        $eventdates = EventDate::with('tour')->where('td_guide_id', $user->id);
        $tourList = Tour::get();
          // Xử lý tham số "Lọc lịch khởi hành trong tương lai"
       
          $futureDays = $request->input('future_days', 0);
          // Giá trị mặc định là 0 (Tất cả) // Giá trị mặc định là null nếu không có giá trị nào được chọn
       

        if ($request->td_status) {
            $eventdates->where('td_status', $request->td_status);
        }
        if ($request->t_title) {
            $eventdates->whereHas('tour', function ($query) use ($request) {
                $query->where('t_title', 'like', '%' . $request->t_title . '%');
            });
        }
        
        if ($request->td_start_date) {
            $eventdates->whereDate('td_start_date', $request->td_start_date);
        }
        if ($futureDays > 0) {
            $startDate = now(); // Lấy ngày hiện tại
            $startDate->addDays($futureDays); // Thêm số ngày tương lai
            $eventdates->whereDate('td_start_date', $startDate);
        }
        
        
        $eventdates = $eventdates->orderByDesc('id')->paginate(NUMBER_PAGINATION);
    
        return view('admin.eventdate.index', compact('eventdates', 'tourList','request','futureDays'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventDateRequest $request)
    {
        \DB::beginTransaction();
        try {
            $eventdate = new EventDate();
            $eventdate->createOrUpdate($request);
            
            \DB::commit();
            return redirect()->back()->with('success', 'Sự kiện đã được tạo thành công.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi tạo sự kiện.');
        }
    }
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(EventDateRequest $request, $id)
{
    \DB::beginTransaction();
    try {
        // Lấy tour hiện tại
        $eventDate = EventDate::findOrFail($id);
        
        // Chuyển đổi chuỗi ngày tháng từ request thành timestamp
        $newStartDate = strtotime($request->td_start_date);
        
        // Kiểm tra xem td_start_date có bị trùng lặp với các tour khác hay không
        $existingEventDate = EventDate::where('td_tour_id', $eventDate->td_tour_id)
            ->where(\DB::raw('DATE(td_start_date)'), date('Y-m-d', $newStartDate))
            ->where('id', '!=', $id)
            ->first();
        
        if ($existingEventDate) {
            return redirect()->back()->with('error', 'Ngày khởi hành đã bị trùng lặp');
        }
        
        $this->eventdate->createOrUpdate($request, $id);
        \DB::commit();

        return redirect()->back()->with('success', 'Chỉnh sửa dữ liệu thành công');
    } catch (\Exception $exception) {
        \DB::rollBack();
        dd($exception);
        return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
    }
}
        public function getUsersByEvent($eventDateId)
        {
            $eventDate = EventDate::find($eventDateId);

            if (!$eventDate) {
                return response()->json(['error' => 'Sự kiện không tồn tại'], 404);
            }
                // Lấy danh sách đơn đặt tour mà không có user id
                $bookTours = BookTour::where('b_tourdetail_id', $eventDate->id)
                ->whereDoesntHave('user')
                ->get();
    // Lấy danh sách người dùng và danh sách đơn đặt tour của mỗi người dùng (đơn có b_status từ 2 đến 4)
$users = User::whereHas('bookTours', function ($query) use ($eventDate) {
    $query->where('b_tourdetail_id', $eventDate->id)
        ->whereBetween('b_status', [2, 4]);
})->with(['bookTours' => function ($query) use ($eventDate) {
    $query->where('b_tourdetail_id', $eventDate->id)
        ->whereBetween('b_status', [2, 4]);
}])->get();

            // Truyền danh sách người dùng và danh sách đơn đặt tour của mỗi người dùng vào view
            return view('admin.eventdate.popup', compact('users','bookTours'));
        }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $eventdate = EventDate::find($id);
        if (!$eventdate) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $eventdate->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
    public function updateStatus(Request $request, $status, $id)
    {
        $eventdate = EventDate::find($id);
        if (!$eventdate) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    
        \DB::beginTransaction();
        try {
            $eventdate->td_status = $status;
            $eventdate->save();
            $tour = $eventdate->tour;
            
            // Lấy danh sách tất cả các booking tour liên quan đến eventdate
            $bookTours = $eventdate->bookTour;
            if ($status == 2) {
                $bookTours->each(function ($bookTour) use ($eventdate, $tour) {
                    if ($bookTour->b_status == 3) {
                        // Gửi email thông báo tour đang chuẩn bị và yêu cầu khách hàng đến trước cho chuyến đi
                        $user = User::find($bookTour->b_user_id);
                        $mailuser = $user ? $user->email : $bookTour->b_email;
                        Mail::send('emailnhacnho', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                            $email->subject('Nhắc nhở: Chuyến đi sắp tới');
                            $email->to($mailuser);
                        });
                    }
                });
            }
            // Cập nhật trạng thái b_status của tất cả các booking tour thành 4
            if ($status == 4) {
                // Cập nhật trạng thái b_status của các đơn đặt tour có b_status là 3 thành 4
            $bookTours->each(function ($bookTour) use ($eventdate, $tour) {
                if ($bookTour->b_status == 3) {
                    $bookTour->update(['b_status' => 4]);

                    // Gửi email xác nhận booking cho người dùng
                    $user = User::find($bookTour->b_user_id);
                    $mailuser = $user ? $user->email : $bookTour->b_email;
                    Mail::send('emailhoanthanh', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                        $email->subject('Khảo Sát và Khuyến Mãi Sau Tour');
                        $email->to($mailuser);
                    });
                }
            });
            }
            if ($status == 5) {
               // Cập nhật trạng thái b_status của các đơn đặt tour có b_status là 2 hoặc 3 thành 5
                $bookTours->each(function ($bookTour) use ($eventdate, $tour) {
                    if ($bookTour->b_status == 2 || $bookTour->b_status == 3 || $bookTour->b_status == 1) {
                        $bookTour->update(['b_status' => 5]);

                        // Gửi email xác nhận hủy tour cho người dùng
                        $user = User::find($bookTour->b_user_id);
                        $mailuser = $user ? $user->email : $bookTour->b_email;
                        Mail::send('thongbaohuytour', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                            $email->subject('Thông báo HỦY TOUR');
                            $email->to($mailuser);
                        });
                    }
                });
             }
            
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }

    
    
}
