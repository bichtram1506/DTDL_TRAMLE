<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Tour;
use App\Models\Staff;
use App\Models\Hotel;
use App\Models\BookTour;
use App\Models\Location;
use App\Models\Attraction;
use App\Models\QuoteHistory;
use App\Models\User;
use App\Models\Service;
use App\Models\EventDate;
use App\Models\TourImage;
use App\Models\Vehicle;
use App\Models\TourType;
use App\Models\TourItinerarie;
use App\Http\Requests\TourRequest;
use Mail;
class TourController extends Controller
{
    //
    protected $tour;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(Tour $tour, EventDate $eventdate, QuoteHistory $quote, TourType $tourtype)
    {
        view()->share([
            'tour_active' => 'active',
            'status' => $tour::STATUS,
            'status_quote' => $quote::STATUS,
            'statusevent' => $eventdate::STATUS,
            'classStatus' => $eventdate::CLASS_STATUS,
            'tourtypes' => $tourtype->get(),
        ]);
        $this->tour = $tour;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $tours = Tour::with('eventdate', 'tourtype');
        $tourType = TourType::get();
        if ($request->t_title) {
            $tours->where('t_title', 'like', '%' . $request->t_title . '%');
        }
    
        if ($request->td_start_date) {
            $tours->whereHas('eventdate', function ($query) use ($request) {
                $query->where('td_start_date', '=', $request->td_start_date);
            });
        }
    
        if ($request->tt_name) {
            $tours->whereHas('tourtype', function ($query) use ($request) {
                $query->where('tt_name', 'like', '%' . $request->tt_name . '%');
            });
        }
        
        if ($request->t_code) {
            // Add a condition to filter by t_code
            $tours->where('t_code', 'like', '%' . $request->t_code . '%');
        }
        if ($request->t_type !== null) {
            if ($request->t_type == 0 || $request->t_type == 1) {
                $tours->where('t_type', $request->t_type);
            }
        }
        if ($request->has('is_quoted')) {
            if ($request->is_quoted == 1) {
                $tours->whereHas('quoteHistory', function ($query) {
                    $query->where('status_admin', 0);
                })->where('t_type', 1);
            } else {
                $tours->whereDoesntHave('quoteHistory', function ($query) {
                    $query->where('status_admin', 0);
                })->where('t_type', 1);
            }
        }
        if ($request->has('is_quoted')) {
            if ($request->is_quoted == 1) {
            $tours->where(function ($query) {
        $query->whereHas('quoteHistory', function ($query) {
            $query->where('status_admin', 0);
        })->orWhereDoesntHave('quoteHistory');
    })->where('t_type', 1);
            } else {
                $tours->whereHas('quoteHistory', function ($query) {
                    $query->where('status_admin', 1);
                })->where('t_type', 1);
            }
        }
    
        $tours = $tours->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.tour.index', compact('tours', 'tourType'));
    }
    public function index0(Request $request)
    {
        
        $tours = Tour::with('eventdate', 'tourtype')->where('t_type', 0);;
        $tourType = TourType::get();
        if ($request->t_title) {
            $tours->where('t_title', 'like', '%' . $request->t_title . '%');
        }
    
        if ($request->td_start_date) {
            $tours->whereHas('eventdate', function ($query) use ($request) {
                $query->where('td_start_date', '=', $request->td_start_date);
            });
        }
    
        if ($request->tt_name) {
            $tours->whereHas('tourtype', function ($query) use ($request) {
                $query->where('tt_name', 'like', '%' . $request->tt_name . '%');
            });
        }
        
        if ($request->t_code) {
            // Add a condition to filter by t_code
            $tours->where('t_code', 'like', '%' . $request->t_code . '%');
        }
        if ($request->t_type !== null) {
            if ($request->t_type == 0 || $request->t_type == 1) {
                $tours->where('t_type', $request->t_type);
            }
        }
        
    
        $tours = $tours->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.tour.index', compact('tours', 'tourType'));
    }
    public function index1(Request $request)
    {
        
        $tours = Tour::with('eventdate', 'tourtype')->where('t_type', 1);
        $tourType = TourType::get();
        if ($request->t_title) {
            $tours->where('t_title', 'like', '%' . $request->t_title . '%');
        }
    
        if ($request->td_start_date) {
            $tours->whereHas('eventdate', function ($query) use ($request) {
                $query->where('td_start_date', '=', $request->td_start_date);
            });
        }
    
        if ($request->tt_name) {
            $tours->whereHas('tourtype', function ($query) use ($request) {
                $query->where('tt_name', 'like', '%' . $request->tt_name . '%');
            });
        }
        
        if ($request->t_code) {
            // Add a condition to filter by t_code
            $tours->where('t_code', 'like', '%' . $request->t_code . '%');
        }
        if ($request->t_type !== null) {
            if ($request->t_type == 0 || $request->t_type == 1) {
                $tours->where('t_type', $request->t_type);
            }
        }
        
        if ($request->has('is_quoted')) {
            if ($request->is_quoted == 1) {
            $tours->where(function ($query) {
        $query->whereHas('quoteHistory', function ($query) {
            $query->where('status_admin', 0);
        })->orWhereDoesntHave('quoteHistory');
    })->where('t_type', 1);
            } else {
                $tours->whereHas('quoteHistory', function ($query) {
                    $query->where('status_admin', 1);
                })->where('t_type', 1);
            }
        }
        $tours = $tours->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.tour.index', compact('tours', 'tourType'));
    }
    
