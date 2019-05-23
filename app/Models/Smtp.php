<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    // 只允许用户修改content字段
    protected $fillable = [
        'user_id', 
        'smtp', 
        'port', 
        'username', 
        'password', 
        'max', 
    ];
    protected $hidden = [
        'password',
    ];

    //一条反馈对应一个反馈职员 一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
