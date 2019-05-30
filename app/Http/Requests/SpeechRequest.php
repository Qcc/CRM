<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SpeechRequest extends FormRequest
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
            'product' => 'required|min:2',
            'ask' => 'required|min:5',
        ];
    }

    public function messages()
    {
        return [
            'product.required' => '适用产品不能为空，无产品可填 “通用”',
            'product.min' => '适用产品最少需要2个字',
            'ask.required' => '客户提问不能为空',
            'ask.min' => '客户体温不能少于5个字',
        ];
    }
}
