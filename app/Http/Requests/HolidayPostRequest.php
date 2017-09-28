<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayPostRequest extends FormRequest
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

        'holidies.type' => 'required',
        'holidies.name' => 'required|max:20',
        'holidies.date' => 'required|date|unique:holidays,date,'.$this->holidies['id']

        ];
    }
}
