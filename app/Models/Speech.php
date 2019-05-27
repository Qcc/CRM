<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speech extends Model
{
    protected $fillable =  ['product', 'user_id', 'ask', 'answer', ];
    //一条反馈对应一个反馈职员 一对一关系
    public function user()
    {
        return $this->belongsTo(User::class);
    } 
}
