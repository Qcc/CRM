<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    // 只允许用户修改content字段
    protected $fillable = ['content'];

    //一条反馈只属于一个客户，属于一对一关系
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    //一条反馈对应一个反馈职员 一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
