<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'user.employee_no' => 'required|numeric|digits_between:1,7',
            'user.birthday' => 'required|Date',
            'user.enter_date' => 'required|Date',
            'user.leave_date' => 'Date|Nullable',
            'user.avatar' => 'image',
        ];
    }
}
