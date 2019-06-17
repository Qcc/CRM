<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [ 'name', 'boss', 'money', 'moneyType', 'registration', 'status', 'province', 'city', 'area', 'type', 'socialCode', 'phone', 'morePhone', 'address', 'webAddress', 'email', 'businessScope', 'follow', 'contacted',];
    // COMPANY_STATUS_TARGET 目标客户
    // COMPANY_STATUS_LOCKING 锁定中
    // COMPANY_STATUS_FOLLOW 跟进中
    // COMPANY_STATUS_COMPLATE 已完成
    const COMPANY_STATUS_TARGET = 0;
    const COMPANY_STATUS_LOCKING = 1;
    const COMPANY_STATUS_FOLLOW = 2;
    const COMPANY_STATUS_COMPLATE = 3;

    //一个客户可以有多条跟进记录，一对多
    public function records()
    {
        return $this->hasMany(Record::class);
    }

    /**
     * 基础资料关联跟进客户
     *
     * @return void
     */
    public function follow()
    {
        return $this->hasOne(Follow::class);
    }
    /**
     * 基础资料关联正式客户
     *
     * @return void
     */
    public function customer()
    {
        return $this->hasMany(Customer::class);
    }
}
