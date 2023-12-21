<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CouponCode;
use App\Http\Requests\CouponCodeRequest;


class CouponCodeController extends Controller
{
    protected $couponcode;
    //
    /**
     * HomeController constructor.
     */
    public function __construct(CouponCode $couponcode)
    {
        view()->share([
            'couponcode_active' => 'active',
            'status' => $couponcode::STATUS,
            'classStatus' => $couponcode::CLASS_STATUS,
        ]);
        $this->couponcode = $couponcode;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $couponcodes = CouponCode::select('*');

        if ($request->cc_name) {
            $couponcodes->where('cc_name', 'like', '%'.$request->cc_name.'%');
        }
        if ($request->cc_status) {
            $couponcodes->where('cc_status', $request->cc_status);
        }

        $couponcodes = $couponcodes->orderByDesc('id')->paginate(NUMBER_PAGINATION);

        return view('admin.coupon_code.index', compact('couponcodes','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.coupon_code.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CouponCodeRequest $request)
    {
        //
        \DB::beginTransaction();
        try {
            $this->couponcode->createOrUpdate($request);
            \DB::commit();
            return redirect()->back()->with('success', 'Lưu dữ liệu thành công');
        } catch (\Exception $exception) {
            dd($exception);
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
        $couponcode = CouponCode::findOrFail($id);

        if (!$couponcode) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        return view('admin.coupon_code.edit', compact('couponcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CouponCodeRequest $request, $id)
    {
        //
        \DB::beginTransaction();
        try {
            $this->couponcode->createOrUpdate($request, $id);
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
        $couponcode = CouponCode::find($id);
        if (!$couponcode) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $couponcode->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

}
