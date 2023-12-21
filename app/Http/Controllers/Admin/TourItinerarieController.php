<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TourItinerarie;

class TourItinerarieController extends Controller
{
    protected $touritinerarie;

    public function __construct(TourItinerarie $touritinerarie)
    {
        $this->touritinerarie = $touritinerarie;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 

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
            $touritinerarie = new TourItinerarie(); // Sửa lại tên class ở đây
            $touritinerarie->createOrUpdate($request);
            
            \DB::commit();
            return redirect()->back()->with('success', 'Chương trình đã được tạo thành công.');
        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi tạo sự kiện.');
        }
    }
    
    
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
   /**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    \DB::beginTransaction();
    try {
        $this->touritinerarie->createOrUpdate($request, $id);
        \DB::commit();

        return redirect()->back()->with('success', 'Chỉnh sửa dữ liệu thành công');
    } catch (\Exception $exception) {
        \DB::rollBack();
        dd($exception);
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
        $touritinerarie = TourItinerarie::find($id);
        if (!$touritinerarie) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }

        try {
            $touritinerarie->delete();
            return redirect()->back()->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Đã xảy ra lỗi không thể xóa dữ liệu');
        }
    }

   
}
