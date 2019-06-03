<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Follow extends Model
{
    use SoftDeletes;
    protected $fillable = [ 
        'user_id', 
        'company_id', 
        'contact', 
        'phone', 
        'product', 
        'difficulties', 
        'expected_at', 
        'schedule_at', 
        'countdown_at',
        'contract_money'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'expected_at', 
        'schedule_at', 
        'countdown_at',
        // your other new column
    ];

    public function getScheduleAttribute($date) {
        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * 获得跟进该客户的的客户基础资料
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
}
