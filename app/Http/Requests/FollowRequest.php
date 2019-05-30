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
            'expected' => 'required|date',
            'schedule' => 'required|date',
            'contract_money' => 'required',
            'difficulties' => 'max:200',
        ];
    }
    public function messages()
    {
        return [
            'company_id.required' => '公司ID不能为空',
            'contact.required' => '联系人不能为空',
            'contact.max' =>'联系人不能超过30个字',
            'phone.required' => '手机号码不能为空',
            'phone.digits' => '手机号码不正确',
            'product.required' =>'购买产品不能为空',
            'product.max' => '产品名称不能超过80个字符',
            'expected.required' => '预计成交日期不能为空',
            'expected.date' => '预计成交日期格式不正确',
            'contract_money.required' => '预计成交金额不能为空',
            'comment.max' => '公关难点能超过200字',
        ];
    }
}