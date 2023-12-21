<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookTour;
use App\Models\Tour;
use App\Models\EventDate;
use App\Models\User;
use App\Models\Staff;


class BespokeTourController extends Controller
{
 
    public function __construct()
    {
        view()->share([
            'bespoketour_active' => 'active',
          
        ]);
    
    }
    public function index(Request $request)
    {
        return view('admin.bespoke_tour.index');
    }

    public function create()
    {
        $tours = Hotel::all(); 
        $locations = Location::all(); 
        $vehicles = Vehicle::all(); // Lấy danh sách khách sạn từ cơ sở dữ liệu
        //
        return view('admin.bespoke_tour.create', compact('hotels','locations','vehicles'));
    }

                       
}
