<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TourType;
use App\Models\Tour;
use App\Http\Requests\TourTypeRequest;

class TourTypeController extends Controller
{
    protected $tourtype;
    /**
     * constructor.
     */
    public function __construct(TourType  $tourtype)
    {
        view()->share([
            'tourtype_active' => 'active',
        ]);
        $this->tourtype = $tourtype;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tourtypes = TourType::orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.tour_type.index', compact('tourtypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.tour_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TourTypeRequest $request)
    {
        //
        \DB::beginTransaction();
        try {
            $this->tourtype->createOrUpdate($request);
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
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
        $tourtype = TourType::findOrFail($id);

        if (!$tourtype) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.tour_type.edit', compact('tourtype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TourTypeRequest $request, $id)
    {
        //
        \DB::beginTransaction();
        try {
            $this->tourtype->createOrUpdate($request, $id);
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
        $tourtype = TourType::findOrFail($id);
        if (!$tourtype) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $tourtype->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }
}
