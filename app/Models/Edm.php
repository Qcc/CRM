<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edm extends Model
{
    /**
     * 与模型关联的表名
     *
     * @var string
     */
    protected $table = 'edmcustomer';

    protected $fillable =  ['name', 'product', 'Unsubscribe'];

}
