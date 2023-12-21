<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\EventDate;
use App\Models\Location;
use App\Http\Requests\TourRequest;
class TourDateController extends Controller
{
    public function __construct( EventDate $eventdate ,Tour $tour)
    {
        view()->share([
            'eventdate_active' => 'active',
            'status' => $eventdate::STATUS,
            'classStatus' => $eventdate::CLASS_STATUS,
            'tours' => $tour->where('t_status', 1)->get()  
        ]);
        $this->evetdate = $eventdate;
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $eventdates = EventDate::with('tour')->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.tourdate.index', compact('eventdates'));
    }
    


}