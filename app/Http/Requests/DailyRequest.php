<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DailyRequest extends FormRequest
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
            'daily.items' => 'required|regex:/^[^　]+$/|max:100',
            'daily.working_day' => 'required|date',
            'daily.project_id' => 'required|numeric',
            'daily.description' => 'nullable',
            'daily.hour' => 'required|numeric',
            'daily.url' => 'nullable',
            'daily.remark' => 'nullable',
            
        ];
    }
}
