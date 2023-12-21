<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cc_name' => 'required',
            'cc_start_date' => 'required',
            'cc_expiry_date' => 'required|after:cc_start_date', // Thêm quy tắc ngày kết thúc phải lớn hơn ngày bắt đầu
            'cc_remaining_code' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'cc_name.required' => 'Vui lòng nhập tên mã',
            'cc_start_date.required' => 'Vui lòng nhập ngày bắt đầu',
            'cc_expiry_date.required' => 'Vui lòng nhập ngày kết thúc',
            'cc_expiry_date.after' => 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
            'cc_remaining_code.required' => 'Vui lòng chọn lượt sử dụng'
        ];
    }
}
