<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class TourRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $rules = [
            't_title' => 'required|max:191|unique:tours,t_title,'.$this->id,
            't_day' => 'required|numeric|min:1',
            't_night' => 'required|numeric|min:0',
            't_description' => 'required',
            'images' => 'nullable|image|mimes:jpeg,jpg,png',
        ];
    
        // Kiểm tra điều kiện t_day >= t_night
        $tDay = $request->input('t_day');
        $tNight = $request->input('t_night');
        if ($tDay < $tNight) {
            $rules['t_day'] .= '|gte:t_night';
        }
    
        return $rules;
    }

    public function messages()
    {
        return [
            't_title.required'       => 'Dữ liệu không được phép để trống',
            't_title.max'            => 'Vượt quá số ký tự cho phép',
            't_title.unique'            => 'Dữ liệu đã bị trùng',
            't_day.required'      => 'Dữ liệu không được phép để trống',
            't_description.required'      => 'Dữ liệu không được phép để trống',
            'images.image'                  => 'Vui lòng nhập đúng định dạng file ảnh',
            'images.mimes'                  => 'Vui lòng nhập đúng định dạng file ảnh',
            't_day.required' => 'Dữ liệu không được phép để trống',
            't_day.numeric' => 'Dữ liệu phải là số',
            't_day.min' => 'Dữ liệu phải lớn hơn hoặc bằng 1',
            't_day.gte' => 'Số ngày phải lớn hơn hoặc bằng số đêm',
            't_night.required' => 'Dữ liệu không được phép để trống',
            't_night.numeric' => 'Dữ liệu phải là số',
            't_night.min' => 'Dữ liệu không được âm',
        ];
    }
}
