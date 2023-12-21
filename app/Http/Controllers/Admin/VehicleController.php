<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Http\Requests\LocationRequest;

class VehicleController extends Controller
{
    protected $vehicle;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(Vehicle $vehicle)
    {
        view()->share([
            'vehicle_active' => 'active',
        ]);
        $this->vehicle = $vehicle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $vehicles = Vehicle::select('*');

        $vehicles = $vehicles->orderByDesc('id')->paginate(NUMBER_PAGINATION);

        return view('admin.vehicle.index', compact('vehicles'));
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
            $vehicle = new Vehicle(); // Sửa lại tên class ở đây
            $vehicle->createOrUpdate($request);
            
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
            $this->vehicle->createOrUpdate($request, $id);
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
        $vehicle = Vehicle::find($id);
        if (!$vehicle) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $vehicle->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

}
