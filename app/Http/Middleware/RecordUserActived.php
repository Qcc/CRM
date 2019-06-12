<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RecordUserActived
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 如果是登录用户的话
        if (Auth::check()) {
            // 记录用户操作
            Auth::user()->recordUserActived($request);
        }
        return $next($request);
    }
}
