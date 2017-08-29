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
        // if($request->isMethod('post')) {
            return true;
        // } else {
        //     return false;
        // }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user.employee_no' => 'required|numeric',
            'user.birthday' => 'required|Date',
            'user.enter_date' => 'required|Date',
            'user.leave_date' => 'Date|Nullable',
            'user.avatar' => 'image',
        ];
    }
}
