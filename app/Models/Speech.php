<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speech extends Model
{
    protected $fillable =  ['product', 'ask', 'answer', ];
}
