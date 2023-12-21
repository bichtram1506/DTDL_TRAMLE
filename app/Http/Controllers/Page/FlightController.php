<?php

namespace App\Http\Controllers\Page;

use App\Models\Region;
use App\Http\Controllers\Controller;

class FlightController extends Controller
{
    public function __construct()
    {
        $regions = Region::with('locations')->get(); // Truy vấn regions và locations
        
        view()->share([
            'regions' => $regions, // Truyền biến regions vào view
           
        ]);
    }
  
    public function index()
    {
      
        return view('page.flight.index');
    }

}
