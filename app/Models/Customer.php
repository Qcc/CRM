<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id', 
        'company_id', 
        'contact', 
        'phone', 
        'product', 
        'contract', 
        'completion_date', 
        'expired', 
        'money', 
        'comment', 
    ];

    /**
     * 获得跟进该客户的的客户基础资料
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
