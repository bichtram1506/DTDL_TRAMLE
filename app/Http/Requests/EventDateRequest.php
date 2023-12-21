<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventDateRequest extends FormRequest
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
            'td_start_date' => 'required|date',
            'td_end_date' => 'required|date|after_or_equal:' . $this->input('td_start_date'),
        ];
    }

    public function messages()
    {
        return [
            'td_end_date.after_or_equal' => 'Ngày về phải lớn hơn hoặc bằng ngày đi.',
        ];
    }
}
