<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRequest;
use App\Models\Staff;
use App\Models\Role;

class StaffController extends Controller
{
    public function __construct(Role $role)
    {
        view()->share([
            'staff_active' => 'active',
            'roles' => $role->all(),
            
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Staff::query();

        if ($request->name) {
            $users->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->email) {
            $users->where('email', 'like', '%'.$request->email.'%');
        }
        if ($request->phone) {
            $users->where('phone', 'like', '%'.$request->phone.'%');
        }
         
        if ($request->user_id) {
            $users->where('id', $request->user_id);
          
        }
        
        if ($request->role_id) {
            $users->whereHas('roles', function ($query) use ($request) {
                $query->where('role_id', $request->role_id);
            });
        }

        $users = $users->orderByDesc('id')->paginate(NUMBER_PAGINATION);
        return view('admin.staff.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.staff.create');
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
            // Tạo một bản ghi mới của Staff
            $user = new Staff();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = bcrypt($request->password);
            $user->status = $request->status;
    
            // Lưu nhân viên mới vào cơ sở dữ liệu
            $user->save();
    
            // Lấy danh sách các vai trò đã chọn từ biểu mẫu
            $selectedRoles = $request->input('selected_roles', []);
    
            // Gán các vai trò cho nhân viên bằng cách sử dụng phương thức sync
            $user->roles()->sync($selectedRoles);
    
            \DB::commit();
            return redirect()->back()->with('success', 'Thêm mới thành công');
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
        $user = Staff::with('roles')->find($id);
    
        if (!$user) {
            return redirect()->back()->with('danger', 'Nhân viên không tồn tại');
        }
        
    
        $roles = Role::all(); // Lấy danh sách tất cả các vai trò
    
        $viewData = [
            'user' => $user,
            'roles' => $roles,
        ];
    
        return view('admin.staff.edit', $viewData);
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
        \DB::beginTransaction();
    
        try {
            $user = Staff::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->status = $request->status;
    
            // Lưu thông tin cập nhật của nhân viên
            $user->save();
    
            // Lấy danh sách các vai trò đã chọn từ biểu mẫu
            $selectedRoles = $request->input('selected_roles', []);
    
            // Gán lại các vai trò cho nhân viên bằng cách sử dụng phương thức sync
            $user->roles()->sync($selectedRoles);
    
            \DB::commit();
    
            return back()->with('success', 'Cập nhật thành công');

        } catch (\Exception $exception) {
            \DB::rollBack();
            dd($exception);
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi cập nhật dữ liệu');
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
        $user = Staff::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Dữ liệu không tồn tại');
        }
        \DB::beginTransaction();
        try {
            $user->delete();
            \DB::commit();
            return redirect()->back()->with('success','Đã xóa thành công');
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi lưu dữ liệu');
        }
    }
}
