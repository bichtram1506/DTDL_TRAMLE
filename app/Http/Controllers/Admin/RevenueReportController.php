<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Tour;
use App\Models\EventDate;
use App\Models\BookTour;
use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class RevenueReportController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        view()->share([
            'revenue_report_active' => 'active',

        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index()
    {
    $startDate = Carbon::now()->subDays(30); // Ví dụ: 30 ngày gần đây
    $endDate = Carbon::now();
    $staffnew= Staff::whereBetween('created_at', [$startDate, $endDate])->count();
    $staff = Staff::count();
    $bannedStaffCount = Staff::where('status', 2)->count();
    $tour0 = Tour::where('t_type', '=', 0)->count();
    $tour1 = Tour::where('t_type', '=', 1)->count();
    $newestStaffs = Staff::latest()->limit(5)->get();
    $tours = DB::table('tours')
    ->select('tours.t_code', 'tours.id', 'tours.t_title', DB::raw('COUNT(book_tours.id) as tour_details_count'))
    ->join('tour_details', 'tours.id', '=', 'tour_details.td_tour_id')
    ->join('book_tours', 'tour_details.id', '=', 'book_tours.b_tourdetail_id')
    ->groupBy('tours.t_code', 'tours.id', 'tours.t_title') // Thêm tours.id vào phần GROUP BY
    ->orderByDesc('tour_details_count')
    ->limit(5)->get();
    $favoriteTours = DB::table('favorites')
    ->select('favorites.f_tour_id', 'tours.t_title', 'tours.t_code', DB::raw('COUNT(favorites.f_user_id) as favorite_count'))
    ->join('tours', 'favorites.f_tour_id', '=', 'tours.id')
    ->groupBy('favorites.f_tour_id', 'tours.t_title', 'tours.t_code')
    ->orderBy('favorite_count', 'desc')
    ->take(4)
    ->get();

    $today = Carbon::today(); // Lấy ngày hôm nay

    $tourstoday = Tour::whereHas('eventdate', function ($query) use ($today) {
        $query->whereDate('td_start_date', '=', $today);
    })->with('eventdate')->get();
    $tourtoday = EventDate::where('td_start_date', '>=', $today)
              ->where('td_status', '=', 3)
              ->count();

    $bookTourCount = BookTour::where('b_status', 1)->count();
    $bookTourCount4 = BookTour::where('b_status', 4)->count();
    
    $bookTour = BookTour::count();
    $currentMonth = date('m');

    $bookStatusData = BookTour::select('b_status')
        ->whereMonth('created_at', $currentMonth)
        ->groupBy('b_status')
        ->selectRaw('b_status, COUNT(*) as count')
        ->get()
        ->pluck('count', 'b_status')
        ->toArray();


    $canceledOrdersCount = BookTour::whereIn('b_status', [5])->count();
    $OrdersCount2 = BookTour::whereIn('b_status', [2])->count();
    $OrdersCount4 = BookTour::whereIn('b_status', [4])->count();
    $viewData = [
        'staff' => $staff,
        'bookTour' => $bookTour,
        'tour0' => $tour0,
        'tour1' => $tour1,
        'staffnew' => $staffnew,
        'canceledOrdersCount' =>  $canceledOrdersCount,
        'bannedStaffCount' => $bannedStaffCount,
        'bookTourCount'  => $bookTourCount,
        'tours' => $tours,
        'newestStaffs' => $newestStaffs,
        'bookTourCount4' => $bookTourCount4,
        'favoriteTours' => $favoriteTours,
        'tourstoday' => $tourstoday,
        'today'=>  $today,
        'OrdersCount2'=> $OrdersCount2,
        'OrdersCount4'=> $OrdersCount4,
        'tourtoday' => $tourtoday,
        'bookStatusData' => $bookStatusData
    ];
     return view('admin.revenue_report.index', $viewData);
    }
    public function getRevenueByMonth()
    {
        $revenueByMonth = DB::table('book_tours')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(b_total_price) as total_revenue')
            )
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();
    
        return response()->json($revenueByMonth);
    }
    
    public function getDailyRevenueByMonth($year, $month)
    {
        // Lấy tất cả ngày trong tháng
        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
    
        // Tạo một mảng để lưu trữ doanh thu hàng ngày
        $dailyRevenueData = [];
    
        for ($day = 1; $day <= $daysInMonth; $day++) {
            // Truy vấn cơ sở dữ liệu để lấy doanh thu hàng ngày, nếu có
            $dailyRevenue = DB::table('book_tours')
                ->select(DB::raw('SUM(b_total_price) as daily_revenue'))
                ->whereIn('b_status', [3, 4])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->whereDay('created_at', $day)
                ->value('daily_revenue');
    
            // Đảm bảo rằng ngay cả khi không có doanh thu, ngày cũng sẽ xuất hiện trong dữ liệu
            $dailyRevenueData[] = [
                'day' => $day,
                'daily_revenue' => $dailyRevenue ? $dailyRevenue : 0,
            ];
        }
    
        return response()->json($dailyRevenueData);
    }
    public function getMonthlyRevenueByYear($year)
    {
        // Tạo mảng để lưu trữ doanh thu hàng tháng
        $monthlyRevenueData = [];
    
        for ($month = 1; $month <= 12; $month++) {
            // Truy vấn cơ sở dữ liệu để lấy doanh thu hàng tháng cho từng tháng
            $monthlyRevenue = DB::table('book_tours')
                ->select(DB::raw('SUM(b_total_price) as monthly_revenue'))
                ->whereIn('b_status', [3, 4])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->value('monthly_revenue');
    
            // Đảm bảo rằng ngay cả khi không có doanh thu, tháng cũng sẽ xuất hiện trong dữ liệu
            $monthlyRevenueData[] = [
                'year' => $year,
                'month' => $month,
                'monthly_revenue' => $monthlyRevenue ? $monthlyRevenue : 0,
            ];
        }
    
        return response()->json($monthlyRevenueData);
    }
    public function searchByMonthAndYear(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $bookStatusData = BookTour::select('b_status')
        ->selectRaw('b_status, COUNT(*) as count')
        ->whereMonth('created_at', $month)
        ->whereYear('created_at', $year)
        ->groupBy('b_status')
        ->get()
        ->pluck('count', 'b_status')
        ->toArray();
    
        return response()->json($bookStatusData);
    }
        
    
}
