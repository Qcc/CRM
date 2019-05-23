<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends FormRequest
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
            'company_id' => 'required|integer|unique:customers,company_id',
            'contact' => 'required|max:30',
            'phone' => 'required|digits:11',
            'product' => 'required|max:80',
            'expired' => 'required|date',
            'schedule' => 'required|date',
            'money' => 'required',
            'difficulties' => 'required|max:200',
        ];
    }
}