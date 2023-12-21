<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attraction;
use App\Models\Location;
use App\Http\Requests\LocationRequest;

class AttractionController extends Controller
{
    protected $attraction;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(Attraction $attraction)
    {
        view()->share([
            'attraction_active' => 'active',
           
        ]);
     
        $this->attraction = $attraction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $attractions = Attraction::select('*');
        $locations = Location::all();
        if ($request->at_name) {
            $attractions->where('at_name', 'like', '%'.$request->at_name.'%');
        }

        $attractions = $attractions->orderByDesc('id')->paginate(NUMBER_PAGINATION);

        return view('admin.region.location.attraction.index', compact('attractions','locations'));
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
            $attraction = new Attraction(); // Sửa lại tên class ở đây
            $attraction->createOrUpdate($request);
            
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
        $attraction = Attraction::findOrFail($id);

        if (!$location) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.location.attraction.edit', compact('attraction'));
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
            $this->attraction->createOrUpdate($request, $id);
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
        $attraction = Attraction::find($id);
        if (!$attraction) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $attraction->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

}
