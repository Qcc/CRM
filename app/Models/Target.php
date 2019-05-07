<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    protected $fillable = [ 'company', 'boss', 'money', 'moneyType', 'registration', 'status', 'province', 'city', 'area', 'type', 'socialCode', 'phone', 'morePhone', 'address', 'webAddress', 'email', 'businessScope', 'follow', 'contacted',];
}
