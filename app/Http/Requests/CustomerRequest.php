<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'completion_date' => 'required|date',
            'contract' => 'required',
            'contract_money' => 'required',
            'comment' => 'required|max:200',
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
            'expired.required' => '售后日期不能为空',
            'expired.date' => '售后日期格式不正确',
            'completion_date.required' => '订单完成日期不能为空',
            'completion_date.date' => '订单完成日期格式不正确',
            'contract.required' => '合同不能为空',
            'contract_money.required' => '成交金额不能为空',
            'comment.required' => '项目备注不能为空',
            'comment.max' => '项目备注不能超过200字',
        ];
    }
}