    public function showEventDate($id)
    {
        // Lấy thông tin chi tiết tour từ cơ sở dữ liệu
        $tour = Tour::findOrFail($id);
        $staffs = Staff::all();
        // Lấy danh sách các eventdate thuộc về tour
        $eventDates = EventDate::where('td_tour_id', $id)->get();
        $tourImages = TourImage::where('tm_tour_id', $id)->get();
        $touritineraries = TourItinerarie::where('ti_tour_id', $id)->get();
        $bookedDates = $this->getBookedDates($id);
        // Thay thế hàm này bằng phương thức lấy danh sách ngày đã đặt của bạn

        // Chuẩn bị mảng $status để sử dụng trong view
        $status = [
            0 => 'Chưa duyệt',
            1 => 'Khởi tạo',
            2 => 'Đang chuẩn bị',
            3 => 'Đang diễn ra',
            4 => 'Đã hoàn tất',
            5 => 'Đã hủy'
        ];
        
        // Chuẩn bị mảng $classStatus để sử dụng trong view
        $classStatus = [
            0 => 'btn-info',
            1 => 'btn-info',
            2 => 'btn-success',
            3 => 'btn-warning',
            4 => 'btn-primary', // Change key 4 to a different class
            5 => 'btn-danger',
        ];
        
        
        // Trả về view hiển thị danh sách các eventdate thuộc về tour
        return view('admin.tour.eventdate.index', compact('tour', 'eventDates', 'status', 'classStatus','touritineraries','tourImages','bookedDates','staffs'));
    }
    private function getBookedDates($tourId)
    {
        // Sử dụng Eloquent để truy vấn các ngày từ mô hình EventDate với điều kiện tourId
        $bookedDates = EventDate::where('td_tour_id', $tourId)->pluck('td_start_date')->toArray();
    
        return $bookedDates;
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::with('hotels','attractions')->get();
        $hotels = Hotel::all();
        $attractions = Attraction::all();
        $locations = Location::all(); 
        $vehicles = Vehicle::all();
        $services = Service::where('type', 1)->get();
        $extra_services = Service::where('type', 2)->get();
        // Đảm bảo rằng biến $tour đã được khởi tạo và gán giá trị mặc định (có thể là null) trước khi truyền vào view.
        $tour = null;
    
        return view('admin.tour.create', compact('hotels', 'locations', 'vehicles', 'services', 'tour','attractions','extra_services'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TourRequest $request)
    {
        \DB::beginTransaction();
        try {
            $tour = $this->tour->createOrUpdate($request);
    
            // Create tour itineraries
            $itineraryData = [];
            for ($i = 1; $i <= $tour->t_day; $i++) {
                $itineraryData[] = [
                    'ti_day' => $i,
                    'ti_content' => $request->input('ti_content_'.$i),
                    'ti_description' => $request->input('ti_description_'.$i),
                    'ti_tour_id' => $tour->id,
                ];
            }
    
            TourItinerarie::insert($itineraryData);
    
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
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
        $tour = Tour::findOrFail($id);
        $hotels = Hotel::all();
        $staffs = Staff::whereHas('roles', function ($query) {
            $query->where('role_id', 12);
        })->get();
        $locations = Location::all();
        $users = User::all();
        $types = TourType::all();
        $attractions = Attraction::all();
        $vehicles = Vehicle::all(); 
        $services = Service::where('type', 1)->get();
        $extra_services = Service::where('type', 2)->get();
        $quoteHistory = $tour->quoteHistory;
        $bookedDates = $this->getBookedDates($id);
        // Thay thế hàm này bằng phương thức lấy danh sách ngày đã đặt của bạn

        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
      
        return view('admin.tour.edit', compact('tour','hotels','vehicles','locations','users','services','attractions','quoteHistory','extra_services','bookedDates','staffs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TourRequest $request, $id)
    {
        \DB::beginTransaction();
        try {
            // Lấy tour dựa trên ID   
             $this->tour->createOrUpdate($request, $id);
            $tour = $this->tour->find($id);
            $eventdate = $tour->eventdate->first(); // Lấy eventdate đầu tiên từ collection
      
            if ($eventdate) {
              
                $bookTour = $eventdate->bookTour->first(); // Lấy bookTour đầu tiên từ collection

                if ($bookTour) {
                    $userId = $bookTour->b_user_id; // Truy cập vào thuộc tính b_user_id từ bookTour
                }
            }
            // Lấy eventdate đầu tiên của tour
      
            if (!$tour) {
                return redirect()->back()->with('error', 'Tour không tồn tại');
            }
            

            // Cập nhật thông tin tour từ request
            if ($tour->t_type == 1) {
            foreach ($tour->eventdate as $eventdate) {
                // Lấy bookTour của eventdate
                $bookTour = $eventdate->bookTour->first();
                $b_price_adults = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
                $b_price_children = $tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100);
                $b_price_child6 = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 50 / 100;
                $b_price_child2 = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 25 / 100;
                if ($bookTour) {
            
                    // Cập nhật thông tin mới từ tour cho bookTour
                    $bookTour->update([
                        'b_price_adults' => $b_price_adults,
                        'b_price_children' => $b_price_children,
                        'b_price_child6' => $b_price_child6,
                        'b_price_child2' => $b_price_child2,
                    ]);

                    // Tính lại tổng tiền dựa trên giá và số lượng vé
                    $totalPrice = $b_price_adults * $bookTour->b_number_adults +
                                $b_price_children * $bookTour->b_number_children +
                                $b_price_child6 * $bookTour->b_number_child6 +
                                $b_price_child2 * $bookTour->b_number_child2 ;
                                $bookTour->update([
                                    'b_total_price' => $totalPrice
                                ]);
                }
            }
            }

            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
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
        $tour = Tour::find($id);
        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $tour->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
    public function sendQuote(Request $request,$quote_id)
    {
        // Lấy thông tin quote
        $quote = QuoteHistory::find($quote_id);
        
        if (!$quote) {
            return back()->with('error', 'Không tìm thấy báo giá!');
        }
        
        // Lấy thông tin tour từ quote
        $tour = $quote->tour;
        
        if (!$tour) {
            return back()->with('error', 'Không tìm thấy tour!');
        }
        
        $tourItineraries = $tour->touritineraries;
        $adultPrice = $tour->t_price_adults;
        $childPrice = $tour->t_price_children;
    
        // Kiểm tra nếu đã tồn tại báo giá trong quote_history
        $quoteHistory = QuoteHistory::find($quote_id);
    
        if ($quoteHistory) {
            // Cập nhật giá vào cột adult_price và child_price trong bảng quote_history
            $quoteHistory->adult_price = $adultPrice;
            $quoteHistory->child_price = $childPrice;
            $quoteHistory->status_admin = 1;
        
        }
        
    
        // Lấy thông tin người dùng
        $eventdate = $tour->eventdate->first();
        $bookTour = $eventdate->bookTour->first();
        
        $userId = $bookTour->b_user_id;
        $user = User::find($userId);
        $mailUser = $user ? $user->email : $bookTour->b_email;
        $mailUser = $mailUser ?? $bookTour->b_email;
        
     
 
        $quoteHistory->save();
        // Gửi email báo giá đến người dùng
        Mail::send('email_bao_gia', compact('user', 'tour', 'adultPrice', 'childPrice', 'tourItineraries','bookTour'), function ($email) use ($mailUser, $tour) {
            $email->subject('Báo giá ' . $tour->t_code . ' - ' . $tour->t_title); // Đặt tên tour và mã tour vào tiêu đề
            $email->to($mailUser);
        });
    
        // Thực hiện các tương tác khác (cập nhật trạng thái, v.v.)
    
        // Redirect hoặc trả về trang hiện tại với thông báo
        return back()->with('success', 'Cập nhật báo giá thành công!');
    }
    // Trong controller
    public function create_quote(Request $request)
    {
        // Lấy dữ liệu từ yêu cầu POST
        $adultPrice = $request->input('adult_price', 0);
        $childPrice = $request->input('child_price', 0);
        $tourId = $request->input('tour_id'); // Lấy tour_id từ yêu cầu

        // Tạo một đối tượng QuoteHistory mới
        $quoteHistory = new QuoteHistory();
        $adultPrice = $request->input('adult_price') ?? 0;
        $childPrice = $request->input('child_price') ?? 0;
        $quoteHistory->tour_id = $tourId; // Lưu tour_id vào QuoteHistory

        // Lưu đối tượng QuoteHistory vào CSDL
        $quoteHistory->save();

        // Redirect hoặc trả về phản hồi cho người dùng
        return redirect()->back()->with('success', 'Dữ liệu đã được lưu thành công.');
    }
    public function quote_delete($id)
    {
        //
        $quote = QuoteHistory::find($id);
        if (!$quote) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $quote->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
}
