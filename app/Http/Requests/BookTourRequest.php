<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookTourRequest extends FormRequest
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
            //
         
            'b_address' => 'required',
            'b_number_adults' => 'required',
            'b_number_children' => 'required',
            'b_payment_method' => 'required',
        ];
    }

    public function messages()
    {
        return [
           
            'b_address.required' => 'Vui lòng nhập địa chỉ',
            'b_number_adults.required' => 'Vui lòng nhập số người lớn',
            'b_number_children.required' => 'Vui lòng nhập số trẻ em',
            'b_payment_method.required' => 'Vui lòng chọn phương thức thanh toán'

        ];
    }
}
