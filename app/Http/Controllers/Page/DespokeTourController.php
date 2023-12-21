<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use App\Models\HotelType;
use App\Models\Service;
use App\Models\Location;
use App\Models\TourItinerarie;
use App\Models\CouponCode;
use App\Models\BookTourDetail;
use Illuminate\Support\Facades\DB; 
use App\Http\Requests\BookTourRequest;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Mail;

class DespokeTourController extends Controller
{
    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
    }
 
    //
  //  public function indexByLocation($t_location_id) {
       // $location = Location::findOrFail($t_location_id);
     //   $tours = Tour::where('t_location_id', $t_location_id)->paginate(NUMBER_PAGINATION_PAGE);
     //   return view('page.tour.index', ['tours' => $tours]);
  //  }
   

  public function bookTour(Request $request)
  {
      $regions = Region::with('locations')->get(); 
      $user = null; // Khởi tạo biến $user với giá trị mặc định là null
  
      if (Auth::guard('users')->check()) {
          $user = User::find(Auth::guard('users')->user()->id);
      }
  
      $vehicles = Vehicle::all();
      $hoteltypes = HotelType::all();
      $locations = Location::all();
      $tourtypes = TourType::all();
      $services = Service::where('type', 1)->get();
  
      return view('page.bespoketour.book', compact('user', 'regions', 'vehicles', 'hoteltypes', 'locations', 'tourtypes', 'services'));
  }
    
  public function postbookTour(Request $request)
  {
      // Kiểm tra và xác thực dữ liệu đầu vào từ biểu mẫu ở đây

      // Bắt đầu một transaction
      DB::beginTransaction();

      try {
          // Tạo đối tượng Tour và lưu thông tin
          $tour = new Tour();
          $tour->t_title = $request->input('t_title');
          $tour->t_type = 1;
          $t_day = $request->input('t_day');
          $tour->t_note = $request->input('t_note');
          $t_number_guests = $request->input('b_number_adults') + $request->input('b_number_children') + $request->input('b_number_child6') + $request->input('b_number_child2');
          $tour->t_number_guests = $t_number_guests;
          $t_starting_gate = $request->input('t_starting_gate');
          $t_tourtype_id = $request->input('t_tourtype_id');   
          $vehicle_ids = json_encode($request->input('vehicle_ids', []));
          $tour->vehicle_ids = $vehicle_ids;
  // Encoding JSON data before saving it to the database
            $selectedServices = $request->input('service_ids', []);
            $service_ids = json_encode(['selected_services' => $selectedServices]);
            $tour->service_ids = $service_ids;

          $tour->t_starting_gate= $t_starting_gate;
          $tour->t_tourtype_id = $t_tourtype_id;
       
          $tour->t_day = $t_day;
          $tour->t_night = $t_day - 1;
          $tour->t_price_adults = $request->input('t_price_adults') ?? 0;
          $tour->t_price_children = $request->input('t_price_children') ?? 0;          
          $tour->t_code = 'TOUR' . Str::random(6); // Sử dụng Str::random(6) để tạo mã tour ngẫu nhiên
          // Lưu thêm thông tin khác tùy theo cần thiết
      
          $tour->save();

          // Tạo đối tượng EventDate và lưu thông tin
          $eventdate = new EventDate();
          $eventdate->td_start_date = $request->input('td_start_date');
          $eventdate->td_end_date = date('Y-m-d', strtotime($request->input('td_start_date') . ' + ' . $tour->t_day . ' days'));
          $eventdate->td_tour_id = $tour->id;
          $eventdate->td_status = 1;
   
          // Lấy thông tin người dùng hiện tại
          // ... thêm các trường khác
          $eventdate->save();
          // Tạo bản ghi trong bảng 'booktours'
         

          // Cập nhật trường td_follow trong bảng EventDate
       
          
          $selectedLocations = $request->input('selected_locations');
          foreach ($selectedLocations as $locationId) {
              // Tạo bản ghi trong bảng liên kết giữa Tour và Location
              $tour->locations()->attach($locationId);
          }

       
          $user = Auth::guard('users')->user();

          $userId = $user->id ?? null;
          $eventdateId = $eventdate->id;

          // Sử dụng $eventdateId trong bản ghi 'booktours'
          $numberUser = $request->b_number_adults + $request->b_number_children + $request->b_number_child6 + $request->b_number_child2;
          $params = $request->except(['_token']);
          if ($user !== null) {
            $params['b_user_id'] = $user->id;
            // Tiếp tục thực hiện các thao tác khác với $params
            // Ví dụ: lưu vào cơ sở dữ liệu
        }
          $params['b_status'] = 1;
          $params['b_payment_method'] = $request->input('b_payment_method');
          $params['b_name'] = $request->input('b_name');
          $params['b_email'] = $request->input('b_email');
          $params['b_tourdetail_id'] = $eventdateId;
          
          // ... thêm các trường khác
         
          $params['b_price_adults'] = null;
          $params['b_price_children'] = null;
          $params['b_price_child6'] = null;
          $params['b_price_child2'] = null;

          
          // Tính tổng giá tiền
          $totalPrice = $params['b_price_adults'] * $request->input('b_number_adults') +
          $params['b_price_children'] * $request->input('b_number_children') +
          $params['b_price_child6'] * $request->input('b_number_child6') +
          $params['b_price_child2'] * $request->input('b_number_child2');

          $params['b_total_price'] = $totalPrice;
              // Tính tổng số vé bằng cộng các giá trị từ các cột
          $totalTickets = $request->b_number_adults +
          $request->b_number_children +
          $request->b_number_child6 +
          $request->b_number_child2;

          // Sau đó, gán tổng số vé vào cột b_total_ticket trong mảng $params
          $params['b_total_ticket'] = $totalTickets;
        
          $booktour = BookTour::create($params);
          if ($booktour) {
            $eventdate->td_follow = $eventdate->td_follow + $numberUser;
            $eventdate->save();
        }
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
          // Commit transaction
          DB::commit();
          $mail = $user ? $user->email : $booktour->b_email;

          Mail::send('emailyctour', compact('tour', 'eventdate', 'user','booktour'), function ($email) use ($mail) {
              $email->subject('Thông tin xác nhận đơn tour yêu cầu');
              $email->to($mail);
          });
          return redirect()->route('page.home')->with('success', 'Đội ngũ Du Lịch Nhật Ký Việt Nam chân thành cám Quý khách đã gửi yều cầu, chúng tôi sẽ liên hệ sớm với các bạn, muộn nhất là 24h..');
      } catch (\Exception $exception) {
          // Rollback transaction nếu có lỗi
          DB::rollBack();
     dd($exception);
          // Log lỗi hoặc hiển thị thông báo lỗi cho người dùng
          return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
      }
  }

    public function loi()
    {
      
            return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');

    }

                
}
