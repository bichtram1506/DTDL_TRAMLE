<?php

namespace App\Http\Controllers\Page;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Tour;
use App\Models\Region;
use App\Models\TourType;
use App\Models\Article;
use App\Models\Comment;
use Mail;
class HomeController extends Controller
{
    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
    }
    //
    public function index()
    { 
        
        
        $tourtypes = TourType::get();
        $articles = Article::orderBy('id')->limit(6)->get();
        $locations = Location::get();
        $regions = Region::with('locations')->get(); // Load cả da
        $comments = Comment::with('user')->where('cm_status', 2)->limit(10)->get();
         // Sử dụng truy vấn SQL để tính lượt yêu thích cho mỗi tour
         $tours = Tour::select('tours.*')
         ->addSelect(\DB::raw('(SELECT COUNT(*) FROM favorites WHERE f_tour_id = tours.id) as favorite_count'))
         ->with(['locations']) // Nạp thông tin vị trí cho mỗi tour
         ->where('t_status', 1) // Thêm điều kiện t_status = 1
         ->orderBy('created_at', 'desc')

         ->limit(6)
         ->get();
     
     
     
        $viewData = [
          
            'articles' => $articles,
            'tours' => $tours,
            'comments' => $comments,
            'tourtypes' => $tourtypes,
            'regions' => $regions, // Truyền cả danh sách vùng với thông tin vị trí vào view
            'locations' => $locations
        ];
        return view('page.home.index', $viewData);
    }

    public function contact()
    {
        return view('page.contact.index');
    }

    public function about()
    {
        $comments = Comment::with('user')->where('cm_status', 2)->limit(10)->get();
        return view('page.about.index', compact('comments'));
    }

    public function transport()
    {
        return view('page.transport.index');
    }

    public function changeReturn()
    {
        return view('page.return.index');
    }

    public function security()
    {
        return view('page.security.index');
    }
    
}
