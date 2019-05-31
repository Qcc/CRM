<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 
        'company_id', 
        'contact', 
        'phone', 
        'product', 
        'contract', 
        'completion_date', 
        'expired', 
        'contract_money', 
        'comment', 
        'check', 
    ];

    /**
     * 获得跟进该客户的的客户基础资料
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    //一个订单对应一个职员 一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
