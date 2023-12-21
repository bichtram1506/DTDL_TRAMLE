<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookTour;
use App\Models\Payment;
use Mpdf\Mpdf;
use Illuminate\Support\Str; // Add this
use Illuminate\Support\Facades\DB;
use App\Models\Tour;
use App\Models\CouponCode;
use App\Models\EventDate;
use App\Models\User;
use App\Models\Staff;
use Mail;

class BookTourController extends Controller
{
    public function __construct(BookTour $bookTour, EventDate $eventdate)
    {
        view()->share([
            'book_tour_active' => 'active',
            'status' => $bookTour::STATUS,
            'classStatus' => $bookTour::CLASS_STATUS,
            'status_event' => $eventdate::STATUS,
            'classStatus_event' => $eventdate::CLASS_STATUS,
            'PAYMENT_METHODS' => $bookTour:: PAYMENT_METHODS,
        ]);
    
        $this->bookTour = $bookTour;
    }
    
    public function index(Request $request)
    {
        $bookTours = BookTour::with(['user']);
        
        if ($request->b_status) {
            $bookTours->where('b_status', $request->b_status);
        }
        if ($request->input('b_id')) { // 'search_id' là tên của trường input chứa id cần tìm kiếm
            $b_id = $request->input('b_id');
            $bookTours->where('id', $b_id);
        }
        if ($request->user_name) {
            $bookTours->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->user_name . '%');
            });
        }
        if ($request->td_start_date) {
            $startDate = $request->td_start_date;
            $bookTours->whereHas('eventdate', function ($query) use ($startDate) {
                $query->whereDate('td_start_date', '=', $startDate);
            });
        }
        if ($request->b_tour_id) {
            $bookTours->whereHas('eventdate', function ($q) use ($request) {
                $q->where('td_tour_id', $request->b_tour_id);
            });
        }
        if ($request->t_code) {
            $bookTours->whereHas('eventdate', function ($q) use ($request) {
                $q->whereHas('tour', function ($query) use ($request) {
                    $query->where('t_code', $request->t_code);
                });
            });
        }
        if ($request->b_name) {
            $bookTours->where('b_name', 'like', '%'.$request->b_name.'%');
        }
        
        if ($request->b_email) {
            $bookTours->where('b_email', $request->b_email);
        }
    
        if ($request->b_payment_method) {
            $bookTours->where('b_payment_method', $request->b_payment_method);
        }
        
        if ($request->id) {
            $bookTours->where('id', $request->id);
        }
     
   
        $bookTours = $bookTours->orderByDesc('id')->paginate(NUMBER_PAGINATION_PAGE);
       
        return view('admin.book_tour.index', compact('bookTours', 'request'));
    }
    
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
    
        return view('admin.book_tour.popup', compact('bookTour', 'extraServiceArray'));
    }
    public function edit($id)
    {
        // Find the BookTour record by ID
        $bookTour = BookTour::findOrFail($id);
      // Lấy danh sách tất cả các mã giảm giá
         $couponCodes = CouponCode::all();
        // Check if the BookTour record exists
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    
        return view('admin.book_tour.edit', compact('bookTour','couponCodes'));
    }
    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            // Gọi phương thức createOrUpdate để cập nhật thông tin BookTour
            $this->bookTour->createOrUpdate($request, $id);
    
            // Lấy bản ghi BookTour sau khi đã cập nhật
            $bookTour = $this->bookTour->find($id);
            $eventdate = $bookTour->eventdate;
            $tour = $eventdate->tour;
            if (!$bookTour) {
                return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
            }
            $p_vnp_response_code = $request->input('p_vnp_response_code'); // Gán giá trị từ dữ liệu đầu vào (request) hoặc từ biến khác

            $payment = $bookTour->payments->first(); // Lấy đối tượng Payment liên kết với BookTour
            $payment->p_vnp_response_code = $p_vnp_response_code; // Đặt giá trị p_vnp_response_code
            
            // Lưu đối tượng Payment vào cơ sở dữ liệu
            $payment->save();
            // Lấy số vé từ các input
            $totalTickets = $request->input('b_number_adults') +
                $request->input('b_number_children') +
                $request->input('b_number_child6') +
                $request->input('b_number_child2');
    
          // Update the number_registered based on b_total_ticket with b_status > 1

    
          
            // Lấy giá tiền từ input
            $priceAdults = $request->input('b_price_adults');
            $priceChildren = $request->input('b_price_children');
            $priceChild6 = $request->input('b_price_child6');
            $priceChild2 = $request->input('b_price_child2');

            // Tính toán tổng tiền dựa trên số vé và giá tiền
            $totalPrice = ($priceAdults * $request->input('b_number_adults')) +
                        ($priceChildren * $request->input('b_number_children')) +
                        ($priceChild6 * $request->input('b_number_child6')) +
                        ($priceChild2 * $request->input('b_number_child2'));

       // Lấy mã giảm giá từ yêu cầu
       $discountCodeId = $request->input('b_coupon_code_id');

       // Kiểm tra xem mã giảm giá có tồn tại hay không
       if ($discountCodeId) {
           // Truy vấn cơ sở dữ liệu để lấy thông tin về mã giảm giá
           $discount = CouponCode::where('id', $discountCodeId)->first();

           if ($discount) {
               // Áp dụng giảm giá vào tổng tiền dựa trên phần trăm giảm giá
               $discountAmount = ($discount->cc_percentage/ 100) * $totalPrice;
               $totalPrice -= $discountAmount;
           }
       }
            // Cập nhật thông số vào bản ghi BookTour
            $bookTour->b_total_ticket = $totalTickets;
            $bookTour->b_total_price = $totalPrice;
 
    // Lấy số vé từ các input
    $numberUser = $request->input('b_number_adults') + $request->input('b_number_children') + $request->input('b_number_child6') + $request->input('b_number_child2');
    
    // Calculate the sum of b_total_ticket with b_status >= 1
    $totalSum = $eventdate->bookTour->where('b_status', '>=', 1)->where('id', '!=', $id)->sum('b_total_ticket');

    
    // Update the number_registered in eventdate
   
    
    if ($tour->t_type != 1) {
        // Kiểm tra nếu số lượng người đăng ký vượt quá giới hạn
        if (($eventdate->number_registered = $totalSum + $numberUser ) > $tour->t_number_guests) {
            return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
        }
    } $eventdate->number_registered = $totalSum +$numberUser;

          $eventdate->save();
            $bookTour->save();
        // Update the number_registered in eventdate
          // Calculate the sum of b_total_ticket with b_status > 1
        // Lấy đối tượng Payment dựa trên ID đơn đặt tour
        if ($bookTour->b_status == 3) {
            // Lấy đối tượng Payment dựa trên ID đơn đặt tour
            $payment = Payment::where('p_booktour_id', $bookTour->id)->first();

            if ($payment) {
                // Cập nhật p_total_price trong Payment dựa trên b_total_price trong BookTour
                $payment->p_total_price = $bookTour->b_total_price;
                $payment->save();
            }
        }
            \DB::commit();
            $user = User::find($bookTour->b_user_id);
            $mailuser = $user ? $user->email : $bookTour->b_email;
            $mailuser = $user->email;
            Mail::send('email_updated_booktour', compact('user', 'bookTour', 'eventdate', 'tour'), function ($email) use ($mailuser) {
                $email->subject('Đơn hàng của bạn đã được điều chỉnh');
                $email->to($mailuser);
            });
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
    
    public function delete($id)
    {
        $bookTour = BookTour::find($id);
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
    
        try {
            $eventdate = $bookTour->eventdate;
            if ($bookTour->b_status == 1) {
                $eventdate->td_follow -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
            } else {
                $eventdate->number_registered -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
            }
            $eventdate->save();
    
            $bookTour->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
    public function updateStatus(Request $request, $status, $id)
    {
        $bookTour = BookTour::find($id);
        $eventdate = $bookTour->eventdate;
        $tour = $eventdate->tour;
        $extraServiceArray = [];
    
        // Decode the JSON string from the extra_service_id field of the BookTour model
        $extraServices = json_decode($bookTour->extra_service_id, true);
    
        // Store the decoded extra service information in the array
        $extraServiceArray[$bookTour->id] = $extraServices;
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        
        $numberUser = 0;
        $numberUser += $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
   
        if (!$bookTour) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        
        $temp = $bookTour->b_status;
        \DB::beginTransaction();
        
        if ($status != $bookTour->b_status) {
            try {
                $bookTour->b_status = $status;
    
                if ($bookTour->save()) {
                    if ($status == 4 && $temp != 3) {
                        return redirect()->back()->with('error', 'Thao tác lỗi');
                    }
    
                    if ($status == 5) {
                        if ($temp == 4) {
                            return redirect()->back()->with('error', 'Thao tác sai');
                        }
    
                        if ($temp == 1 ) {
                            // Lặp qua từng chi tiết đặt tour trong $bookTourDetails
                      
                                // Lấy thông tin về tour từ chi tiết đặt tour
                                $tour = $bookTour->eventdate->tour;
                        
                                // Cập nhật thông tin của EventDate dựa trên số người đã đặt
                                $eventdate = $bookTour->eventdate;
                                $eventdate->td_follow -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                                $eventdate->save();
                        
                                // Lấy thông tin người dùng và gửi email xác nhận hủy booking
                                $user = User::find($bookTour->b_user_id);
                                $mailuser = $user ? $user->email : $bookTour->b_email;
                                $mailuser = $user->email;
                                Mail::send('emailhuy', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                                    $email->subject('Xác nhận HUỶ BOOKING');
                                    $email->to($mailuser);
                                });
                                                
                        } else {
                            // Lặp qua từng chi tiết đặt tour trong $bookTourDetails
               
                               
                                $tour = $bookTour->eventdate->tour;
                        
                                // Cập nhật thông tin của EventDate dựa trên số người đã đặt
                                $eventdate = $bookTour->eventdate;
                         
                                $eventdate->number_registered -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                             
                                $eventdate->save();
                                
                                // Lấy thông tin người dùng và gửi email xác nhận hủy booking
                                $user = User::find($bookTour->b_user_id);
                                $mailuser = $user ? $user->email : $bookTour->b_email;
                                Mail::send('emailhuy', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                                    $email->subject('Xác nhận HUỶ BOOKING');
                                    $email->to($mailuser);
                                });
                                               
                        }
                    }
    
                    if ($status == 3) {
                        if ($temp == 2) {
                       
                               // Lấy thông tin của BookTour từ BookTourDetail
                                $eventdate = $bookTour->eventdate;
                        
                                if (!$eventdate) {
                                    return redirect()->back()->with('error', 'Ngày sự kiện không tồn tại');
                                }
                        
                                // Lấy thông tin người dùng từ BookTour
                                $user = User::find($bookTour->b_user_id);
                                $mailuser = $user ? $user->email : $bookTour->b_email;
                                Payment::create([
                                    'p_booktour_id' => $bookTour->id, // Sử dụng ID của đơn đặt tour
                                    'p_total_price' => $bookTour->b_total_price, // Lấy tổng tiền từ đơn đặt tour
                                    'p_vnp_response_code' => '00'
                                ]);
                                // Gửi email xác nhận thanh toán
                                Mail::send('emailtt', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                                    $email->subject('Xác Nhận Thanh Toán');
                                    $email->to($mailuser);
                                });
                        
                        }                        
                    
                        if ($temp == 1) {
                          
                             // Lấy thông tin của BookTour từ BookTourDetail
                                $eventdate = $bookTour->eventdate; // Lấy eventdate từ BookTour
                        
                                if (!$eventdate) {
                                    return redirect()->back()->with('error', 'Ngày sự kiện không tồn tại');
                                }
                        
                                $tour = $eventdate->tour;
                              
                                // Cập nhật các thông số của eventdate
                                $eventdate->number_registered += $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTourl->b_number_child2;
                                $eventdate->td_follow -= $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                                $eventdate->save();
                                
                                $user = User::find($bookTour->b_user_id);
                                $mailuser = $user ? $user->email : $bookTour->b_email;
                        
                                // Gửi email xác nhận thanh toán
                                Mail::send('emailtt', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                                    $email->subject('Xác nhận thanh toán');
                                    $email->to($mailuser);
                                });
                        
                        }
                        
                    }
                    
                    if ($status == 2) {
                        // Lặp qua từng chi tiết đặt tour trong $bookTourDetails
                      
                            // Tính toán tổng số người đặt trong chi tiết này
                            $totalPeople = $bookTour->b_number_adults + $bookTour->b_number_children + $bookTour->b_number_child6 + $bookTour->b_number_child2;
                    
                            // Lấy thông tin về tour từ chi tiết đặt tour
                            $tour = $bookTour->eventdate->tour;
                    
                            // Cập nhật thông tin của EventDate dựa trên số người đặt
                            $eventdate = $bookTour->eventdate;
                           
                            $eventdate->number_registered += $totalPeople;
                        
                            $eventdate->td_follow -= $totalPeople;
                            if (($eventdate->number_registered + $totalPeople) > $tour->t_number_guests) {
                                return redirect()->back()->with('error', 'Số lượng người đăng ký đã vượt quá giới hạn');
                            }
                            $eventdate->save();
                            
                            // Gửi email xác nhận booking cho người dùng
                            $user = User::find($bookTour->b_user_id);
                            $mailuser = $user ? $user->email : $bookTour->b_email;
                            Mail::send('email', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                                $email->subject('Xác nhận Booking');
                                $email->to($mailuser);
                            });
                    
                    }
                    
                    if ($status == 4) {
                        $tour = $bookTour->eventdate->tour;
                          // Gửi email xác nhận booking cho người dùng
                          $user = User::find($bookTour->b_user_id);
                          $mailuser = $user ? $user->email : $bookTour->b_email;
                          Mail::send('emailhoanthanh', compact('user', 'bookTour', 'eventdate', 'tour','extraServices','extraServiceArray'), function ($email) use ($mailuser) {
                              $email->subject('Khảo Sát và Khuyến Mãi Sau Tour');
                              $email->to($mailuser);
                          });
                    }
                    
                }
    
                \DB::commit();
                return redirect()->route('book.tour.index')->with('success', 'Lưu dữ liệu thành công');
            } catch (\Exception $exception) {
                \DB::rollBack();
                dd($exception);
                return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
            }
        } else {
            return redirect()->back()->with('error', 'Lỗi thao tác');
        }
    }

    public function downloadInvoiceAsPDF($bookId)
    {
        // Lấy thông tin đơn đặt tour dựa trên $bookId
        $bookTour = DB::table('book_tours')->where('id', $bookId)->first();
    
        if (!$bookTour) {
            // Xử lý khi không tìm thấy đơn đặt tour
            return abort(404);
        }
    
        // Tạo thông tin hóa đơn từ thông tin đơn đặt tour
        $invoiceData = [
            'user_id' => $bookTour->b_user_id,
            'coupon_code_id' => $bookTour->b_coupon_code_id,
            'address' => $bookTour->b_address,
            'status' => $bookTour->b_status,
            'payment_method' => $bookTour->b_payment_method,
            'reason' => $bookTour->b_reason,
            'book_date' => $bookTour->b_book_date,
            'total_price' => $bookTour->b_total_price,
            'tourdetail_id' => $bookTour->b_tourdetail_id,
            'total_ticket' => $bookTour->b_total_ticket,
            'extra_service_id' => $bookTour->extra_service_id,
            'price_adults' => $bookTour->b_price_adults,
            'price_children' => $bookTour->b_price_children,
            'number_adults' => $bookTour->b_number_adults,
            'number_children' => $bookTour->b_number_children,
            'price_child6' => $bookTour->b_price_child6,
            'price_child2' => $bookTour->b_price_child2,
            'number_child6' => $bookTour->b_number_child6,
            'number_child2' => $bookTour->b_number_child2,
            'name' => $bookTour->b_name,
            'email' => $bookTour->b_email,
            'phone' => $bookTour->b_phone,
        ];
        $jsonString = json_encode($invoiceData);
        // Tạo một tệp PDF tạm thời bằng thư viện mpdf
        $mpdf = new Mpdf();
        $mpdf->WriteHTML(view('admin.common.booktour_pdf', compact('invoiceData'))->render());
    
        // Tên tệp PDF khi tải về
        $fileName = 'invoice_' . $bookId . '.pdf';
    
        // Lưu tệp PDF vào thư mục storage/app/public
        $mpdf->Output(storage_path('app/public/' . $fileName), 'F');
    
        // Trả về tệp PDF để tải về
        return response()->download(storage_path('app/public/' . $fileName), $fileName);
    }
}
