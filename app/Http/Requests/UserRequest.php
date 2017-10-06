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
            'user.role' => 'required|in:"admin","HR","director","user"',
            'user.status' => 'required|numeric|in:0,1,2',
            'user.employee_no' => 'required|numeric|digits_between:1,7',
            'user.name' => 'required|string|max:20',
            'user.nickname' => 'required|string|max:20',
            'user.birthday' => 'required|Date',
            'user.enter_date' => 'required|Date',
            'user.leave_date' => 'Date|Nullable',
            'user.avatar' => 'image',
            'user.arrive_time' => 'required|in:"0900","0930"',
        ];
    }
}
