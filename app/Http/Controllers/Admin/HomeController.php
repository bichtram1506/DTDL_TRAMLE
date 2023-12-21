<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Date;
use App\Models\Article;
use App\Models\User;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\BookTour;
use App\Models\Tour;
use App\Models\Comment;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        view()->share([
            'home_active' => 'active',

        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
  //
  // List the 5 most recently created user accounts
    $newestUsers = User::latest()->limit(5)->get();
  $user = User::count();
  $article = Article::count();
  $bookTour = BookTour::count();
 
  $tour = Tour::count();
  $comment = Comment::count();
  $totalRevenue = BookTour::whereIn('b_status', [3, 4, 5])
  ->sum('b_total_price');
  // Lấy ngày hôm nay
$today = Carbon::today();

// Tính doanh thu hôm nay
$totalRevenuetoday = BookTour::whereIn('b_status', [3, 4, 5])
  ->whereDate('created_at', $today)
  ->sum('b_total_price');
  $revenueData = BookTour::pluck('b_total_price')->toArray(); // Replace with your actual Eloquent query to fetch revenue data

  // Thống kê trạng thái đơn hàng
  // Tiep nhan
  $transactionDefault = BookTour::where('b_status',1)->select('id')->count();
  // Đã xác nhận
  $transactionProcess = BookTour::where('b_status',2)->select('id')->count();
  // Thanh toán
  $transactionSuccess = BookTour::where('b_status',3)->select('id')->count();
  //
  $transactionFinish = BookTour::where('b_status',4)->select('id')->count();

  $transactionCancel = BookTour::where('b_status',5)->select('id')->count();
  
 
  $tours = Tour::orderByDesc('created_at')->limit(3)->get();
  $viewData = [
      'user' => $user,
      'article' => $article,
      'bookTour' => $bookTour,
      'tour' => $tour,
      'tours' => $tours,
      'comment' => $comment,
      'totalRevenue' => $totalRevenue,
      'revenueData' => $revenueData,
      'newestUsers' => $newestUsers,
      'totalRevenuetoday' => $totalRevenuetoday,
     
  
  ];
  return view('admin.home.index', $viewData);
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detail()
    {
     return view('admin.revenue_report.detail');
    }
}
