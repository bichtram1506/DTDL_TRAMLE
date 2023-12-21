<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Region;
use App\Models\Attraction;
use App\Http\Requests\LocationRequest;

class LocationController extends Controller
{
    protected $location;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(Location $location)
    {
        view()->share([
            'location_active' => 'active',
          
        ]);
        $this->location = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Location::query();
        $regions = Region::all();
        
        if ($request->has('l_name')) {
            $locations->where('l_name', 'like', '%' . $request->input('l_name') . '%');
        }
    
        $locations = $locations->orderByDesc('id')->paginate(NUMBER_PAGINATION);
    
        return view('admin.region.location.index', compact('locations', 'regions'));
    }
    

    public function showAttraction($id)
    {
        // Lấy thông tin chi tiết tour từ cơ sở dữ liệu
        $location = Location::findOrFail($id);
        
        // Lấy danh sách các eventdate thuộc về tour
        $attractions = Attraction::where('at_location_id', $id)->get();
        // Chuẩn bị mảng $status để sử dụng trong vie
        
        // Trả về view hiển thị danh sách các eventdate thuộc về tour
        return view('admin.region.location.attraction.index', compact('location','attractions'));
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
        \DB::beginTransaction();
        try {
            $location = new Location(); // Sửa lại tên class ở đây
            $location->createOrUpdate($request);
            
            \DB::commit();
            return redirect()->back()->with('success', 'Tạo thành công.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi tạo sự kiện.');
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
        $location = Location::findOrFail($id);

        if (!$location) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.location.edit', compact('location'));
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
        \DB::beginTransaction();
        try {
            $this->location->createOrUpdate($request, $id);
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
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
        $location = Location::find($id);
        if (!$location) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $location->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

}
