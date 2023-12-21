<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\Location;
use App\Http\Requests\RegionRequest;

class RegionController extends Controller
{
    protected $region;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(Region $region)
    {
        view()->share([
            'region_active' => 'active',
            'status' => $region::STATUS,
        ]);
        $this->region = $region;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $regions = Region::select('*');

        if ($request->r_name) {
            $regions->where('r_name', 'like', '%'.$request->r_name.'%');
        }

        $regions = $regions->orderByDesc('id')->paginate(NUMBER_PAGINATION);

        return view('admin.region.index', compact('regions'));
    }
    public function showLocation($id)
    {
        // Lấy thông tin chi tiết tour từ cơ sở dữ liệu
        $region = Region::findOrFail($id);
        
        // Lấy danh sách các eventdate thuộc về tour
        $locations = Location::where('l_region_id', $id)->get();
        // Chuẩn bị mảng $status để sử dụng trong vie
        
        // Trả về view hiển thị danh sách các eventdate thuộc về tour
        return view('admin.region.location.index', compact('region', 'locations'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.region.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegionRequest $request)
    {
        //
        \DB::beginTransaction();
        try {
            $this->region->createOrUpdate($request);
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
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
        $region = Region::findOrFail($id);

        if (!$region) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.region.edit', compact('region'));
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
            $this->region->createOrUpdate($request, $id);
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
        $region = Region::find($id);
        if (!$region) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $region->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
    

}
