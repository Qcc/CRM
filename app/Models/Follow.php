<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [ 
        'user_id', 
        'company_id', 
        'contact', 
        'phone', 
        'product', 
        'difficulties', 
        'expired', 
        'schedule', 
        'money'
    ];

    /**
     * 获得跟进该客户的的客户基础资料
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}
