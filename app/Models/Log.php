<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Log;

class Log extends Model
{
    protected $fillable = [ 'recording',];

    /**
     * 记录日志
     *
     * @param Log $log
     * @param [type] $info
     * @return void
     */
    public static function write($info)
    {
        $log = new Log;
        $log->recording = $info;
        $log->save();
    }
}
