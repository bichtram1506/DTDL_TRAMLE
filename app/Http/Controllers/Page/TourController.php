<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Mpdf\Mpdf;
use Illuminate\Support\Str; // Add this
use Carbon\Carbon;
use App\Models\Tour;
use App\Models\User;
use App\Models\BookTour;
use App\Models\Hotel;
use App\Models\TourType;
use App\Models\Region;
use App\Models\Vehicle;
use App\Models\EventDate;
use App\Models\Favorite;
use App\Models\Location;
use App\Models\QuoteHistory;
use App\Models\TourItinerarie;
use App\Models\CouponCode;

use Illuminate\Support\Facades\DB; 
use App\Http\Requests\BookTourRequest;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mail;

class TourController extends Controller
{
    public function __construct( Tour $tour ,QuoteHistory $quote)
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
            'statustour' => $tour::STATUS,
            'status_quote' => $quote::STATUS,
        ]);
    }
    public function showToursByTourType($tourtype_id)
    {
        $tourtype = TourType::findOrFail($tourtype_id);
        $tours = Tour::select('tours.*')
        ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))->with(['eventdate', 'tourtype', 'locations'])
            ->where('t_tourtype_id', $tourtype_id)
            ->paginate(NUMBER_PAGINATION_PAGE);
    
        $viewData = [
            'tours' => $tours,
            'locations' => Location::all(),
            'regions' => Region::with('locations')->get(),
            'selectedTourType' => $tourtype,
            'tourtypes' => TourType::all(), // Thêm biến $tourtypes vào viewData
        ];
    
        return view('page.tour.index', $viewData);
    }
    

    public function showToursByLocation($location_id)
    {
        $location = Location::findOrFail($location_id);
    
        // Truy xuất thông tin về miền tương ứng
    
    
        $tourtypes = TourType::get();
        $tours = Tour::select('tours.*')
        ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))
        ->with(['eventdate', 'tourtype', 'locations'])
        ->whereHas('locations', function ($locationQuery) use ($location_id) {
            $locationQuery->where('location_id', $location_id);
        })
            ->paginate(NUMBER_PAGINATION_PAGE);
    
        $viewData = [
            'tours' => $tours,
            'locations' => Location::all(),
         // Thêm thông tin về miền vào viewData
            'location' => $location,
            'tourtypes' => $tourtypes,
        ];
    
        return view('page.tour.index', $viewData);
    }
    
    public function showToursByRegion($region_id)
    {
        // Truy xuất thông tin về miền
        $region = Region::findOrFail($region_id);
    
        // Truy xuất danh sách tất cả các địa điểm thuộc cùng một miền
        $locationsInRegion = Location::where('l_region_id', $region_id)->get();
    
        // Truy xuất danh sách các tour thuộc các địa điểm trong miền
        $tours = Tour::select('tours.*')
        ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))
        ->with(['eventdate', 'tourtype', 'locations'])
        ->whereIn('id', function ($query) use ($locationsInRegion) {
            $query->select('tour_id')
                ->from('tour_location')
                ->whereIn('location_id', $locationsInRegion->pluck('id'));
        })
            ->paginate(NUMBER_PAGINATION_PAGE);
    
        $viewData = [
            'tours' => $tours,
            'locations' => Location::all(),
            'region' => $region, // Thêm thông tin về miền vào viewData
            'tourtypes' => TourType::get(),
        ];
    
        return view('page.tour.index', $viewData);
    }
    

    //
  //  public function indexByLocation($t_location_id) {
       // $location = Location::findOrFail($t_location_id);
     //   $tours = Tour::where('t_location_id', $t_location_id)->paginate(NUMBER_PAGINATION_PAGE);
     //   return view('page.tour.index', ['tours' => $tours]);
  //  }
    public function index(Request $request)
    {
        $tourtypes = TourType::get();
        $regions = Region::with('locations')->get(); 
        $locations = Location::all();
        $tours = Tour::select('tours.*')
        ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))
        ->with(['eventdate', 'tourtype', 'locations'])
       
           
        ->when($request->price, function ($query) use ($request) {
            $price = explode('-', $request->price);
            
            $query->whereHas('eventdate', function ($eventdateQuery) use ($price) {
                $eventdateQuery->whereBetween(
                    DB::raw('t_price_adults * (1 - t_sale / 100)'),
                    [$price[0], $price[1]]
                );
            });
        })
        
        ->when($request->t_starting_gate, function ($query) use ($request) {
            $query->where('t_starting_gate', $request->t_starting_gate);
        })
        ->when($request->td_start_date, function ($query) use ($request) {
            $startDate = date('Y-m-d', strtotime($request->td_start_date));
            $query->whereHas('eventdate', function ($eventdateQuery) use ($startDate) {
                $eventdateQuery->whereDate('td_start_date', $startDate);
            });
        })
        ->when($request->location_id, function ($query) use ($request) {
            $query->whereHas('locations', function ($locationQuery) use ($request) {
                $locationQuery->where('location_id', $request->location_id);
            });
        })
        ->when($request->tourtype_id, function ($query) use ($request) {
            $query->where('t_tourtype_id', $request->tourtype_id); // Change 't_tourtype_id' to 'tourtype_id'
        })
        
        ->when($request->key_tour, function ($query) use ($request) {
            $query->where('t_title', 'like', '%' . $request->key_tour . '%');
        })
        ->when($request->t_day, function ($query) use ($request) {
            $query->where('t_day',$request->t_day);
        })
        ->when($request->t_destination, function ($query) use ($request) {
            $query->where('t_destination', $request->t_destination);
        })
     
        
        ->paginate(NUMBER_PAGINATION_PAGE);
    
        $viewData = [
            'tours' => $tours,
            'tourtypes' => $tourtypes,
            'locations' => $locations, 
            'regions'  => $regions,
        ];
    
        return view('page.tour.index', $viewData);
    }
    
    public function detail(Request $request, $id)
    {
        $regions = Region::with('locations')->get(); 
        // Kiểm tra xem đã tăng t_views trong phiên làm việc này chưa
        if (!$request->session()->has('viewed_tour_' . $id)) {
            $tour = Tour::find($id);

            if ($tour) {
                // Tăng giá trị t_views lên 1 nếu tour tồn tại
                $tour->increment('t_views');
                // Đánh dấu tour này đã được xem trong phiên làm việc hiện tại
                $request->session()->put('viewed_tour_' . $id, true);
            }
        }
        $tour = Tour::with([
            'comments' => function($query) use ($id) {
                $query->with('user')
                    ->where('cm_tour_id', $id)
                    ->whereIn('cm_status', [1, 2])
                    ->orderByRaw('IFNULL(cm_rating, 9999) ASC')
                    ->orderBy('created_at', 'ASC');
            },
            'eventdate' => function($query) {
                $query->where('td_status', 1)
                    ->where('td_start_date', '>', now()) // Chỉ lấy các EventDate với td_start_date lớn hơn ngày hiện tại
                    ->orderBy('td_start_date', 'asc');
            },
            'touritineraries', 'tourImages'
        ])->find($id);
        
        $quoteHistory = $tour->quoteHistory;

        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        // Retrieve the 'touritineraries' belonging to the specific tour
        $touritineraries = $tour->touritineraries;
        $tourImages = $tour->tourImages;
        
    // Lấy danh sách location của tour hiện tại
    $locations = $tour->locations()->pluck('location_id');

    // Lấy danh sách tour liên quan dựa trên trùng location
    $tours = Tour::select('tours.*')
        ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))
        ->whereHas('locations', function ($query) use ($locations) {
            $query->whereIn('location_id', $locations);
        })
        ->where('id', '<>', $id)
        ->orderBy('id')
        ->limit(NUMBER_PAGINATION_PAGE)
        ->get();


        return view('page.tour.detail', compact('tour', 'tours', 'touritineraries' ,'tourImages','regions','quoteHistory'));
    }

    public function bookTour(Request $request, $id, $slug)
    {
        $regions = Region::with('locations')->get(); 
        if (!Auth::guard('users')->check()) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt tour');
        }

        $eventdate = EventDate::find($id);
        if (!$eventdate) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        $tour = $eventdate->tour;
        if (!$tour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        $user = User::find(Auth::guard('users')->user()->id);


        return view('page.tour.book', compact('user', 'eventdate', 'tour','regions'));
    }


    public function postBookTour(BookTourRequest $request, $id)
    {
        try {
            $tdStartDate = $request->input('td_start_date');
            $eventdate = EventDate::find($id);

            if (!$eventdate) {
                // Nếu không tìm thấy EventDate với id đã cho,
                // thì thử tìm kiếm dựa trên các điều kiện khác
                $eventdate = EventDate::where('td_start_date', $tdStartDate)
                    ->where('td_tour_id', $id)
                    ->first();
            
                if (!$eventdate) {
                    // Nếu không tìm thấy EventDate dựa trên bất kỳ điều kiện nào,
                    // xử lý khi không tìm thấy EventDate
                }
            }
            if (!$eventdate) {
                // Nếu không tìm thấy EventDate với td_start_date cung cấp,
                // thử tìm hoặc tạo một Tour
                $tour = Tour::find($id);
            
                if (!$tour) {
                    // Xử lý trường hợp không tìm thấy Tour
                    return redirect()->back()->with('error', 'Tour not found');
                }
            
                // Tạo một EventDate mới và liên kết nó với Tour
                $eventdate = new EventDate();
                $eventdate->td_start_date = $tdStartDate;
           
                $eventdate->td_end_date = date('Y-m-d', strtotime($tdStartDate . ' + ' . $tour->t_day . ' days'));
                $eventdate->td_tour_id = $tour->id;
    
                // Set other EventDate properties as needed
                $eventdate->save();
            }
            
            // Bây giờ bạn đã có $tour và $eventdate sẵn sàng sử dụng
            $tour = $eventdate->tour;            
            
            // Now you have $tour and $eventdate available, whether they were found or created
            
    
            $numberUser = $request->b_number_adults + $request->b_number_children + $request->b_number_child6 + $request->b_number_child2;
            if (($eventdate->number_registered + $numberUser) > $tour->t_number_guests) {
                return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
            }
    
            \DB::beginTransaction();
    
            $user = Auth::guard('users')->user();
    
            $params = $request->except(['_token']);
            $params['b_user_id'] = $user->id;
            $params['b_address'] = $request->input('b_address');
            $params['b_status'] = 1;
            $params['b_payment_method'] = $request->input('b_payment_method');
            $params['b_tourdetail_id'] = $eventdate->id;
            $params['b_price_adults'] = $tour->t_price_adults - ($tour->t_price_adults * $tour->t_sale / 100);
            $params['b_price_children'] = $tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100);
            $params['b_price_child6'] = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 50 / 100;
            $params['b_price_child2'] = ($tour->t_price_children - ($tour->t_price_children * $tour->t_sale / 100)) * 25 / 100;

            $discountCodeId = $request->input('b_coupon_code_id');
            $totalPrice = 0; // Khai báo biến $totalPrice và gán giá trị mặc định là 0
            
            // Tính tổng giá tiền
            $totalPrice = $request->input('b_total_price');
                      // Kiểm tra nếu tồn tại $discountCodeId và không phải là null, thực hiện cộng lượt sử dụng của mã giảm giá
                      if ($discountCodeId !== null) {
                        $coupon = CouponCode::find($discountCodeId);
                        
                        if ($coupon) {
                            // Cộng số lượt sử dụng của mã giảm giá
                            $coupon->cc_usage_count++;
                            $coupon->save();
                        }
                    }
            // Nếu không có mã giảm giá, tính tổng giá tiền theo công thức bạn đã sử dụng
          // Nếu không có mã giảm giá, tính tổng giá tiền theo công thức bạn đã sử dụng
            if ($discountCodeId == null || $totalPrice === 0) {
                $totalPrice = $params['b_price_adults'] * $request->input('b_number_adults') +
                            $params['b_price_children'] * $request->input('b_number_children') +
                            $params['b_price_child6'] * $request->input('b_number_child6') +
                            $params['b_price_child2'] * $request->input('b_number_child2');
            }
            // Kiểm tra và gán giá trị cho cột b_total_price
            if (!$totalPrice) {
                return redirect()->back()->with('error', 'Vui lòng kiểm tra giá trị tổng tiền.');
            }
            
         
                // Tính tổng số vé bằng cộng các giá trị từ các cột
            $totalTickets = $request->b_number_adults +
            $request->b_number_children +
            $request->b_number_child6 +
            $request->b_number_child2;

            // Sau đó, gán tổng số vé vào cột b_total_ticket trong mảng $params
            $params['b_total_ticket'] = $totalTickets;
            // Lấy dữ liệu từ biểu mẫu
            $selectedServices = $request->input('extra_services');

            // Chuyển đổi chuỗi JSON thành mảng
            $selectedServicesArray = $selectedServices; // Không cần chuyển đổi lại thành mảng

            $selectedServicesArray = [];
            foreach ($tour->extra_services as $extraService) {
                if (in_array($extraService->id, $request->input('extra_services', []))) {
                    $serviceWithPrice = [
                        'id' => $extraService->id,
                        'name' => $extraService->sv_name,
                        'price' => $extraService->pivot->price,
                    ];
            
                    $selectedServicesArray[] = $serviceWithPrice;
                }
            }
            
            $selectedServicesJson = json_encode($selectedServicesArray);
           
            $params['extra_service_id'] = $selectedServicesJson;
            // Tính tổng giá tiền các dịch vụ nếu có
            $extraServiceTotalPrice = 0;
            if (!empty($selectedServicesArray)) {
                foreach ($selectedServicesArray as $service) {
                    $extraServiceTotalPrice += $service['price'];
                }
            }

            // Cập nhật giá trị cho cột b_total_price
            $totalPrice += $extraServiceTotalPrice;
            $params['b_total_price'] = $totalPrice;
            $booktour = BookTour::create($params);
            $booktourId = $booktour->id;
           
            // Tạo bản ghi trong bảng 'booktour_details'
      
    
            if ($booktour) {
                $eventdate->td_follow = $eventdate->td_follow + $numberUser;
                $eventdate->save();
            }
          
               \DB::commit();
                // Create an array to store the extra service information
        $extraServiceArray = [];
    
        // Decode the JSON string from the extra_service_id field of the BookTour model
        $extraServices = json_decode($booktour->extra_service_id, true);
    
        // Store the decoded extra service information in the array
        $extraServiceArray[$booktour->id] = $extraServices;
            $mail = $user->email;
            Mail::send('emailtn', compact('booktour', 'eventdate', 'user', 'tour','extraServices','extraServiceArray'), function ($email) use ($mail) {
                $email->subject('Thông tin xác nhận đơn Booking');
                $email->to($mail);
            });
     
               if ($params['b_payment_method'] === 'VNPay' &&  $eventdate->td_status ==1) {
                // Xử lý lưu dữ liệu liên quan đến phương thức bankTransfer vào cơ sở dữ liệu
                // ...
                
                // Gán giá trị b_total_price vào session
                session(['b_total_price' => $totalPrice]);
                
                // Tạo mã đơn hàng từ ID của bản ghi đơn hàng
                $vnp_TxnRef = $booktourId;
                
                // Use JavaScript to create and submit a form to initiate a POST request
                return view('page.payment.redirect_to_vnpay', ['vnpayUrl' => route('vnpay_payment'), 'vnp_TxnRef' => $vnp_TxnRef]);
            }
            if ($params['b_payment_method'] === 'MOMO' &&  $eventdate->td_status ==1) {
                // Xử lý lưu dữ liệu liên quan đến phương thức bankTransfer vào cơ sở dữ liệu
                // ...
                
                // Gán giá trị b_total_price vào session
                session(['b_total_price' => $totalPrice]);
                   
                // Tạo mã đơn hàng từ ID của bản ghi đơn hàng
                  // Tạo mã đơn hàng từ ID của bản ghi đơn hàng
              $orderId = $booktourId . "_" . time();
    
                
                // Use JavaScript to create and submit a form to initiate a POST request
                return view('page.payment.redirect_to_momo', ['payUrl' => route('momo_payment'), 'b_total_price' => session('b_total_price'), 'orderId' => $orderId]);
            }
            
            return redirect()->route('page.home')->with('success', 'Cám ơn bạn đã đặt tour, chúng tôi sẽ liên hệ sớm để xác nhận.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            // In ra thông tin lỗi để kiểm tra
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
    
    public function loi()
    {
      
            return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');

    }

    public function toggleFavorite(Request $request, Tour $tour)
    {
        $user = auth()->guard('users')->user();
    
        // Toggle favorite status
        if ($user->favorites()->where('f_tour_id', $tour->id)->exists()) {
            $user->favorites()->detach($tour);
            $isFavorited = false;
        } else {
            $user->favorites()->attach($tour);
            $isFavorited = true;
        }
    
        $favoriteCount = $tour->favorites()->count();
    
        return response()->json(['isFavorited' => $isFavorited, 'favoriteCount' => $favoriteCount]);
    }

   
            public function downloadItinerariesAsPDF($tourId)
            {
            // Lấy thông tin tour dựa trên $tourId
            $tour = Tour::find($tourId);

            if (!$tour) {
                // Xử lý khi không tìm thấy tour
                return abort(404);
            }

            // Truy vấn thông tin lịch trình từ cơ sở dữ liệu dựa trên $tourId
            $itineraries = TourItinerarie::where('ti_tour_id', $tourId)->get();

            // Tạo một tệp PDF tạm thời bằng thư viện mpdf
            $mpdf = new Mpdf();
            $mpdf->WriteHTML(view('page.common.pdf', compact('itineraries', 'tour'))->render());

            // Tên tệp PDF khi tải về
            // Tên tệp PDF khi tải về
            $fileName = Str::slug($tour->t_title) . '.pdf';

            // Lưu tệp PDF vào thư mục storage/app/public
            $mpdf->Output(storage_path('app/public/' . $fileName), 'F');

            // Trả về tệp PDF để tải về
            return response()->download(storage_path('app/public/' . $fileName), $fileName);
            }

            public function index_promotion()
            {
                $tours = Tour::whereHas('eventdate', function ($query) {
                    $query->where('t_sale', '>', 0);
                })->paginate(NUMBER_PAGINATION_PAGE);
            
                $viewData = [
                    'tours' => $tours,
                ];
            
                return view('page.promotion.index', $viewData);
            }
            
               public function bookTouruser(Request $request, $id, $slug)
            {
                $regions = Region::with('locations')->get(); 
                if (!Auth::guard('users')->check()) {
                    return redirect()->back()->with('error', 'Vui lòng đăng nhập để đặt tour');
                }

                $tour = Tour::find($id);
                if (!$tour) {
                    return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
                }

                $user = User::find(Auth::guard('users')->user()->id);

               
                

                return view('page.tour.book', compact('user', 'tour','regions'));
            }

              
            public function update(Request $request)
            {
                if ($request->has('update_button')) {
                    $t_note = $request->input('t_note');
                    $tourId = $request->input('id'); // Retrieve the ID from the form input
            
                    $tour = Tour::find($tourId); // Find the tour based on the retrieved ID
            
                    if ($tour) {
                        $tour->t_note = $t_note;
                        $tour->save(); // Save the updated value to the database
                    }
                }
            
                // Redirect back to the page or a suitable location after the update
                return redirect()->back()->with('success', 'Thay đổi đã được lưu lại.');
            }
            
            public function updateBookingStatus() {
                $booktours = BookTour::where('b_status', '<=', 2)->get();
            
                foreach ($booktours as $booktour) {
                    $createdAt = $booktour->created_at; // Thời gian tạo đơn đặt tour
                    $endDate = $createdAt->addDays(2); // Thời gian sau 2 ngày
            
                    $now = now(); // Thời gian hiện tại
            
                    if ($now > $endDate && $booktour->b_status == 2) {
                        $booktour->b_status = 5; // Cập nhật trạng thái thành 5 (hủy)
                        $booktour->save();
                    }
                }
            }
// Chi tiết đơn đặt
            public function showDetail($id)
            {
                $bookTour = BookTour::with('payments')->find($id);
            
                if (!$bookTour) {
                    return response()->json(['error' => 'Không tìm thấy thông tin đơn đặt tour'], 404);
                }
            
                // Create an array to store the extra service information
                $extraServiceArray = [];
            
                // Decode the JSON string from the extra_service_id field of the BookTour model
                $extraServices = json_decode($bookTour->extra_service_id, true);
            
                // Store the decoded extra service information in the array
                $extraServiceArray[$bookTour->id] = $extraServices;
            
                return view('page.common.showbook', compact('bookTour', 'extraServiceArray'));
            }

            public function filter(Request $request)
            {
                $sorting = $request->input('sorting', 'default'); // Lấy giá trị sorting từ yêu cầu AJAX, mặc định là 'default'
        
                $tours = Tour::all(); // Lấy danh sách tour
        
                if ($sorting == 'price_asc') {
                    $tours = $tours->sortBy('price'); // Sắp xếp danh sách tour theo giá tăng dần
                } elseif ($sorting == 'price_desc') {
                    $tours = $tours->sortByDesc('price'); // Sắp xếp danh sách tour theo giá giảm dần
                } elseif ($sorting == 'rating_desc') {
                    $tours = $tours->sortByDesc('rating'); // Sắp xếp danh sách tour theo đánh giá cao đến thấp
                } elseif ($sorting == 'rating_asc') {
                    $tours = $tours->sortBy('rating'); // Sắp xếp danh sách tour theo đánh giá thấp đến cao
                }
        
                return view('page.tour.filtered', compact('tours'));
            }
}
