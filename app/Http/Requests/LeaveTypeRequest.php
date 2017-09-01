<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveTypeRequest extends FormRequest
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
            'leave_type.name' => 'required',
            'leave_type.hours' => 'required|numeric',
            'leave_type.exception' => 'required',
            'leave_type.reset_time' => 'required',
            'leave_type.start_time' => 'date|nullable',
            'leave_type.end_time' => 'date|nullable',
        ];
    }
}
