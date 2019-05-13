<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [ 'name', 'boss', 'money', 'moneyType', 'registration', 'status', 'province', 'city', 'area', 'type', 'socialCode', 'phone', 'morePhone', 'address', 'webAddress', 'email', 'businessScope', 'follow', 'contacted',];

    //一个客户可以有多条跟进记录，一对多
    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
